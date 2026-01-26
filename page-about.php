<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package WorldOneTrading
 */

get_header();
?>

<main class="page-wrapper about-page">

    <!-- Hero Section with Background Image -->
    <section class="about-hero" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=1920&q=80');">
        <div class="about-hero-overlay"></div>
        <div class="about-hero-content">
            <h1 class="about-hero-title">About XOTRAD</h1>
            <p class="about-hero-tagline">本物を、日本から世界へ。</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="page-inner">

        <!-- Introduction -->
        <section class="about-intro">
            <p class="about-intro-text">
                流行ではなく、時を超えて愛されるもの。<br>
                私たちは日本のヴィンテージ市場から、本当に価値のある一点だけを届けます。
            </p>
        </section>

        <!-- 4 Pillars Grid -->
        <section class="about-pillars">

            <div class="pillar-card">
                <div class="pillar-image">
                    <img src="https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=600&q=80" alt="Elegant necktie" loading="lazy">
                </div>
                <span class="pillar-number">01</span>
                <h2 class="pillar-title">Philosophy</h2>
                <h3 class="pillar-subtitle">本物を、日本から世界へ。</h3>
                <p class="pillar-text">
                    大量生産の時代に、あえて手間をかけて一点一点を選ぶ。それが私たちのスタイルです。身につけるものには意味があっていい。そう信じる方へ、XOTRADは存在します。
                </p>
            </div>

            <div class="pillar-card">
                <div class="pillar-image">
                    <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600&q=80" alt="Tokyo Japan" loading="lazy">
                </div>
                <span class="pillar-number">02</span>
                <h2 class="pillar-title">Japan Quality</h2>
                <h3 class="pillar-subtitle">日本品質という信頼。</h3>
                <p class="pillar-text">
                    世界一厳しい目を持つ日本の消費者。その市場で選ばれてきたアイテムだからこそ、状態が違います。日本では「中古品」でも丁寧に扱われ、保管されてきたものが多く存在します。私たちはその中から、さらに基準を満たすものだけを厳選しています。
                </p>
            </div>

            <div class="pillar-card">
                <div class="pillar-image">
                    <img src="https://images.unsplash.com/photo-1589756823695-278bc923f962?w=600&q=80" alt="Tie detail close-up" loading="lazy">
                </div>
                <span class="pillar-number">03</span>
                <h2 class="pillar-title">Authenticity</h2>
                <h3 class="pillar-subtitle">一点一点、鑑定済み。</h3>
                <p class="pillar-text">
                    Hermès、Gucci、Louis Vuitton——私たちは専門スタッフがすべてを手に取り、真贋を確認。縫製、素材、タグ、細部に至るまでチェック。少しでも疑わしいものは扱いません。「届いてがっかり」をゼロにすること。それが私たちの絶対のルールです。
                </p>
            </div>

            <div class="pillar-card">
                <div class="pillar-image">
                    <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=600&q=80" alt="Elegant gift packaging" loading="lazy">
                </div>
                <span class="pillar-number">04</span>
                <h2 class="pillar-title">Our Promise</h2>
                <h3 class="pillar-subtitle">私たちの約束。</h3>
                <div class="pillar-promises">
                    <div class="promise-item">
                        <span class="material-symbols-outlined">verified</span>
                        <span>100% 正規品保証</span>
                    </div>
                    <div class="promise-item">
                        <span class="material-symbols-outlined">search</span>
                        <span>日本国内で検品・鑑定</span>
                    </div>
                    <div class="promise-item">
                        <span class="material-symbols-outlined">local_shipping</span>
                        <span>世界中へ送料無料</span>
                    </div>
                    <div class="promise-item">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>14日間返品対応</span>
                    </div>
                </div>
                <p class="pillar-text">
                    万が一ご満足いただけない場合は、14日以内であれば返品を承ります。私たちは商品に自信があります。だからこそ、この約束ができるのです。
                </p>
            </div>

        </section>

        <!-- CTA Section -->
        <section class="about-cta">
            <h2 class="about-cta-title">Start Exploring</h2>
            <p class="about-cta-text">日本から届く、本物のラグジュアリーを。</p>
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-primary">Browse Collection</a>
        </section>

    </div>
</main>

<?php get_footer(); ?>
