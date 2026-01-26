<?php
/**
 * WooCommerce Single Product Page
 *
 * @package WorldOneTrading
 */

get_header();

while (have_posts()) : the_post();
    global $product;

    $product_id = $product->get_id();
    $images = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();
    $brand_terms = get_the_terms($product_id, 'product_brand');
    $brand_name = $brand_terms ? $brand_terms[0]->name : '';
    $brand_slug = $brand_terms ? $brand_terms[0]->slug : '';
    // Get condition from taxonomy or product attribute
    $condition = '';
    $condition_terms = get_the_terms($product_id, 'product_condition');
    if ($condition_terms && !is_wp_error($condition_terms)) {
        $condition = $condition_terms[0]->name;
    }
    // Fallback: check product attributes
    if (empty($condition)) {
        $condition = $product->get_attribute('condition');
    }
    if (empty($condition)) {
        $condition = $product->get_attribute('pa_condition');
    }

    // Map condition to code for badge (supports partial matching)
    $condition_code = 'B'; // default
    $condition_lower = strtolower($condition);
    if (strpos($condition_lower, 'new') !== false && strpos($condition_lower, 'like') === false) {
        $condition_code = 'S';
    } elseif (strpos($condition_lower, 'like new') !== false) {
        $condition_code = 'S';
    } elseif (strpos($condition_lower, 'excellent') !== false) {
        $condition_code = 'A';
    } elseif (strpos($condition_lower, 'very good') !== false) {
        $condition_code = 'A';
    } elseif (strpos($condition_lower, 'good') !== false) {
        $condition_code = 'B';
    } elseif (strpos($condition_lower, 'fair') !== false) {
        $condition_code = 'C';
    }

    // Get color from product attributes
    $color = '';
    $attributes = $product->get_attributes();
    foreach ($attributes as $attribute) {
        if (is_object($attribute) && method_exists($attribute, 'get_name')) {
            $attr_name = strtolower($attribute->get_name());
            if ($attr_name === 'color' || $attr_name === 'pa_color') {
                $color = $product->get_attribute($attribute->get_name());
                break;
            }
        }
    }
    // Fallback: try to get from short description
    if (empty($color)) {
        $short_desc = $product->get_short_description();
        if (preg_match('/- ([^-]+)$/', $short_desc, $matches)) {
            $color = trim($matches[1]);
        }
    }

    // Collect all images
    $all_images = array();
    if ($main_image_id) {
        $all_images[] = $main_image_id;
    }
    if ($images) {
        $all_images = array_merge($all_images, $images);
    }
?>

<main class="page-wrapper single-product-page">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <?php woocommerce_breadcrumb(); ?>

        <div class="single-product-layout">

            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="product-gallery-main" id="gallery-main">
                    <?php if (!$product->is_in_stock()) : ?>
                        <div class="sold-ribbon"></div>
                    <?php endif; ?>
                    <?php if ($main_image_id) : ?>
                        <?php echo wp_get_attachment_image($main_image_id, 'large', false, array('id' => 'main-product-image')); ?>
                    <?php else : ?>
                        <div class="skeleton"></div>
                    <?php endif; ?>
                </div>

                <?php if (count($all_images) > 1) : ?>
                    <div class="product-gallery-thumbs">
                        <?php foreach ($all_images as $index => $image_id) : ?>
                            <div class="thumb <?php echo $index === 0 ? 'active' : ''; ?>"
                                 data-full="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>"
                                 onclick="wotChangeImage(this)">
                                <?php echo wp_get_attachment_image($image_id, 'product-thumb'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <?php if ($brand_name) : ?>
                    <a href="<?php echo esc_url(home_url('/brand/' . $brand_slug)); ?>" class="product-brand">
                        <?php echo esc_html($brand_name); ?>
                    </a>
                <?php endif; ?>

                <h1 class="product-title"><?php the_title(); ?></h1>

                <div class="product-price"><?php echo $product->get_price_html(); ?></div>

                <!-- Condition & Authentication -->
                <div class="product-meta-row">
                    <?php if ($condition) : ?>
                        <div class="condition-group">
                            <span class="condition-badge">Condition <?php echo esc_html($condition_code); ?></span>
                            <span class="condition-label"><?php echo esc_html($condition); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="authenticated-badge">
                        <span class="material-symbols-outlined">verified</span>
                        <span>Authenticated</span>
                    </div>
                </div>

                <!-- Description -->
                <?php if ($product->get_description()) : ?>
                    <div class="product-section">
                        <h3 class="product-section-title">Description</h3>
                        <div class="product-description">
                            <?php echo wp_kses_post($product->get_description()); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Details -->
                <?php
                // Get additional product attributes
                $material = $product->get_attribute('material') ?: $product->get_attribute('pa_material');
                $hardware = $product->get_attribute('hardware') ?: $product->get_attribute('pa_hardware');
                $size = $product->get_attribute('size') ?: $product->get_attribute('pa_size');

                if ($material || $hardware || $size || $color) :
                ?>
                    <div class="product-section">
                        <h3 class="product-section-title">Details</h3>
                        <div class="product-details-grid">
                            <?php if ($material) : ?>
                            <div class="detail-item">
                                <span class="detail-label">Material</span>
                                <span class="detail-value"><?php echo esc_html($material); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ($hardware) : ?>
                            <div class="detail-item">
                                <span class="detail-label">Hardware</span>
                                <span class="detail-value"><?php echo esc_html($hardware); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ($size) : ?>
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value"><?php echo esc_html($size); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ($color) : ?>
                            <div class="detail-item">
                                <span class="detail-label">Color</span>
                                <span class="detail-value"><?php echo esc_html($color); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Add to Cart & Wishlist -->
                <div class="product-actions">
                    <?php if ($product->is_in_stock()) : ?>
                        <button class="btn-add-to-cart" id="add-to-cart-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                            <span class="material-symbols-outlined">shopping_bag</span>
                            Add to Bag
                        </button>
                    <?php endif; ?>
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                </div>

                <!-- Shipping Info -->
                <div class="shipping-info">
                    <div class="shipping-info-item">
                        <span class="material-symbols-outlined">local_shipping</span>
                        <span>Free worldwide shipping on all orders</span>
                    </div>
                    <div class="shipping-info-item">
                        <span class="material-symbols-outlined">shield</span>
                        <span>Buyer protection &amp; 14-day return policy</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Products -->
        <?php
        $related_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 5,
            'post__not_in'   => array($product_id),
            'post_status'    => 'publish',
            'orderby'        => 'rand',
        );

        if ($brand_terms) {
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_brand',
                    'field'    => 'term_id',
                    'terms'    => $brand_terms[0]->term_id,
                ),
            );
        }

        $related = new WP_Query($related_args);

        if ($related->have_posts()) :
        ?>
        <section class="section">
            <h2 class="section-title">You May Also Like</h2>
            <div class="products-grid">
                <?php
                while ($related->have_posts()) : $related->the_post();
                    global $product;
                    get_template_part('template-parts/product-card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php endif; ?>

    </div>
</main>

<script>
function wotChangeImage(thumb) {
    const mainImg = document.getElementById('main-product-image');
    const fullUrl = thumb.dataset.full;
    if (mainImg && fullUrl) {
        // Remove srcset to prevent browser from using it instead of src
        mainImg.removeAttribute('srcset');
        mainImg.removeAttribute('sizes');
        mainImg.src = fullUrl;
        document.querySelectorAll('.product-gallery-thumbs .thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add-to-cart-btn');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = 'Adding...';

            fetch(wotData.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'wot_add_to_cart',
                    nonce: wotData.nonce,
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = 'Added!';
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.data.cart_count;
                    } else {
                        const cartLink = document.querySelector('.cart-link');
                        if (cartLink) {
                            const span = document.createElement('span');
                            span.className = 'cart-count';
                            span.textContent = data.data.cart_count;
                            cartLink.appendChild(span);
                        }
                    }
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<span class="material-symbols-outlined">shopping_bag</span> Add to Bag';
                    }, 2000);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = 'Error - Try Again';
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = 'Error - Try Again';
            });
        });
    }
});
</script>

<?php
endwhile;
get_footer();
?>
