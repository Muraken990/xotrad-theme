<?php
/**
 * Template Name: Legal Page
 * Template for Terms & Conditions, Privacy Policy, etc.
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="page-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <span><?php the_title(); ?></span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Legal Information', 'worldonetrading'); ?></span>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p class="page-subtitle"><?php printf(__('Last updated: %s', 'worldonetrading'), get_the_modified_date('F j, Y')); ?></p>
        </header>

        <!-- Page Content -->
        <article class="legal-content">
            <?php while (have_posts()) : the_post(); ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        </article>

        <!-- Related Legal Links -->
        <nav class="legal-related">
            <span class="section-label"><?php esc_html_e('Other Legal Pages', 'worldonetrading'); ?></span>
            <div class="legal-related-links">
                <?php
                $legal_pages = array(
                    'terms-conditions' => 'Terms & Conditions',
                    'privacy-policy' => 'Privacy Policy',
                    'refunds-returns' => 'Refunds & Returns',
                    'payment-shipping' => 'Payment & Shipping'
                );
                $current_slug = get_post_field('post_name', get_post());

                foreach ($legal_pages as $slug => $title) :
                    $page = get_page_by_path($slug);
                    if ($page && $slug !== $current_slug) :
                ?>
                    <a href="<?php echo esc_url(get_permalink($page->ID)); ?>">
                        <span><?php echo esc_html($title); ?></span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </nav>
    </div>
</main>

<?php get_footer(); ?>
