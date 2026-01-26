<?php
/**
 * Front Page Template
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main front-page">

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&q=80');">
        </div>
        <div class="hero-content">
            <span class="hero-label">Authenticated Luxury</span>
            <h1 class="hero-title">Curated <span class="accent">Luxury</span> from Japan</h1>
            <p class="hero-subtitle">Discover authenticated pre-owned luxury from the world's most prestigious maisons. Every piece verified, every detail perfected.</p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-gold">Shop Collection</a>
                <a href="<?php echo esc_url(home_url('/brands')); ?>" class="btn-outline">View Brands</a>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="section new-arrivals">
        <div class="container">
            <h2 class="section-title">New Arrivals</h2>
            <div class="products-grid">
                <?php
                $new_products = new WP_Query(array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ));

                if ($new_products->have_posts()) :
                    while ($new_products->have_posts()) : $new_products->the_post();
                        global $product;
                        get_template_part('template-parts/product-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Placeholder cards when no products exist
                    for ($i = 0; $i < 5; $i++) :
                ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <div class="skeleton"></div>
                        </div>
                        <div class="product-card-info">
                            <div class="product-card-brand">Brand</div>
                            <div class="product-card-title">Product Name</div>
                            <div class="product-card-price">$0.00</div>
                        </div>
                    </div>
                <?php
                    endfor;
                endif;
                ?>
            </div>
            <div class="section-cta">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-secondary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="section brands-section">
        <div class="container">
            <h2 class="section-title">Shop by Brand</h2>
            <div class="brands-grid">
                <?php
                $brands = array(
                    'hermes'        => 'HERMES',
                    'gucci'         => 'GUCCI',
                    'dior'          => 'DIOR',
                    'louis-vuitton' => 'LOUIS VUITTON',
                    'chanel'        => 'CHANEL',
                    'prada'         => 'PRADA',
                    'burberry'      => 'BURBERRY',
                    'fendi'         => 'FENDI',
                    'celine'        => 'CELINE',
                    'givenchy'      => 'GIVENCHY',
                );

                foreach ($brands as $slug => $name) :
                    $brand_url = home_url('/brand/' . $slug);
                ?>
                    <a href="<?php echo esc_url($brand_url); ?>" class="brand-card">
                        <?php echo esc_html($name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Editor's Picks -->
    <section class="section editors-picks">
        <div class="container">
            <h2 class="section-title">Editor's Picks</h2>
            <div class="products-grid">
                <?php
                $featured = new WP_Query(array(
                    'post_type'      => 'product',
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                        ),
                    ),
                ));

                if ($featured->have_posts()) :
                    while ($featured->have_posts()) : $featured->the_post();
                        global $product;
                        get_template_part('template-parts/product-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback: show random products
                    $random_products = new WP_Query(array(
                        'post_type'      => 'product',
                        'posts_per_page' => 5,
                        'orderby'        => 'rand',
                        'post_status'    => 'publish',
                    ));

                    if ($random_products->have_posts()) :
                        while ($random_products->have_posts()) : $random_products->the_post();
                            global $product;
                            get_template_part('template-parts/product-card');
                        endwhile;
                        wp_reset_postdata();
                    else :
                        for ($i = 0; $i < 5; $i++) :
                ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <div class="skeleton"></div>
                        </div>
                        <div class="product-card-info">
                            <div class="product-card-brand">Brand</div>
                            <div class="product-card-title">Product Name</div>
                            <div class="product-card-price">$0.00</div>
                        </div>
                    </div>
                <?php
                        endfor;
                    endif;
                endif;
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
