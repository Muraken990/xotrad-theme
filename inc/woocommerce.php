<?php
/**
 * WooCommerce Customization Functions
 *
 * @package WorldOneTrading
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disable WooCommerce default stylesheets (use theme CSS only)
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Override WooCommerce page titles to English
 */
function wot_shop_page_title($title) {
    if (is_shop()) {
        return 'Shop';
    }
    if (is_product_category()) {
        return single_cat_title('', false);
    }
    return $title;
}
add_filter('woocommerce_page_title', 'wot_shop_page_title');

/**
 * Customize WooCommerce product sorting options
 */
function wot_custom_sorting_options($options) {
    $options = array(
        'date'       => __('Newest First', 'worldonetrading'),
        'price'      => __('Price: Low to High', 'worldonetrading'),
        'price-desc' => __('Price: High to Low', 'worldonetrading'),
        'title'      => __('Alphabetical', 'worldonetrading'),
    );
    return $options;
}
add_filter('woocommerce_catalog_orderby', 'wot_custom_sorting_options');

/**
 * Set default product sorting
 */
function wot_default_sorting($args) {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}
add_filter('woocommerce_get_catalog_ordering_args', 'wot_default_sorting');

/**
 * Remove WooCommerce tabs on single product
 */
function wot_remove_product_tabs($tabs) {
    unset($tabs['reviews']);
    unset($tabs['additional_information']);
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'wot_remove_product_tabs', 98);

/**
 * Set single product to quantity 1 only (unique luxury items)
 */
function wot_max_quantity($args, $product) {
    $args['max_value'] = 1;
    $args['min_value'] = 1;
    return $args;
}
add_filter('woocommerce_quantity_input_args', 'wot_max_quantity', 10, 2);

/**
 * After product added to cart, reduce stock to 0 (one-of-a-kind items)
 */
function wot_reduce_stock_on_add_to_cart($cart_item_key, $product_id) {
    $product = wc_get_product($product_id);
    if ($product && $product->managing_stock()) {
        // Don't reduce here - let WooCommerce handle stock on order
    }
}

/**
 * Customize checkout fields
 */
function wot_checkout_fields($fields) {
    // Make company field optional
    $fields['billing']['billing_company']['required'] = false;

    // Remove order notes
    unset($fields['order']['order_comments']);

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wot_checkout_fields');

/**
 * Add product brand to order item meta
 */
function wot_add_brand_to_order_item($item, $cart_item_key, $values, $order) {
    $product_id = $item->get_product_id();
    $brand_terms = get_the_terms($product_id, 'product_brand');
    if ($brand_terms) {
        $item->add_meta_data('Brand', $brand_terms[0]->name);
    }
    $condition_terms = get_the_terms($product_id, 'product_condition');
    if ($condition_terms) {
        $item->add_meta_data('Condition', $condition_terms[0]->name);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'wot_add_brand_to_order_item', 10, 4);

/**
 * Customize empty cart message
 */
function wot_empty_cart_message() {
    echo '<div class="cart-empty">';
    echo '<h2>Your cart is empty</h2>';
    echo '<p>Discover our curated collection of luxury items from Japan.</p>';
    echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="btn-secondary">Continue Shopping</a>';
    echo '</div>';
}
remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);
add_action('woocommerce_cart_is_empty', 'wot_empty_cart_message', 10);

/**
 * Add custom thank you page content
 */
function wot_thankyou_text($text, $order) {
    return $text . '<span class="thankyou-shipping-note">Your luxury item will be carefully packaged and shipped from Japan with tracking. You will receive a shipping confirmation email with your tracking number.</span>';
}
add_filter('woocommerce_thankyou_order_received_text', 'wot_thankyou_text', 10, 2);
