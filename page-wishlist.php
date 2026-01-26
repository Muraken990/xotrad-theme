<?php
/**
 * Template Name: Wishlist Page
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="page-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
            <span class="breadcrumb-sep">/</span>
            <span>WISHLIST</span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <!-- Wishlist Content -->
        <div class="wishlist-content">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
