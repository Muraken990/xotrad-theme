<footer class="site-footer">
    <div class="footer-main">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="footer-logo-icon">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="footer-logo-text">World One Trading</span>
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
                    <li><a href="<?php echo esc_url(home_url('/authentication')); ?>">Authentication</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping')); ?>">Shipping</a></li>
                    <li><a href="<?php echo esc_url(home_url('/returns')); ?>">Returns</a></li>
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
        <p class="footer-copyright">&copy; <?php echo date('Y'); ?> WORLD ONE TRADING. ALL RIGHTS RESERVED.</p>
        <div class="footer-legal">
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy</a>
            <a href="<?php echo esc_url(home_url('/terms')); ?>">Legal</a>
            <a href="<?php echo esc_url(home_url('/accessibility')); ?>">Accessibility</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
