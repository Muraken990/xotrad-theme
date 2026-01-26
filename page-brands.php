<?php
/**
 * Template Name: Brands Page
 * Template Post Type: page
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main brands-page">
    <div class="container page-container">
        <h1 class="section-title">Our Brands</h1>

        <div class="brands-grid brands-grid-centered">
            <?php
            $brands = get_terms(array(
                'taxonomy'   => 'product_brand',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));

            if (!is_wp_error($brands) && !empty($brands)) :
                foreach ($brands as $brand) :
                    $brand_url = get_term_link($brand);
                    $count = $brand->count;
            ?>
                <a href="<?php echo esc_url($brand_url); ?>" class="brand-card">
                    <span><?php echo esc_html($brand->name); ?></span>
                </a>
            <?php
                endforeach;
            else :
                // Fallback brands when no terms exist yet
                $default_brands = array(
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
                    'balenciaga'    => 'BALENCIAGA',
                    'versace'       => 'VERSACE',
                );
                foreach ($default_brands as $slug => $name) :
            ?>
                <a href="<?php echo esc_url(home_url('/brand/' . $slug)); ?>" class="brand-card">
                    <span><?php echo esc_html($name); ?></span>
                </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
