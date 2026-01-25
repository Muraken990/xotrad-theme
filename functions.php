<?php
/**
 * World One Trading Theme Functions
 *
 * @package WorldOneTrading
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WOT_VERSION', '1.0.0');
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
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&display=swap',
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
 * Change products per page
 */
function wot_products_per_page($cols) {
    return 12;
}
add_filter('loop_shop_per_page', 'wot_products_per_page');

/**
 * Change product columns
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
 * Custom breadcrumb separator
 */
function wot_breadcrumb_defaults($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-sep">/</span> ';
    $defaults['wrap_before'] = '<nav class="wot-breadcrumb"><div class="container">';
    $defaults['wrap_after'] = '</div></nav>';
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'wot_breadcrumb_defaults');

/**
 * Remove default WooCommerce hooks and reposition
 */
function wot_woocommerce_hooks() {
    // Remove default product loop wrapper
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Remove sidebar
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    // Remove default sorting
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

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
 * Include WooCommerce template functions
 */
require_once WOT_DIR . '/inc/woocommerce.php';
