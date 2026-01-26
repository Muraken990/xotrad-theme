<?php
/**
 * Product Card Template Part
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
?>

<div class="product-card">
    <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
        <div class="product-card-image">
            <?php if (!$product->is_in_stock()) : ?>
                <div class="sold-ribbon"></div>
            <?php endif; ?>

            <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail($product_id, 'product-card', array('class' => 'primary-image')); ?>
            <?php else : ?>
                <div class="skeleton primary-image"></div>
            <?php endif; ?>

            <?php if (!empty($images)) : ?>
                <?php echo wp_get_attachment_image($images[0], 'product-card', false, array('class' => 'hover-image')); ?>
            <?php endif; ?>

            <div class="product-card-overlay">
                <span class="btn-quick-view">View Details</span>
            </div>
        </div>
    </a>

    <div class="product-card-info">
        <?php if ($brand_name) : ?>
            <div class="product-card-brand"><?php echo esc_html($brand_name); ?></div>
        <?php endif; ?>

        <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
            <div class="product-card-title"><?php echo esc_html($product->get_name()); ?></div>
        </a>

        <div class="product-card-price"><?php echo $product->get_price_html(); ?></div>

        <?php if ($condition) : ?>
            <div class="product-card-condition"><?php echo esc_html($condition); ?></div>
        <?php endif; ?>
    </div>
</div>
