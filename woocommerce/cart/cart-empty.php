<?php
/**
 * Empty Cart Page
 *
 * @package WorldOneTrading
 */

defined('ABSPATH') || exit;
?>

<div class="page-wrapper cart-page">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <?php woocommerce_breadcrumb(); ?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Shopping Bag</h1>
            <p class="page-subtitle">Your bag is empty</p>
        </div>

        <div class="cart-empty-content">
            <span class="material-symbols-outlined empty-icon">shopping_bag</span>
            <h2>Your shopping bag is empty</h2>
            <p>Looks like you haven't added any items to your bag yet.</p>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-gold">
                Start Shopping
            </a>
        </div>
    </div>
</div>
