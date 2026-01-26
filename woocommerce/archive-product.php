<?php
/**
 * WooCommerce Product Archive (Shop Page) - Collection Layout
 *
 * @package WorldOneTrading
 */

get_header();

$current_brand = get_queried_object();
$page_title = 'The Collection';
$page_subtitle = 'Authenticated luxury pieces from Japan\'s finest collections.';

if (is_product_category()) {
    $page_title = single_cat_title('', false);
    $page_subtitle = '';
}

if (is_tax('product_brand')) {
    $page_title = $current_brand->name;
    $page_subtitle = 'Explore our curated ' . $current_brand->name . ' collection.';
}

// Get filter data
$brands = get_terms(array(
    'taxonomy'   => 'product_brand',
    'hide_empty' => true,
));

$conditions = get_terms(array(
    'taxonomy'   => 'product_condition',
    'hide_empty' => true,
));

$active_filters = wot_get_active_filters();
$current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';

// Pagination info
global $wp_query;
$total_products = $wp_query->found_posts;
$products_per_page = $wp_query->get('posts_per_page');
$current_page = max(1, get_query_var('paged'));
$start_product = (($current_page - 1) * $products_per_page) + 1;
$end_product = min($current_page * $products_per_page, $total_products);
?>

<main class="page-wrapper collection-page">
    <div class="page-inner">

        <!-- Breadcrumb (WooCommerce標準) -->
        <?php woocommerce_breadcrumb(); ?>

        <!-- Header Row: Title + Sort -->
        <div class="collection-header-row">
            <div class="page-header collection-header">
                <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
                <?php if ($page_subtitle) : ?>
                    <p class="page-subtitle"><?php echo esc_html($page_subtitle); ?></p>
                <?php endif; ?>
            </div>
            <div class="collection-sort">
                <label for="collection-orderby">Sort by</label>
                <select id="collection-orderby" class="collection-sort-select" onchange="wotCollectionSort(this.value)">
                    <option value="date" <?php selected($current_orderby, 'date'); ?>>Newest First</option>
                    <option value="price-asc" <?php selected($current_orderby, 'price-asc'); ?>>Price: Low to High</option>
                    <option value="price-desc" <?php selected($current_orderby, 'price-desc'); ?>>Price: High to Low</option>
                    <option value="title" <?php selected($current_orderby, 'title'); ?>>Alphabetical</option>
                </select>
            </div>
        </div>

        <!-- 2-Column Layout -->
        <div class="collection-layout">

            <!-- Sidebar Filters -->
            <aside class="filter-sidebar">
                <h4 class="filter-title">Refine Selection</h4>

                <!-- Mobile Filter Toggle -->
                <button class="filter-toggle-mobile" id="filter-toggle-mobile">
                    <span>Filters</span>
                    <span class="material-symbols-outlined">tune</span>
                </button>

                <div class="filter-content" id="filter-content">
                    <!-- Brand Filter -->
                    <?php if (!is_wp_error($brands) && !empty($brands)) : ?>
                    <div class="filter-group" data-filter="brand">
                        <button class="filter-group-header" type="button">
                            <span>Brand</span>
                            <span class="toggle-icon material-symbols-outlined">remove</span>
                        </button>
                        <div class="filter-group-content">
                            <?php foreach ($brands as $brand) :
                                $is_active = wot_is_filter_active('brand', $brand->slug);
                            ?>
                            <label class="filter-checkbox <?php echo $is_active ? 'active' : ''; ?>">
                                <input type="checkbox"
                                       name="brand[]"
                                       value="<?php echo esc_attr($brand->slug); ?>"
                                       data-filter-type="brand"
                                       <?php checked($is_active); ?>>
                                <span class="checkbox-label"><?php echo esc_html($brand->name); ?></span>
                                <span class="count">(<?php echo esc_html($brand->count); ?>)</span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Condition Filter -->
                    <?php if (!is_wp_error($conditions) && !empty($conditions)) : ?>
                    <div class="filter-group" data-filter="condition">
                        <button class="filter-group-header" type="button">
                            <span>Condition</span>
                            <span class="toggle-icon material-symbols-outlined">remove</span>
                        </button>
                        <div class="filter-group-content">
                            <?php foreach ($conditions as $condition) :
                                $is_active = wot_is_filter_active('condition', $condition->slug);
                            ?>
                            <label class="filter-checkbox <?php echo $is_active ? 'active' : ''; ?>">
                                <input type="checkbox"
                                       name="condition[]"
                                       value="<?php echo esc_attr($condition->slug); ?>"
                                       data-filter-type="condition"
                                       <?php checked($is_active); ?>>
                                <span class="checkbox-label"><?php echo esc_html($condition->name); ?></span>
                                <span class="count">(<?php echo esc_html($condition->count); ?>)</span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Price Filter (Collapsed by default) -->
                    <div class="filter-group collapsed" data-filter="price">
                        <button class="filter-group-header" type="button">
                            <span>Price</span>
                            <span class="toggle-icon material-symbols-outlined">add</span>
                        </button>
                        <div class="filter-group-content" style="display: none;">
                            <div class="price-range-inputs">
                                <input type="number" id="price-min" placeholder="Min" class="price-input">
                                <span class="price-separator">-</span>
                                <input type="number" id="price-max" placeholder="Max" class="price-input">
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="collection-main">

                <!-- Active Filters -->
                <?php if (!empty($active_filters)) : ?>
                <div class="active-filters">
                    <?php foreach ($active_filters as $filter) : ?>
                    <a href="<?php echo esc_url(wot_remove_filter_url($filter['type'], $filter['slug'])); ?>" class="filter-chip">
                        <span><?php echo esc_html($filter['label']); ?></span>
                        <span class="material-symbols-outlined remove-icon">close</span>
                    </a>
                    <?php endforeach; ?>
                    <a href="<?php echo esc_url(wot_clear_filters_url()); ?>" class="clear-filters">Clear Filters</a>
                </div>
                <?php endif; ?>

                <!-- Products Grid -->
                <?php if (woocommerce_product_loop()) : ?>
                    <div class="collection-grid">
                        <?php
                        while (have_posts()) : the_post();
                            global $product;
                            get_template_part('template-parts/product-card-collection');
                        endwhile;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="collection-pagination">
                        <div class="pagination-nav">
                            <?php
                            $total_pages = $wp_query->max_num_pages;

                            if ($total_pages > 1) :
                                // Previous
                                if ($current_page > 1) : ?>
                                    <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>" class="pagination-arrow prev">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </a>
                                <?php else : ?>
                                    <span class="pagination-arrow prev disabled">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </span>
                                <?php endif;

                                // Page numbers
                                echo '<div class="pagination-numbers">';

                                // First page
                                if ($current_page > 3) {
                                    echo '<a href="' . esc_url(get_pagenum_link(1)) . '" class="page-number">01</a>';
                                    if ($current_page > 4) {
                                        echo '<span class="pagination-dots">...</span>';
                                    }
                                }

                                // Pages around current
                                for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++) {
                                    $page_num = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    if ($i == $current_page) {
                                        echo '<span class="page-number current">' . $page_num . '</span>';
                                    } else {
                                        echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="page-number">' . $page_num . '</a>';
                                    }
                                }

                                // Last page
                                if ($current_page < $total_pages - 2) {
                                    if ($current_page < $total_pages - 3) {
                                        echo '<span class="pagination-dots">...</span>';
                                    }
                                    $last_page_num = str_pad($total_pages, 2, '0', STR_PAD_LEFT);
                                    echo '<a href="' . esc_url(get_pagenum_link($total_pages)) . '" class="page-number">' . $last_page_num . '</a>';
                                }

                                echo '</div>';

                                // Next
                                if ($current_page < $total_pages) : ?>
                                    <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>" class="pagination-arrow next">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </a>
                                <?php else : ?>
                                    <span class="pagination-arrow next disabled">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </span>
                                <?php endif;
                            endif;
                            ?>
                        </div>
                        <p class="pagination-info">
                            Displaying <?php echo $start_product; ?>-<?php echo $end_product; ?> of <?php echo $total_products; ?> Pieces
                        </p>
                    </div>
                <?php else : ?>
                    <div class="collection-empty">
                        <span class="material-symbols-outlined empty-icon">inventory_2</span>
                        <h2>No products found</h2>
                        <p>Try adjusting your filters or check back later for new arrivals.</p>
                        <?php if (!empty($active_filters)) : ?>
                            <a href="<?php echo esc_url(wot_clear_filters_url()); ?>" class="btn-gold">Clear All Filters</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</main>

<script>
function wotCollectionSort(orderby) {
    const url = new URL(window.location.href);
    if (orderby === 'date') {
        url.searchParams.delete('orderby');
    } else {
        url.searchParams.set('orderby', orderby);
    }
    // Reset to first page when sorting
    url.searchParams.delete('paged');
    window.location.href = url.toString();
}
</script>

<?php get_footer(); ?>
