<?php
/**
 * WooCommerce Cart Page - Custom Design
 *
 * @package WorldOneTrading
 */

defined('ABSPATH') || exit;

$cart_count = WC()->cart->get_cart_contents_count();

do_action('woocommerce_before_cart');
?>

<div class="page-wrapper cart-page">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <?php woocommerce_breadcrumb(); ?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Shopping Bag</h1>
            <p class="page-subtitle"><?php echo esc_html($cart_count); ?> <?php echo esc_html(_n('item', 'items', $cart_count, 'worldonetrading')); ?> in your bag</p>
        </div>

        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <div class="cart-layout">
                <!-- Cart Items -->
                <div class="cart-items-section">
                    <?php
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

                            // Get brand
                            $brand_terms = get_the_terms($product_id, 'product_brand');
                            $brand_name = $brand_terms && !is_wp_error($brand_terms) ? $brand_terms[0]->name : '';

                            // Get condition
                            $condition_terms = get_the_terms($product_id, 'product_condition');
                            $condition_name = $condition_terms && !is_wp_error($condition_terms) ? $condition_terms[0]->name : '';
                            $condition_slug = $condition_terms && !is_wp_error($condition_terms) ? $condition_terms[0]->slug : '';

                            // Get color attribute
                            $color = $_product->get_attribute('pa_color');
                            if (!$color) {
                                $color = $_product->get_attribute('color');
                            }
                    ?>
                        <div class="cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                            <!-- Product Image -->
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

                            <!-- Product Info -->
                            <div class="cart-item-details">
                                <div class="cart-item-top">
                                    <div class="cart-item-info">
                                        <?php if ($brand_name) : ?>
                                            <div class="cart-item-brand"><?php echo esc_html($brand_name); ?></div>
                                        <?php endif; ?>

                                        <div class="cart-item-title">
                                            <?php
                                            if ($product_permalink) {
                                                echo '<a href="' . esc_url($product_permalink) . '">' . wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '</a>';
                                            } else {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
                                            }
                                            ?>
                                        </div>

                                        <div class="cart-item-meta">
                                            <?php if ($condition_name) : ?>
                                                <span class="condition-badge">Condition <?php echo esc_html(strtoupper(substr($condition_slug, 0, 1))); ?></span>
                                            <?php endif; ?>
                                            <?php if ($color) : ?>
                                                <span class="item-color">Color: <?php echo esc_html($color); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <?php
                                    echo apply_filters(
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="cart-item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="material-symbols-outlined">close</span></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'woocommerce'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>

                                <div class="cart-item-bottom">
                                    <div class="cart-item-qty">
                                        <span>Qty: <?php echo esc_html($cart_item['quantity']); ?></span>
                                    </div>
                                    <div class="cart-item-price">
                                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endif;
                    endforeach;
                    ?>

                    <!-- Continue Shopping -->
                    <div class="cart-continue">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="continue-shopping-link">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="cart-summary-section">
                    <div class="cart-summary">
                        <h2 class="cart-summary-title">Order Summary</h2>

                        <div class="cart-summary-rows">
                            <div class="cart-summary-row">
                                <span class="row-label">Subtotal</span>
                                <span class="row-value"><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>
                            <div class="cart-summary-row">
                                <span class="row-label">Shipping</span>
                                <span class="row-value shipping-free">Free</span>
                            </div>
                            <?php if (wc_tax_enabled() && WC()->cart->get_total_tax()) : ?>
                            <div class="cart-summary-row">
                                <span class="row-label">Tax (included)</span>
                                <span class="row-value"><?php echo wc_price(WC()->cart->get_total_tax()); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="cart-summary-total">
                            <span class="total-label">Total</span>
                            <span class="total-value"><?php wc_cart_totals_order_total_html(); ?></span>
                        </div>

                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-btn">
                            <span class="material-symbols-outlined">lock</span>
                            Proceed to Checkout
                        </a>

                        <div class="cart-trust-badges">
                            <div class="trust-badge">
                                <span class="material-symbols-outlined">verified</span>
                                <span>All items authenticated</span>
                            </div>
                            <div class="trust-badge">
                                <span class="material-symbols-outlined">local_shipping</span>
                                <span>Free worldwide shipping</span>
                            </div>
                            <div class="trust-badge">
                                <span class="material-symbols-outlined">shield</span>
                                <span>Buyer protection included</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
