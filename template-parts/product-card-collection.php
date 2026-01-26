<?php
/**
 * Product Card Template Part for Collection Page
 * Features: Condition badge, Quick Add overlay, hover effects
 *
 * @package WorldOneTrading
 */

global $product;

if (!$product) return;

$product_id = $product->get_id();
$images = $product->get_gallery_image_ids();
$brand_terms = get_the_terms($product_id, 'product_brand');
$brand_name = $brand_terms ? $brand_terms[0]->name : '';
$condition_terms = get_the_terms($product_id, 'product_condition');
$condition = $condition_terms ? $condition_terms[0]->name : '';
$condition_slug = $condition_terms ? $condition_terms[0]->slug : '';
?>

<div class="collection-product-card">
    <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="collection-product-link">
        <div class="collection-product-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail($product_id, 'product-card', array('class' => 'primary-image')); ?>
            <?php else : ?>
                <div class="skeleton primary-image"></div>
            <?php endif; ?>

            <?php if (!empty($images)) : ?>
                <?php echo wp_get_attachment_image($images[0], 'product-card', false, array('class' => 'hover-image')); ?>
            <?php endif; ?>

            <?php if (!$product->is_in_stock()) : ?>
                <div class="sold-ribbon"></div>
            <?php elseif ($condition) : ?>
                <div class="condition-badge">Condition <?php echo esc_html(strtoupper(substr($condition_slug, 0, 1))); ?></div>
            <?php endif; ?>

            <div class="quick-add-overlay">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span class="quick-add-text">Quick Add</span>
            </div>
        </div>
    </a>

    <div class="collection-product-info">
        <?php if ($brand_name) : ?>
            <div class="collection-product-brand"><?php echo esc_html($brand_name); ?></div>
        <?php endif; ?>

        <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
            <div class="collection-product-title"><?php echo esc_html($product->get_name()); ?></div>
        </a>

        <div class="collection-product-price"><?php echo $product->get_price_html(); ?></div>
    </div>

    <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
        <span class="material-symbols-outlined">add_shopping_cart</span>
    </button>
</div>
