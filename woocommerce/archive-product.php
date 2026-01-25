<?php
/**
 * WooCommerce Product Archive (Shop Page)
 *
 * @package WorldOneTrading
 */

get_header();

$current_brand = get_queried_object();
$page_title = is_product_category() ? single_cat_title('', false) : 'Shop';

if (is_tax('product_brand')) {
    $page_title = $current_brand->name;
}
?>

<main class="site-main shop-page">
    <div class="container">

        <!-- Page Header -->
        <div class="section" style="padding-bottom: var(--space-lg);">
            <h1 class="section-title"><?php echo esc_html($page_title); ?></h1>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <select class="filter-select" id="filter-brand" onchange="wotFilter()">
                <option value="">All Brands</option>
                <?php
                $brands = get_terms(array(
                    'taxonomy'   => 'product_brand',
                    'hide_empty' => true,
                ));
                if (!is_wp_error($brands)) :
                    foreach ($brands as $brand) :
                        $selected = (is_tax('product_brand', $brand->slug)) ? 'selected' : '';
                ?>
                    <option value="<?php echo esc_attr($brand->slug); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html($brand->name); ?>
                    </option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>

            <select class="filter-select" id="filter-condition" onchange="wotFilter()">
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

            <select class="filter-select" id="filter-sort" onchange="wotFilter()">
                <option value="date">Newest First</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="title">Alphabetical</option>
            </select>
        </div>

        <!-- Products Grid -->
        <?php if (woocommerce_product_loop()) : ?>
            <div class="products-grid">
                <?php
                while (have_posts()) : the_post();
                    global $product;
                    get_template_part('template-parts/product-card');
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
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
                <p>Try adjusting your filters or check back later for new arrivals.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<script>
function wotFilter() {
    const brand = document.getElementById('filter-brand').value;
    const sort = document.getElementById('filter-sort').value;
    let url = '<?php echo esc_url(get_permalink(wc_get_page_id("shop"))); ?>';

    if (brand) {
        url = '<?php echo esc_url(home_url("/brand/")); ?>' + brand;
    }

    const params = new URLSearchParams();
    if (sort && sort !== 'date') {
        params.set('orderby', sort);
    }

    const queryString = params.toString();
    if (queryString) {
        url += '?' + queryString;
    }

    window.location.href = url;
}
</script>

<?php get_footer(); ?>
