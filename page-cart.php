<?php
/**
 * Template Name: Cart Page
 * Custom Cart Page Template
 *
 * @package WorldOneTrading
 */

get_header();

// Check if cart has items
if (WC()->cart->is_empty()) {
    wc_get_template('cart/cart-empty.php');
} else {
    wc_get_template('cart/cart.php');
}

get_footer();
