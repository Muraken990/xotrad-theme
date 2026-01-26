<?php
/**
 * Template Name: Checkout Page
 * Custom Checkout Page Template (Checkout & Thank You)
 *
 * @package WorldOneTrading
 */

get_header();

// Determine page title based on endpoint
$page_title = 'Checkout';
if (is_wc_endpoint_url('order-received')) {
    $page_title = 'Order Confirmed';
} elseif (is_wc_endpoint_url('order-pay')) {
    $page_title = 'Pay for Order';
}
?>

<main class="page-wrapper checkout-page">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <?php woocommerce_breadcrumb(); ?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
        </div>

        <!-- Checkout Content -->
        <?php echo do_shortcode('[woocommerce_checkout]'); ?>
    </div>
</main>

<?php
get_footer();
?>
