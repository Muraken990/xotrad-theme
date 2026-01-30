<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="p:domain_verify" content="4e82ae33232b3245864ab32f6b59634f"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <div class="header-left">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-transparent.png" alt="Xotrad" class="logo-img">
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
