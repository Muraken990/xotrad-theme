<footer class="site-footer">
    <div class="footer-main">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-dark.png" alt="Xotrad" class="logo-img logo-dark">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-light.png" alt="Xotrad" class="logo-img logo-light">
                    <span class="footer-logo-text">Xotrad</span>
                </div>
                <p class="footer-description">Authenticated luxury from Japan. Curated pre-owned pieces from the world's most prestigious maisons.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Website"><span class="material-symbols-outlined">public</span></a>
                    <a href="#" aria-label="Share"><span class="material-symbols-outlined">share_reviews</span></a>
                    <a href="#" aria-label="Chat"><span class="material-symbols-outlined">chat_bubble</span></a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Shop</h4>
                <ul>
                    <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">New Arrivals</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=handbags')); ?>">Handbags</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=watches')); ?>">Watches</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/?product_cat=accessories')); ?>">Accessories</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>About</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">Our Story</a></li>
                    <li><a href="<?php echo esc_url(home_url('/payment-shipping')); ?>">Payment & Shipping</a></li>
                    <li><a href="<?php echo esc_url(home_url('/refunds-returns')); ?>">Refunds & Returns</a></li>
                </ul>
            </div>

            <div class="footer-newsletter">
                <h4>Newsletter</h4>
                <p>Join our inner circle for exclusive access to new arrivals.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Email address" />
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p class="footer-copyright">&copy; <?php echo date('Y'); ?> XOTRAD. ALL RIGHTS RESERVED.</p>
        <div class="footer-legal">
            <a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms & Conditions</a>
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
            <a href="<?php echo esc_url(home_url('/refunds-returns')); ?>">Refunds & Returns</a>
            <a href="<?php echo esc_url(home_url('/payment-shipping')); ?>">Payment & Shipping</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
