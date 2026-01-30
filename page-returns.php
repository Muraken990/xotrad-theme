<?php
/**
 * Template Name: Returns Page
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
            <span>Refunds & Returns</span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Legal Information', 'worldonetrading'); ?></span>
            <h1 class="page-title">Refunds & Returns</h1>
            <p class="page-subtitle">Last updated: January 29, 2026</p>
        </header>

        <!-- Page Content -->
        <article class="legal-content">
            <div class="entry-content">
                <h2>1. Return Policy</h2>
                <p>Due to the nature of pre-owned items, we do not accept returns or exchanges except in the following cases:</p>
                <ul>
                    <li>Item arrived damaged during shipping</li>
                    <li>Item significantly differs from the description</li>
                </ul>

                <h2>2. How to Report an Issue</h2>
                <p>If you receive a defective or damaged item, please contact us at <a href="mailto:info@xotrad.com">info@xotrad.com</a> within <strong>7 days of delivery</strong> with:</p>
                <ul>
                    <li>Your order number</li>
                    <li>Clear photos showing the issue</li>
                    <li>A brief description of the problem</li>
                </ul>

                <h2>3. Refund Process</h2>
                <p>Once we verify the issue, we will:</p>
                <ul>
                    <li>Provide return shipping instructions</li>
                    <li>Cover all return shipping costs</li>
                    <li>Issue a full refund within 5-7 business days after receiving the returned item</li>
                </ul>
                <p>Refunds will be issued to the original payment method.</p>

                <h2>4. Final Sale</h2>
                <p><strong>All sales are final for items that match their description.</strong></p>
                <p>We carefully inspect and accurately describe each item before listing. Please review all photos and descriptions carefully before purchasing.</p>

                <h2>5. No Exchanges</h2>
                <p>We do not offer exchanges. Each item in our inventory is unique.</p>

                <h2>6. Contact</h2>
                <p>For inquiries, please email <a href="mailto:info@xotrad.com">info@xotrad.com</a>.</p>
            </div>
        </article>

        <!-- Related Legal Links -->
        <nav class="legal-related">
            <span class="section-label"><?php esc_html_e('Other Legal Pages', 'worldonetrading'); ?></span>
            <div class="legal-related-links">
                <?php
                $legal_pages = array(
                    'terms-conditions' => 'Terms & Conditions',
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
