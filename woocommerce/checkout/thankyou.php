<?php
/**
 * Thankyou / Order Confirmation Page
 *
 * @package WorldOneTrading
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order thankyou-page">

    <?php if ($order) :
        do_action('woocommerce_before_thankyou', $order->get_id());
    ?>

        <?php if ($order->has_status('failed')) : ?>
            <div class="thankyou-notice thankyou-failed">
                <p><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/payment method declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>
                <p>
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="btn-gold">
                        <?php esc_html_e('Pay', 'woocommerce'); ?>
                    </a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn-outline">
                            <?php esc_html_e('My account', 'woocommerce'); ?>
                        </a>
                    <?php endif; ?>
                </p>
            </div>
        <?php else : ?>
            <div class="thankyou-header">
                <div class="thankyou-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h2 class="thankyou-title">Thank You for Your Order</h2>
                <p class="thankyou-message">
                    <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order); ?>
                </p>
            </div>

            <div class="thankyou-details">
                <div class="thankyou-detail-item">
                    <span class="detail-label">Order Number</span>
                    <span class="detail-value"><?php echo $order->get_order_number(); ?></span>
                </div>
                <div class="thankyou-detail-item">
                    <span class="detail-label">Date</span>
                    <span class="detail-value"><?php echo wc_format_datetime($order->get_date_created()); ?></span>
                </div>
                <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                    <div class="thankyou-detail-item">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?php echo $order->get_billing_email(); ?></span>
                    </div>
                <?php endif; ?>
                <div class="thankyou-detail-item">
                    <span class="detail-label">Total</span>
                    <span class="detail-value"><?php echo $order->get_formatted_order_total(); ?></span>
                </div>
                <?php if ($order->get_payment_method_title()) : ?>
                    <div class="thankyou-detail-item">
                        <span class="detail-label">Payment Method</span>
                        <span class="detail-value"><?php echo wp_kses_post($order->get_payment_method_title()); ?></span>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

        <div class="thankyou-actions">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-gold">
                Continue Shopping
            </a>
        </div>

    <?php else : ?>
        <div class="thankyou-header">
            <h2 class="thankyou-title">Thank You</h2>
            <p class="thankyou-message"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), null); ?></p>
        </div>
    <?php endif; ?>

</div>
