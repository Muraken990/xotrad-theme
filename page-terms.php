<?php
/**
 * Template Name: Terms Page
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
            <span>Terms & Conditions</span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Legal Information', 'worldonetrading'); ?></span>
            <h1 class="page-title">Terms & Conditions</h1>
            <p class="page-subtitle">Last updated: January 26, 2026</p>
        </header>

        <!-- Page Content -->
        <article class="legal-content">
            <div class="entry-content">
                <h2>1. Agreement to Terms</h2>
                <p>By accessing and using xotrad.com, you agree to be bound by these Terms and Conditions.</p>

                <h2>2. Products</h2>
                <p>Xotrad sells pre-owned luxury items that have been authenticated by our expert team. While we strive to accurately describe the condition of each item, minor variations may occur due to the nature of pre-owned goods.</p>

                <h2>3. Pricing and Payment</h2>
                <p>All prices are listed in USD. Payment must be received in full before items are shipped. We accept major credit cards and other payment methods as indicated at checkout.</p>

                <h2>4. Authenticity Guarantee</h2>
                <p>Every item sold on Xotrad is guaranteed to be 100% authentic. All items undergo thorough inspection by our team of experts before being listed.</p>

                <h2>5. Intellectual Property</h2>
                <p>All content on this website, including images, text, and logos, is the property of Xotrad and may not be reproduced without permission.</p>

                <h2>6. Limitation of Liability</h2>
                <p>Xotrad shall not be liable for any indirect, incidental, or consequential damages arising from your use of our website or products.</p>

                <h2>7. Changes to Terms</h2>
                <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting.</p>

                <h2>8. Contact</h2>
                <p>For questions about these terms, please contact us at <a href="mailto:info@xotrad.com">info@xotrad.com</a>.</p>
            </div>
        </article>

        <!-- Related Legal Links -->
        <nav class="legal-related">
            <span class="section-label"><?php esc_html_e('Other Legal Pages', 'worldonetrading'); ?></span>
            <div class="legal-related-links">
                <?php
                $legal_pages = array(
                    'privacy-policy' => 'Privacy Policy',
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
