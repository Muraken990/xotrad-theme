<?php
/**
 * Template Name: My Account Page
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="page-wrapper my-account-page">
    <div class="page-inner">
        <!-- Breadcrumb -->
        <?php woocommerce_breadcrumb(); ?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>

        <!-- My Account Content -->
        <div class="my-account-content">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
