<?php
/**
 * WooCommerce Cart Page
 *
 * @package WorldOneTrading
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <div class="cart-layout">
        <!-- Cart Items -->
        <div class="cart-items">
            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    $brand_terms = get_the_terms($product_id, 'product_brand');
                    $brand_name = $brand_terms ? $brand_terms[0]->name : '';
            ?>
                <div class="cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <div class="cart-item-image">
                        <?php
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('product-thumb'), $cart_item, $cart_item_key);
                        if ($product_permalink) {
                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                        } else {
                            echo $thumbnail;
                        }
                        ?>
                    </div>

                    <div class="cart-item-info">
                        <?php if ($brand_name) : ?>
                            <div class="item-brand"><?php echo esc_html($brand_name); ?></div>
                        <?php endif; ?>

                        <div class="item-title">
                            <?php
                            if ($product_permalink) {
                                echo '<a href="' . esc_url($product_permalink) . '">' . wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '</a>';
                            } else {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
                            }
                            ?>
                        </div>

                        <div class="item-price">
                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                        </div>
                    </div>

                    <div>
                        <?php
                        echo apply_filters(
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="cart-item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_html__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>
                </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>

        <!-- Cart Summary -->
        <div class="cart-summary">
            <h3>Order Summary</h3>

            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span><?php wc_cart_totals_subtotal_html(); ?></span>
            </div>

            <div class="cart-shipping-note">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                <span>Free Worldwide Shipping</span>
            </div>

            <div class="cart-summary-row total">
                <span>Total</span>
                <span><?php wc_cart_totals_order_total_html(); ?></span>
            </div>

            <div class="cart-checkout-btn">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn-primary">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_after_cart'); ?>
