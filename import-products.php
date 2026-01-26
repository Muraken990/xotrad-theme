<?php
/**
 * eBay to WooCommerce Product Importer
 *
 * Usage: Access via browser at /wp-content/themes/worldonetrading-theme/import-products.php?run=1&limit=10
 */

// Load WordPress
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    die('Access denied. Please login as admin.');
}

// Check if run parameter is set
if (!isset($_GET['run'])) {
    echo '<h1>eBay Product Importer</h1>';
    echo '<p>Add ?run=1 to URL to start import</p>';
    echo '<p>Add &limit=10 to limit number of products</p>';
    echo '<p>Add &offset=0 to skip products</p>';
    echo '<p>Add &images_only=1 to only import products with images</p>';
    echo '<p>Example: <a href="?run=1&limit=10&images_only=1">?run=1&limit=10&images_only=1</a></p>';
    exit;
}

// Settings
$csv_path = '/Users/muramatsukenji/Downloads/eBay-all-active-listings-report-2026-01-24-13278071878.csv';
$images_path = '/Users/muramatsukenji/Desktop/MERCARI/image-processor/processed';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 0;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$images_only = isset($_GET['images_only']) ? true : false;

echo '<h1>Importing Products...</h1>';
echo '<pre>';

// Read CSV
$csv_content = file_get_contents($csv_path);
// Remove BOM if present
$csv_content = preg_replace('/^\xEF\xBB\xBF/', '', $csv_content);
$lines = explode("\n", $csv_content);
$csv = array_map('str_getcsv', $lines);
$headers = array_shift($csv);

// Clean headers (remove any remaining BOM or whitespace)
$headers = array_map('trim', $headers);

// Create header map
$header_map = array_flip($headers);

// Debug: Show headers
echo "Headers found: " . implode(', ', array_keys($header_map)) . "\n\n";

$imported = 0;
$skipped = 0;
$errors = 0;
$current = 0;

foreach ($csv as $row) {
    $current++;

    // Skip if offset
    if ($current <= $offset) {
        continue;
    }

    // Skip empty rows
    if (count($row) < 5) {
        continue;
    }

    // Get data safely
    $sku = isset($header_map['Custom label (SKU)']) && isset($row[$header_map['Custom label (SKU)']])
        ? trim($row[$header_map['Custom label (SKU)']]) : '';
    $title = isset($header_map['Title']) && isset($row[$header_map['Title']])
        ? trim($row[$header_map['Title']]) : '';
    $price = isset($header_map['Current price']) && isset($row[$header_map['Current price']])
        ? floatval($row[$header_map['Current price']]) : 0;
    $condition = isset($header_map['Condition']) && isset($row[$header_map['Condition']])
        ? trim($row[$header_map['Condition']]) : '';
    $category = isset($header_map['eBay category 1 name']) && isset($row[$header_map['eBay category 1 name']])
        ? trim($row[$header_map['eBay category 1 name']]) : '';
    $ebay_id = isset($header_map['Item number']) && isset($row[$header_map['Item number']])
        ? trim($row[$header_map['Item number']]) : '';

    if (empty($sku) || empty($title)) {
        $skipped++;
        continue;
    }

    // Check if images exist
    $image_files = glob($images_path . '/' . $sku . '_*.jpg');

    if ($images_only && empty($image_files)) {
        $skipped++;
        continue;
    }

    // Check if product already exists
    $existing = wc_get_product_id_by_sku($sku);
    if ($existing) {
        echo "SKU {$sku} already exists, skipping...\n";
        $skipped++;
        continue;
    }

    // Extract brand from title
    $brand = extract_brand($title);

    // Clean title
    $clean_title = clean_title($title, $brand);

    // Map condition
    $wc_condition = map_condition($condition);

    echo "Importing: {$clean_title} (SKU: {$sku}, Brand: {$brand}, Price: \${$price})\n";

    try {
        // Create product
        $product = new WC_Product_Simple();
        $product->set_name($clean_title);
        $product->set_sku($sku);
        $product->set_regular_price($price);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_manage_stock(true);
        $product->set_stock_quantity(1);
        $product->set_stock_status('instock');

        // Save product first to get ID
        $product_id = $product->save();

        if (!$product_id) {
            echo "  ERROR: Failed to create product\n";
            $errors++;
            continue;
        }

        // Set brand taxonomy
        if ($brand) {
            $brand_term = get_or_create_term($brand, 'product_brand');
            if ($brand_term) {
                wp_set_object_terms($product_id, $brand_term, 'product_brand');
            }
        }

        // Set condition taxonomy
        if ($wc_condition) {
            $condition_term = get_or_create_term($wc_condition, 'product_condition');
            if ($condition_term) {
                wp_set_object_terms($product_id, $condition_term, 'product_condition');
            }
        }

        // Set category
        if ($category) {
            $cat_term = get_or_create_term($category, 'product_cat');
            if ($cat_term) {
                wp_set_object_terms($product_id, $cat_term, 'product_cat');
            }
        }

        // Import images
        if (!empty($image_files)) {
            sort($image_files); // Ensure proper order
            $image_ids = [];

            foreach ($image_files as $index => $image_file) {
                $attachment_id = import_image($image_file, $product_id, $clean_title . ' - Image ' . ($index + 1));
                if ($attachment_id) {
                    $image_ids[] = $attachment_id;
                    echo "  - Imported image: " . basename($image_file) . "\n";
                }
            }

            // Set featured image and gallery
            if (!empty($image_ids)) {
                $product->set_image_id($image_ids[0]);
                if (count($image_ids) > 1) {
                    $product->set_gallery_image_ids(array_slice($image_ids, 1));
                }
                $product->save();
            }
        }

        echo "  SUCCESS: Product ID {$product_id}\n\n";
        $imported++;

    } catch (Exception $e) {
        echo "  ERROR: " . $e->getMessage() . "\n";
        $errors++;
    }

    // Check limit
    if ($limit > 0 && $imported >= $limit) {
        break;
    }
}

echo "\n=== IMPORT COMPLETE ===\n";
echo "Imported: {$imported}\n";
echo "Skipped: {$skipped}\n";
echo "Errors: {$errors}\n";
echo '</pre>';

/**
 * Extract brand from title
 */
function extract_brand($title) {
    $brands = [
        'TOM FORD' => 'Tom Ford',
        'TOMFORD' => 'Tom Ford',
        'Brioni' => 'Brioni',
        'BRIONI' => 'Brioni',
        'Hermes' => 'Hermès',
        'HERMES' => 'Hermès',
        'Hermès' => 'Hermès',
        'Giorgio Armani' => 'Giorgio Armani',
        'GIORGIO ARMANI' => 'Giorgio Armani',
        'Ermenegildo Zegna' => 'Ermenegildo Zegna',
        'ERMENEGILDO ZEGNA' => 'Ermenegildo Zegna',
        'Gucci' => 'Gucci',
        'GUCCI' => 'Gucci',
        'Louis Vuitton' => 'Louis Vuitton',
        'LOUIS VUITTON' => 'Louis Vuitton',
        'Chanel' => 'Chanel',
        'CHANEL' => 'Chanel',
        'Prada' => 'Prada',
        'PRADA' => 'Prada',
        'Burberry' => 'Burberry',
        'BURBERRY' => 'Burberry',
        'Fendi' => 'Fendi',
        'FENDI' => 'Fendi',
        'Celine' => 'Céline',
        'CELINE' => 'Céline',
        'Givenchy' => 'Givenchy',
        'GIVENCHY' => 'Givenchy',
        'Dior' => 'Dior',
        'DIOR' => 'Dior',
        'Italo Ferretti' => 'Italo Ferretti',
        'ERRICO FORMICOLA' => 'Errico Formicola',
    ];

    foreach ($brands as $search => $display) {
        if (stripos($title, $search) !== false) {
            return $display;
        }
    }

    // Try to extract first word as brand
    $words = explode(' ', $title);
    if (!empty($words[0])) {
        return ucfirst(strtolower($words[0]));
    }

    return '';
}

/**
 * Clean title - remove brand prefix and condition markers
 */
function clean_title($title, $brand) {
    // Remove common prefixes
    $prefixes = [
        '【Mint Condition】',
        '【 Mint Condition 】',
        '【Excellent Condition】',
        '【Nearly Unused】',
        '【New】',
        '【Rare】',
        '【Price Drop】',
        '【Price Reduced Again Vintage】',
        '[Price Reduced Again Vintage]',
        'Mint Condition',
        'Excellent Condition',
        'Unused Condition',
        'Unused Grade',
        'Gently Used',
        'Final Price',
        'Final Price Drop Today:',
        'Immediate Sale',
        '#',
    ];

    $clean = $title;
    foreach ($prefixes as $prefix) {
        $clean = str_ireplace($prefix, '', $clean);
    }

    // Remove brand from beginning if duplicated
    if ($brand) {
        $patterns = [
            '/^' . preg_quote($brand, '/') . '\s+' . preg_quote($brand, '/') . '\s+/i',
            '/^' . preg_quote($brand, '/') . '\s+/i',
        ];
        foreach ($patterns as $pattern) {
            $clean = preg_replace($pattern, '', $clean);
        }
    }

    // Clean up whitespace
    $clean = preg_replace('/\s+/', ' ', $clean);
    $clean = trim($clean);

    // Add brand back to beginning if needed
    if ($brand && stripos($clean, $brand) === false) {
        $clean = $brand . ' ' . $clean;
    }

    return $clean;
}

/**
 * Map eBay condition to WooCommerce condition
 */
function map_condition($ebay_condition) {
    $map = [
        'New with tags' => 'New with Tags',
        'New without tags' => 'New without Tags',
        'Pre-owned - Good' => 'Pre-owned Good',
        'Pre-owned - Excellent' => 'Pre-owned Excellent',
        'Pre-owned' => 'Pre-owned',
    ];

    return $map[$ebay_condition] ?? $ebay_condition;
}

/**
 * Get or create taxonomy term
 */
function get_or_create_term($name, $taxonomy) {
    $term = get_term_by('name', $name, $taxonomy);
    if ($term) {
        return $term->term_id;
    }

    $result = wp_insert_term($name, $taxonomy);
    if (!is_wp_error($result)) {
        return $result['term_id'];
    }

    return null;
}

/**
 * Import image to WordPress media library
 */
function import_image($file_path, $post_id, $title) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Get file info
    $filename = basename($file_path);
    $filetype = wp_check_filetype($filename);

    // Upload directory
    $upload_dir = wp_upload_dir();
    $new_file = $upload_dir['path'] . '/' . $filename;

    // Copy file to uploads
    if (!copy($file_path, $new_file)) {
        return false;
    }

    // Create attachment
    $attachment = [
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name($title),
        'post_content' => '',
        'post_status' => 'inherit',
    ];

    $attachment_id = wp_insert_attachment($attachment, $new_file, $post_id);

    if (!is_wp_error($attachment_id)) {
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $new_file);
        wp_update_attachment_metadata($attachment_id, $attachment_data);
        return $attachment_id;
    }

    return false;
}
