<?php
/**
 * Checkout Form
 *
 * @package WorldOneTrading
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <div class="checkout-layout">
        <div class="checkout-fields">
            <?php if ($checkout->get_checkout_fields()) : ?>

                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <div class="checkout-section">
                    <h3 class="checkout-section-title">Shipping Details</h3>
                    <?php do_action('woocommerce_checkout_billing'); ?>
                </div>

                <div class="checkout-section">
                    <?php do_action('woocommerce_checkout_shipping'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>
        </div>

        <div class="checkout-sidebar">
            <div class="order-review-section">
                <h3 class="checkout-section-title">Your Order</h3>

                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>

            <div class="checkout-trust-signals">
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>Secure Payment</span>
                </div>
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    <span>Free Worldwide Shipping</span>
                </div>
                <div class="trust-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span>Authenticity Guaranteed</span>
                </div>
            </div>
        </div>
    </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
