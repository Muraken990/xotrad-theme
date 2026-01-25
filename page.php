<?php
/**
 * Default Page Template
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main">
    <div class="container page-content">
        <?php while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
