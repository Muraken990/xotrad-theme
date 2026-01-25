<?php
/**
 * 404 Page Template
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="site-main">
    <div class="container page-content" style="text-align: center; min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h1 style="font-size: 4rem; font-weight: 300; margin-bottom: var(--space-md);">404</h1>
        <p style="color: var(--text-secondary); margin-bottom: var(--space-xl);">The page you're looking for doesn't exist.</p>
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-secondary">Browse Our Collection</a>
    </div>
</main>

<?php get_footer(); ?>
