<?php
/**
 * 404 Page Template
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main">
    <div class="container error-404-content">
        <h1 class="error-404-title">404</h1>
        <p class="error-404-message">The page you're looking for doesn't exist.</p>
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-secondary">Browse Our Collection</a>
    </div>
</main>

<?php get_footer(); ?>
