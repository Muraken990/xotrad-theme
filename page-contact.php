<?php
/**
 * Template Name: Contact Page
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
            <span><?php the_title(); ?></span>
        </nav>

        <!-- Page Header -->
        <header class="page-header">
            <span class="section-label"><?php esc_html_e('Get in Touch', 'worldonetrading'); ?></span>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p class="page-subtitle"><?php esc_html_e('We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.', 'worldonetrading'); ?></p>
        </header>

        <!-- Contact Content -->
        <div class="contact-layout">
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            </div>

            <!-- Contact Info -->
            <aside class="contact-info">
                <div class="contact-info-card">
                    <h3><?php esc_html_e('Contact Information', 'worldonetrading'); ?></h3>

                    <div class="contact-info-item">
                        <span class="material-symbols-outlined">mail</span>
                        <div>
                            <span class="contact-info-label"><?php esc_html_e('Email', 'worldonetrading'); ?></span>
                            <a href="mailto:info@xotrad.com">info@xotrad.com</a>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <span class="material-symbols-outlined">schedule</span>
                        <div>
                            <span class="contact-info-label"><?php esc_html_e('Response Time', 'worldonetrading'); ?></span>
                            <span><?php esc_html_e('Within 24-48 hours', 'worldonetrading'); ?></span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <span class="material-symbols-outlined">location_on</span>
                        <div>
                            <span class="contact-info-label"><?php esc_html_e('Location', 'worldonetrading'); ?></span>
                            <span>Vancouver, BC, Canada</span>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <h3><?php esc_html_e('Before You Contact Us', 'worldonetrading'); ?></h3>
                    <p><?php esc_html_e('You may find answers to your questions in our help pages:', 'worldonetrading'); ?></p>
                    <ul class="contact-help-links">
                        <li><a href="<?php echo esc_url(home_url('/payment-shipping')); ?>">Payment & Shipping</a></li>
                        <li><a href="<?php echo esc_url(home_url('/refunds-returns')); ?>">Refunds & Returns</a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms & Conditions</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>
