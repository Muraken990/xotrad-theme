<?php
/**
 * Template Name: Shipping Page
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
            <span>Payment & Shipping</span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Legal Information', 'worldonetrading'); ?></span>
            <h1 class="page-title">Payment & Shipping</h1>
            <p class="page-subtitle">Last updated: January 26, 2026</p>
        </header>

        <!-- Page Content -->
        <article class="legal-content">
            <div class="entry-content">
                <h2>1. Payment Methods</h2>
                <p>We accept the following payment methods:</p>
                <ul>
                    <li>Visa</li>
                    <li>Mastercard</li>
                    <li>American Express</li>
                    <li>PayPal</li>
                </ul>

                <h2>2. Payment Security</h2>
                <p>All transactions are processed through secure, encrypted connections. We do not store your credit card information on our servers.</p>

                <h2>3. Currency</h2>
                <p>All prices are listed in USD. International customers may see charges in their local currency by their payment provider.</p>

                <h2>4. Shipping Destinations</h2>
                <p>We ship worldwide. Shipping restrictions may apply to certain regions.</p>

                <h2>5. Shipping Cost</h2>
                <p>We offer free worldwide shipping on all orders via insured express courier.</p>

                <h2>6. Processing Time</h2>
                <p>Orders are shipped within 5 business days of placing your order. You will receive a confirmation email with tracking information once your order ships.</p>

                <h2>7. Delivery Time</h2>
                <p>Estimated delivery time is 7-14 business days after shipment for all destinations worldwide.</p>

                <h2>8. Customs and Duties</h2>
                <p>International orders may be subject to customs duties and taxes, which are the responsibility of the buyer. These charges are not included in the item price or shipping cost.</p>

                <h2>9. Contact</h2>
                <p>For shipping inquiries, please contact us at <a href="mailto:info@xotrad.com">info@xotrad.com</a>.</p>
            </div>
        </article>

        <!-- Related Legal Links -->
        <nav class="legal-related">
            <span class="section-label"><?php esc_html_e('Other Legal Pages', 'worldonetrading'); ?></span>
            <div class="legal-related-links">
                <?php
                $legal_pages = array(
                    'terms-conditions' => 'Terms & Conditions',
                    'privacy-policy' => 'Privacy Policy',
                    'refunds-returns' => 'Refunds & Returns'
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
