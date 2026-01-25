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
    $condition_terms = get_the_terms($product_id, 'product_condition');
    $condition = $condition_terms ? $condition_terms[0]->name : '';

    // Collect all images
    $all_images = array();
    if ($main_image_id) {
        $all_images[] = $main_image_id;
    }
    if ($images) {
        $all_images = array_merge($all_images, $images);
    }
?>

<main class="site-main">
    <div class="container">
        <div class="single-product-layout">

            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="product-gallery-main" id="gallery-main">
                    <?php if ($main_image_id) : ?>
                        <?php echo wp_get_attachment_image($main_image_id, 'large', false, array('id' => 'main-product-image')); ?>
                    <?php else : ?>
                        <div class="skeleton" style="width:100%;height:100%;"></div>
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

                <?php if ($condition) : ?>
                    <div class="product-condition"><?php echo esc_html($condition); ?></div>
                <?php endif; ?>

                <?php if ($product->get_description()) : ?>
                    <div class="product-description">
                        <?php echo wp_kses_post($product->get_description()); ?>
                    </div>
                <?php endif; ?>

                <div class="shipping-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    <span>Free Worldwide Shipping &middot; Tracking Included</span>
                </div>

                <?php if ($product->is_in_stock()) : ?>
                    <button class="btn-primary" id="add-to-cart-btn" data-product-id="<?php echo esc_attr($product_id); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        Add to Cart
                    </button>
                <?php else : ?>
                    <button class="btn-primary" disabled style="opacity:0.5;cursor:not-allowed;">
                        Sold Out
                    </button>
                <?php endif; ?>
            </div>

        </div>

        <!-- Related Products -->
        <?php
        $related_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
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
                        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg> Add to Cart';
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
