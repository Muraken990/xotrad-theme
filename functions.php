<?php
/**
 * World One Trading Theme Functions
 *
 * @package WorldOneTrading
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WOT_VERSION', '2.14.22');
define('WOT_DIR', get_template_directory());
define('WOT_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function wot_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'worldonetrading'),
        'footer'  => __('Footer Menu', 'worldonetrading'),
    ));

    // Image sizes
    add_image_size('product-card', 600, 800, true);    // 3:4 ratio
    add_image_size('product-thumb', 150, 200, true);   // 3:4 ratio
    add_image_size('hero-image', 1920, 1080, true);
}
add_action('after_setup_theme', 'wot_setup');

/**
 * Enqueue Scripts & Styles
 */
function wot_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'wot-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Raleway:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Material Symbols
    wp_enqueue_style(
        'wot-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        array(),
        null
    );

    // Theme stylesheet
    wp_enqueue_style(
        'wot-style',
        get_stylesheet_uri(),
        array(),
        WOT_VERSION
    );

    // Theme JavaScript
    wp_enqueue_script(
        'wot-theme',
        WOT_URI . '/assets/js/theme.js',
        array(),
        WOT_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script('wot-theme', 'wotData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('wot_nonce'),
        'shopUrl' => get_permalink(wc_get_page_id('shop')),
        'cartUrl' => wc_get_cart_url(),
    ));

    // WooCommerce cart fragment for AJAX cart updates
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'wot_scripts');

/**
 * WooCommerce Support
 */
function wot_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 600,
        'gallery_thumbnail_image_width' => 150,
        'single_image_width' => 900,
    ));
}
add_action('after_setup_theme', 'wot_woocommerce_setup');

/**
 * Remove WooCommerce default styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Disable WooCommerce block-based cart and checkout
 * Force classic shortcode templates
 */
add_filter('woocommerce_use_blockified_product_grid_block_type', '__return_false');

/**
 * Override cart and checkout page templates
 */
function wot_woocommerce_page_templates($template) {
    // Cart page
    if (function_exists('is_cart') && is_cart()) {
        $custom_template = get_template_directory() . '/page-cart.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    // Checkout page (including order-received/thankyou)
    if (function_exists('is_checkout') && is_checkout()) {
        $custom_template = get_template_directory() . '/page-checkout.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    return $template;
}
add_filter('template_include', 'wot_woocommerce_page_templates', 999);

/**
 * Change products per page (12 for 4x3 grid on collection page)
 */
function wot_products_per_page($cols) {
    return 12;
}
add_filter('loop_shop_per_page', 'wot_products_per_page');

/**
 * Change product columns (4 columns for collection layout)
 */
function wot_loop_columns() {
    return 4;
}
add_filter('loop_shop_columns', 'wot_loop_columns');

/**
 * Cart count AJAX fragment
 */
function wot_cart_count_fragment($fragments) {
    $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'wot_cart_count_fragment');

/**
 * Custom breadcrumb settings
 * 共通クラス .page-breadcrumb を使用
 */
function wot_breadcrumb_defaults($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-sep">/</span> ';
    $defaults['wrap_before'] = '<nav class="page-breadcrumb">';
    $defaults['wrap_after'] = '</nav>';
    $defaults['before'] = '<span class="breadcrumb-item">';
    $defaults['after'] = '</span>';
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'wot_breadcrumb_defaults');

/**
 * Customize breadcrumb labels
 */
function wot_breadcrumb_labels($crumbs) {
    foreach ($crumbs as $key => $crumb) {
        // Change "Order received" to "Order Confirmed"
        if ($crumb[0] === 'Order received') {
            $crumbs[$key][0] = 'Order Confirmed';
        }
    }
    return $crumbs;
}
add_filter('woocommerce_get_breadcrumb', 'wot_breadcrumb_labels');

/**
 * Remove default WooCommerce hooks and reposition
 */
function wot_woocommerce_hooks() {
    // Remove default product loop wrapper
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Remove sidebar
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    // Remove default sorting and result count (we handle these in archive-product.php)
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

    // Remove related products default output
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}
add_action('init', 'wot_woocommerce_hooks');

/**
 * Get product brands
 */
function wot_get_brands() {
    $brands = array(
        'HERMES'        => 'Hermès',
        'GUCCI'         => 'Gucci',
        'DIOR'          => 'Dior',
        'LOUIS VUITTON' => 'Louis Vuitton',
        'CHANEL'        => 'Chanel',
        'PRADA'         => 'Prada',
        'BURBERRY'      => 'Burberry',
        'FENDI'         => 'Fendi',
        'CELINE'        => 'Céline',
        'GIVENCHY'      => 'Givenchy',
    );
    return apply_filters('wot_brands', $brands);
}

/**
 * Register product brand taxonomy
 */
function wot_register_brand_taxonomy() {
    register_taxonomy('product_brand', 'product', array(
        'label'        => __('Brand', 'worldonetrading'),
        'hierarchical' => false,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'brand'),
    ));
}
add_action('init', 'wot_register_brand_taxonomy');

/**
 * Register product condition taxonomy
 */
function wot_register_condition_taxonomy() {
    register_taxonomy('product_condition', 'product', array(
        'label'        => __('Condition', 'worldonetrading'),
        'hierarchical' => false,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'condition'),
    ));
}
add_action('init', 'wot_register_condition_taxonomy');

/**
 * Disable WooCommerce reviews
 */
function wot_disable_reviews($open, $post_id) {
    if (get_post_type($post_id) === 'product') {
        return false;
    }
    return $open;
}
add_filter('comments_open', 'wot_disable_reviews', 10, 2);

/**
 * Add body classes
 */
function wot_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    if (class_exists('WooCommerce')) {
        if (is_shop() || is_product_category() || is_product_tag()) {
            $classes[] = 'shop-page';
        }
    }
    return $classes;
}
add_filter('body_class', 'wot_body_classes');

/**
 * Custom excerpt length
 */
function wot_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'wot_excerpt_length');

/**
 * AJAX add to cart for single product
 */
function wot_ajax_add_to_cart() {
    check_ajax_referer('wot_nonce', 'nonce');

    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity'] ?? 1);

    if ($product_id) {
        $added = WC()->cart->add_to_cart($product_id, $quantity);
        if ($added) {
            wp_send_json_success(array(
                'cart_count' => WC()->cart->get_cart_contents_count(),
                'cart_total' => WC()->cart->get_cart_total(),
            ));
        }
    }

    wp_send_json_error();
}
add_action('wp_ajax_wot_add_to_cart', 'wot_ajax_add_to_cart');
add_action('wp_ajax_nopriv_wot_add_to_cart', 'wot_ajax_add_to_cart');

/**
 * Set free shipping for all orders
 */
function wot_free_shipping_label($label, $method) {
    if ($method->method_id === 'free_shipping') {
        $label = __('Free Worldwide Shipping', 'worldonetrading');
    }
    return $label;
}
add_filter('woocommerce_cart_shipping_method_full_label', 'wot_free_shipping_label', 10, 2);

/**
 * Customize WooCommerce currency
 */
function wot_currency_symbol($symbol, $currency) {
    if ($currency === 'USD') {
        return '$';
    }
    return $symbol;
}
add_filter('woocommerce_currency_symbol', 'wot_currency_symbol', 10, 2);

/**
 * Meta (Facebook/Instagram) Checkout URL Handler
 * Parses ?products=SKU:QTY,SKU:QTY&coupon=CODE and redirects to WooCommerce checkout
 */
function wot_meta_checkout_handler() {
    if (!isset($_GET['products']) || !class_exists('WooCommerce')) {
        return;
    }

    $products_param = sanitize_text_field($_GET['products']);
    $coupon = isset($_GET['coupon']) ? sanitize_text_field($_GET['coupon']) : '';

    WC()->cart->empty_cart();

    $entries = explode(',', $products_param);
    foreach ($entries as $entry) {
        $parts = explode(':', $entry);
        $sku = $parts[0] ?? '';
        $qty = intval($parts[1] ?? 1);

        if (empty($sku) || $qty < 1) {
            continue;
        }

        $product_id = wc_get_product_id_by_sku($sku);
        if ($product_id) {
            WC()->cart->add_to_cart($product_id, $qty);
        }
    }

    if ($coupon && wc_get_coupon_id_by_code($coupon)) {
        WC()->cart->apply_coupon($coupon);
    }

    wp_safe_redirect(wc_get_checkout_url());
    exit;
}
add_action('template_redirect', 'wot_meta_checkout_handler');

/**
 * Include WooCommerce template functions
 */
require_once WOT_DIR . '/inc/woocommerce.php';

/**
 * Collection Page Filter Query Handler
 * Filters products based on URL parameters
 */
function wot_collection_filter_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        $tax_query = array();

        // Brand filter
        if (!empty($_GET['brand'])) {
            $brands = is_array($_GET['brand']) ? $_GET['brand'] : array($_GET['brand']);
            $brands = array_map('sanitize_text_field', $brands);
            $tax_query[] = array(
                'taxonomy' => 'product_brand',
                'field'    => 'slug',
                'terms'    => $brands,
                'operator' => 'IN',
            );
        }

        // Condition filter
        if (!empty($_GET['condition'])) {
            $conditions = is_array($_GET['condition']) ? $_GET['condition'] : array($_GET['condition']);
            $conditions = array_map('sanitize_text_field', $conditions);
            $tax_query[] = array(
                'taxonomy' => 'product_condition',
                'field'    => 'slug',
                'terms'    => $conditions,
                'operator' => 'IN',
            );
        }

        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            $query->set('tax_query', $tax_query);
        }

        // Sorting
        if (!empty($_GET['orderby'])) {
            $orderby = sanitize_text_field($_GET['orderby']);
            switch ($orderby) {
                case 'price-asc':
                    $query->set('orderby', 'meta_value_num');
                    $query->set('meta_key', '_price');
                    $query->set('order', 'ASC');
                    break;
                case 'price-desc':
                    $query->set('orderby', 'meta_value_num');
                    $query->set('meta_key', '_price');
                    $query->set('order', 'DESC');
                    break;
                case 'title':
                    $query->set('orderby', 'title');
                    $query->set('order', 'ASC');
                    break;
                case 'date':
                default:
                    $query->set('orderby', 'date');
                    $query->set('order', 'DESC');
                    break;
            }
        }
    }
}
add_action('pre_get_posts', 'wot_collection_filter_query');

/**
 * Get active filters from URL
 */
function wot_get_active_filters() {
    $active = array();

    if (!empty($_GET['brand'])) {
        $brands = is_array($_GET['brand']) ? $_GET['brand'] : array($_GET['brand']);
        foreach ($brands as $brand_slug) {
            $term = get_term_by('slug', sanitize_text_field($brand_slug), 'product_brand');
            if ($term) {
                $active[] = array(
                    'type'  => 'brand',
                    'slug'  => $term->slug,
                    'name'  => $term->name,
                    'label' => 'Brand: ' . $term->name,
                );
            }
        }
    }

    if (!empty($_GET['condition'])) {
        $conditions = is_array($_GET['condition']) ? $_GET['condition'] : array($_GET['condition']);
        foreach ($conditions as $condition_slug) {
            $term = get_term_by('slug', sanitize_text_field($condition_slug), 'product_condition');
            if ($term) {
                $active[] = array(
                    'type'  => 'condition',
                    'slug'  => $term->slug,
                    'name'  => $term->name,
                    'label' => 'Condition: ' . $term->name,
                );
            }
        }
    }

    return $active;
}

/**
 * Generate URL to remove a specific filter
 */
function wot_remove_filter_url($type, $slug) {
    $params = $_GET;

    if (isset($params[$type])) {
        if (is_array($params[$type])) {
            $params[$type] = array_diff($params[$type], array($slug));
            if (empty($params[$type])) {
                unset($params[$type]);
            }
        } else {
            unset($params[$type]);
        }
    }

    $base_url = get_permalink(wc_get_page_id('shop'));
    return !empty($params) ? add_query_arg($params, $base_url) : $base_url;
}

/**
 * Check if a filter is currently active
 */
function wot_is_filter_active($type, $slug) {
    if (empty($_GET[$type])) {
        return false;
    }

    $values = is_array($_GET[$type]) ? $_GET[$type] : array($_GET[$type]);
    return in_array($slug, $values);
}

/**
 * Generate URL to add a filter
 */
function wot_add_filter_url($type, $slug) {
    $params = $_GET;

    if (!isset($params[$type])) {
        $params[$type] = array();
    } elseif (!is_array($params[$type])) {
        $params[$type] = array($params[$type]);
    }

    if (!in_array($slug, $params[$type])) {
        $params[$type][] = $slug;
    }

    $base_url = get_permalink(wc_get_page_id('shop'));
    return add_query_arg($params, $base_url);
}

/**
 * Generate URL to toggle a filter (add if not active, remove if active)
 */
function wot_toggle_filter_url($type, $slug) {
    if (wot_is_filter_active($type, $slug)) {
        return wot_remove_filter_url($type, $slug);
    }
    return wot_add_filter_url($type, $slug);
}

/**
 * Get clear all filters URL
 */
function wot_clear_filters_url() {
    $params = $_GET;
    unset($params['brand']);
    unset($params['condition']);

    $base_url = get_permalink(wc_get_page_id('shop'));
    return !empty($params) ? add_query_arg($params, $base_url) : $base_url;
}

/**
 * Get product count for a specific taxonomy term
 */
function wot_get_term_product_count($taxonomy, $term_slug) {
    $term = get_term_by('slug', $term_slug, $taxonomy);
    if ($term) {
        return $term->count;
    }
    return 0;
}

/* Order Confirmation Modal - Moved to plugin: wc-order-confirmation-modal */
