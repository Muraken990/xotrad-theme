<?php
/**
 * Template Name: Privacy Page
 * Template Post Type: page
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
            <span>Privacy Policy</span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Legal Information', 'worldonetrading'); ?></span>
            <h1 class="page-title">Privacy Policy</h1>
            <p class="page-subtitle">Last updated: January 26, 2026</p>
        </header>

        <!-- Page Content -->
        <article class="legal-content">
            <div class="entry-content">
                <h2>1. Information We Collect</h2>
                <p>We collect information you provide directly to us, including your name, email address, shipping address, and payment information when you make a purchase or create an account.</p>

                <h2>2. How We Use Your Information</h2>
                <p>We use your information to:</p>
                <ul>
                    <li>Process and fulfill your orders</li>
                    <li>Communicate with you about your orders and account</li>
                    <li>Send promotional communications (with your consent)</li>
                    <li>Improve our services and website</li>
                </ul>

                <h2>3. Information Sharing</h2>
                <p>We do not sell your personal information. We may share your information with:</p>
                <ul>
                    <li>Payment processors to complete transactions</li>
                    <li>Shipping carriers to deliver your orders</li>
                    <li>Service providers who assist in our operations</li>
                </ul>

                <h2>4. Data Security</h2>
                <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>

                <h2>5. Cookies</h2>
                <p>We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookies through your browser settings.</p>

                <h2>6. Your Rights</h2>
                <p>You have the right to access, correct, or delete your personal information. Contact us at <a href="mailto:info@xotrad.com">info@xotrad.com</a> to exercise these rights.</p>

                <h2>7. Changes to This Policy</h2>
                <p>We may update this policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>

                <h2>8. Contact</h2>
                <p>For questions about this privacy policy, please contact us at <a href="mailto:info@xotrad.com">info@xotrad.com</a>.</p>
            </div>
        </article>

        <!-- Related Legal Links -->
        <nav class="legal-related">
            <span class="section-label"><?php esc_html_e('Other Legal Pages', 'worldonetrading'); ?></span>
            <div class="legal-related-links">
                <?php
                $legal_pages = array(
                    'terms-conditions' => 'Terms & Conditions',
                    'refunds-returns' => 'Refunds & Returns',
                    'payment-shipping' => 'Payment & Shipping'
                );

                foreach ($legal_pages as $slug => $title) :
                    $page = get_page_by_path($slug);
                    if ($page) :
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
