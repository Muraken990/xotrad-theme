<?php
/**
 * Brand Taxonomy Archive Template
 * Displays products filtered by brand
 *
 * @package WorldOneTrading
 */

get_header();

$brand = get_queried_object();
$brand_name = $brand ? $brand->name : 'Brand';
?>

<main class="site-main shop-page" style="margin-top: var(--header-height);">
    <div class="container">

        <div class="section" style="padding-bottom: var(--space-lg);">
            <h1 class="section-title"><?php echo esc_html($brand_name); ?></h1>
            <?php if ($brand && $brand->description) : ?>
                <p style="text-align: center; color: var(--text-secondary); max-width: 600px; margin: 0 auto;">
                    <?php echo esc_html($brand->description); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <select class="filter-select" id="filter-condition" onchange="wotBrandFilter()">
                <option value="">All Conditions</option>
                <?php
                $conditions = get_terms(array(
                    'taxonomy'   => 'product_condition',
                    'hide_empty' => true,
                ));
                if (!is_wp_error($conditions)) :
                    foreach ($conditions as $condition) :
                ?>
                    <option value="<?php echo esc_attr($condition->slug); ?>">
                        <?php echo esc_html($condition->name); ?>
                    </option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>

            <select class="filter-select" id="filter-sort" onchange="wotBrandFilter()">
                <option value="date">Newest First</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="title">Alphabetical</option>
            </select>
        </div>

        <!-- Products Grid -->
        <?php if (have_posts()) : ?>
            <div class="products-grid">
                <?php
                while (have_posts()) : the_post();
                    global $product;
                    get_template_part('template-parts/product-card');
                endwhile;
                ?>
            </div>

            <div class="pagination">
                <?php
                echo paginate_links(array(
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type'      => 'plain',
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="cart-empty">
                <h2>No products found</h2>
                <p>We don't currently have any <?php echo esc_html($brand_name); ?> items in stock. Check back soon!</p>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-secondary">Browse All Products</a>
            </div>
        <?php endif; ?>

    </div>
</main>

<script>
function wotBrandFilter() {
    const sort = document.getElementById('filter-sort').value;
    let url = window.location.pathname;
    const params = new URLSearchParams();
    if (sort && sort !== 'date') {
        params.set('orderby', sort);
    }
    const queryString = params.toString();
    window.location.href = url + (queryString ? '?' + queryString : '');
}
</script>

<?php get_footer(); ?>
