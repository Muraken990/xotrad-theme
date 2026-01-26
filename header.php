<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <div class="header-left">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <div class="logo-icon">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"/>
                    </svg>
                </div>
                <span class="logo-text">Xotrad</span>
            </a>
            <nav class="main-nav">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" <?php if (is_shop() || is_product_category()) echo 'class="active"'; ?>>Shop</a>
                <a href="<?php echo esc_url(home_url('/brands')); ?>" <?php if (is_page('brands')) echo 'class="active"'; ?>>Brands</a>
                <a href="<?php echo esc_url(home_url('/about')); ?>" <?php if (is_page('about')) echo 'class="active"'; ?>>About</a>
            </nav>
        </div>
        <div class="header-right">
            <div class="header-search">
                <div class="search-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" placeholder="Search the collection..." class="search-input" />
                </div>
            </div>
            <div class="header-icons">
                <a href="<?php echo esc_url(home_url('/wishlist/')); ?>" class="icon-btn" aria-label="Wishlist">
                    <span class="material-symbols-outlined">favorite</span>
                </a>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="icon-btn cart-btn" aria-label="Cart">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                        <span class="cart-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    <?php endif; ?>
                </a>
                <button class="icon-btn theme-toggle-btn" id="theme-toggle" aria-label="Toggle theme">
                    <span class="material-symbols-outlined theme-icon-light">dark_mode</span>
                    <span class="material-symbols-outlined theme-icon-dark">light_mode</span>
                </button>
            </div>
            <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
    <!-- Mobile menu -->
    <nav class="mobile-nav" id="mobile-nav">
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Shop</a>
        <a href="<?php echo esc_url(home_url('/brands')); ?>">Brands</a>
        <a href="<?php echo esc_url(home_url('/about')); ?>">About</a>
    </nav>
</header>
