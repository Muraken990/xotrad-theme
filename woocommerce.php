<?php
/**
 * WooCommerce Main Template Wrapper
 * Routes to the appropriate custom template based on page type.
 *
 * @package WorldOneTrading
 */

if (is_product()) {
    // Single product page - use custom template
    get_template_part('woocommerce/single-product');
} elseif (is_shop() || is_product_category() || is_product_tag() || is_tax('product_brand')) {
    // Shop/archive pages - use custom template
    get_template_part('woocommerce/archive-product');
} else {
    // Cart, Checkout, Account, etc. - generic wrapper
    get_header();
    ?>
    <main class="site-main woocommerce-page">
        <div class="container">
            <?php woocommerce_content(); ?>
        </div>
    </main>
    <?php
    get_footer();
}
?>
