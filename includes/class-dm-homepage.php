<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Homepage {
    public function __construct() {
        add_shortcode('divine_homepage', [$this, 'render_homepage']);
        add_filter('body_class', [$this, 'add_body_class']);
    }

    public function add_body_class(array $classes): array {
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode((string) $post->post_content, 'divine_homepage')) {
            $classes[] = 'dm-homepage-custom';
        }
        return $classes;
    }

    public function render_homepage(): string {
        $urls = DM_Utils::get_urls();

        $articles = [
            [
                'title' => 'Astrology Insights: 9 Predictions From the Stars',
                'url' => 'https://divinemarkings.com/astrology-insights-9-predictions-from-the-stars/',
                'category' => 'Astrology',
                'date' => 'Featured Guide',
                'excerpt' => 'Look up, tune in, and see what the sky may be whispering about your next chapter.',
                'class' => 'dm-article-art--moon',
            ],
            [
                'title' => 'Master Numbers in Numerology',
                'url' => 'https://divinemarkings.com/master-numbers-in-numerology/',
                'category' => 'Numerology',
                'date' => 'Deep Meaning',
                'excerpt' => 'Learn why master numbers carry amplified energy, lessons, and spiritual responsibility.',
                'class' => 'dm-article-art--numbers',
            ],
            [
                'title' => 'How to Choose the Right Birthstone for You',
                'url' => 'https://divinemarkings.com/how-to-choose-the-right-birthstone-for-you/',
                'category' => 'Crystals',
                'date' => 'Practical Guide',
                'excerpt' => 'Find the birthstone that matches your energy, intention, and personal season.',
                'class' => 'dm-article-art--crystal',
            ],
            [
                'title' => 'The Role of Birthstones in Reiki and Energy Healing',
                'url' => 'https://divinemarkings.com/role-of-birthstones-in-reiki-and-energy-healing/',
                'category' => 'Energy Healing',
                'date' => 'Spiritual Wellness',
                'excerpt' => 'Explore how birthstones are used as symbolic anchors in energy work and healing rituals.',
                'class' => 'dm-article-art--energy',
            ],
        ];

        $categories = [
            [
                'title' => 'Spiritual Meanings',
                'url' => $urls['spiritual_meanings'],
                'count' => DM_Utils::format_article_count('spiritual-meanings', 458),
                'icon' => '✧',
                'text' => 'Explore the hidden meaning behind signs, symbols, dreams, and everyday moments.',
            ],
            [
                'title' => 'Angel Numbers',
                'url' => $urls['angel_numbers'],
                'count' => DM_Utils::format_article_count('angel-numbers', 256),
                'icon' => '111',
                'text' => 'Decode repeating numbers and the messages they may be bringing into your life.',
            ],
            [
                'title' => 'Dreams Biblical Meanings',
                'url' => $urls['dreams_biblical'],
                'count' => DM_Utils::format_article_count('dreams-biblical-meanings', 176),
                'icon' => '☁',
                'text' => 'Understand symbolic dream themes through a biblical and spiritual lens.',
            ],
            [
                'title' => 'Biblical Meanings',
                'url' => $urls['biblical_meanings'],
                'count' => DM_Utils::format_article_count('biblical-meanings', 152),
                'icon' => '☉',
                'text' => 'Discover the meaning of people, places, animals, numbers, and signs in scripture.',
            ],
            [
                'title' => 'Numerology',
                'url' => $urls['numerology'],
                'count' => DM_Utils::format_article_count('numerology', 29),
                'icon' => '7',
                'text' => 'Use numbers to better understand personality, purpose, timing, and life patterns.',
            ],
            [
                'title' => 'Tarot',
                'url' => $urls['tarot'],
                'count' => DM_Utils::format_article_count('tarot', 23),
                'icon' => '☾',
                'text' => 'Learn tarot card meanings, intuitive spreads, and daily reading guidance.',
            ],
        ];

        $intentions = [
            ['Love', '♡', $urls['zodiac_compatibility']],
            ['Career', '♜', $urls['articles']],
            ['Spiritual Growth', '✦', $urls['spiritual_meanings']],
            ['Dreams', '☾', $urls['dreams_biblical']],
            ['Guidance', '✺', $urls['tarot_card']],
            ['Self-Discovery', '♙', $urls['numerology']],
            ['Manifestation', '☼', $urls['articles']],
        ];

        $tarot_preview = 'https://divinemarkings.com/wp-content/uploads/2026/05/DivineMarkings-Tarot.jpg';
        $logo_url = DM_Utils::get_logo_url();

        $hero_stats = [
            ['label' => 'Tarot Guides', 'url' => $urls['tarot'], 'count' => DM_Utils::format_count('tarot', 23)],
            ['label' => 'Spiritual Meanings', 'url' => $urls['spiritual_meanings'], 'count' => DM_Utils::format_count('spiritual-meanings', 458)],
            ['label' => 'Angel Numbers', 'url' => $urls['angel_numbers'], 'count' => DM_Utils::format_count('angel-numbers', 256)],
            ['label' => 'Dream Meanings', 'url' => $urls['dreams_biblical'], 'count' => DM_Utils::format_count('dreams-biblical-meanings', 176)],
        ];

        ob_start();
        ?>
        <div id="dm-home" class="dm-home">
            <a class="dm-skip-link" href="#dm-main">Skip to content</a>

            <div class="dm-top-strip" aria-label="Site announcement">
                <div class="dm-wrap dm-top-strip__inner">
                    <span>✧ Ancient wisdom, modern guidance.</span>
                    <span>Free tools • In-depth meanings • Fresh spiritual insights</span>
                    <nav aria-label="Quick links">
                        <a href="<?php echo esc_url($urls['about']); ?>">About</a>
                        <a href="<?php echo esc_url($urls['contact']); ?>">Contact</a>
                    </nav>
                </div>
            </div>

            <header class="dm-site-header" aria-label="Divine Markings homepage header">
                <div class="dm-wrap dm-site-header__inner">
                    <a class="dm-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Divine Markings home">
                        <img class="dm-brand__logo" src="<?php echo esc_url($logo_url); ?>" alt="Divine Markings" loading="eager" decoding="async">
                    </a>

                    <button class="dm-menu-toggle" type="button" aria-expanded="false" aria-controls="dm-primary-nav">
                        <span></span><span></span><span></span>
                        <span class="screen-reader-text">Menu</span>
                    </button>

                    <nav id="dm-primary-nav" class="dm-primary-nav" aria-label="Primary navigation">
                        <?php echo DM_Utils::render_primary_navigation($urls); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </nav>

                    <div class="dm-header-actions">
                        <a class="dm-btn dm-btn--primary dm-btn--small" href="#dm-tools">Explore Tools <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </header>

            <main id="dm-main">
                <section class="dm-hero" aria-labelledby="dm-hero-title">
                    <div class="dm-stars" aria-hidden="true"></div>
                    <div class="dm-orb dm-orb--one" aria-hidden="true"></div>
                    <div class="dm-orb dm-orb--two" aria-hidden="true"></div>
                    <div class="dm-moon" aria-hidden="true"></div>

                    <div class="dm-wrap dm-hero__inner">
                        <div class="dm-zodiac-wheel" aria-hidden="true">
                            <span>♈</span><span>♉</span><span>♊</span><span>♋</span><span>♌</span><span>♍</span>
                            <span>♎</span><span>♏</span><span>♐</span><span>♑</span><span>♒</span><span>♓</span>
                            <i></i>
                        </div>

                        <div class="dm-hero__content">
                            <p class="dm-kicker">✦ Welcome to DivineMarkings.com ✦</p>
                            <h1 id="dm-hero-title">Guidance for Your Path, <span>Written in the Stars.</span></h1>
                            <p class="dm-hero__lead">Explore tarot, numerology, zodiac insights, spiritual meanings, angel numbers, and biblical dream symbolism in one beautifully guided place.</p>
                            <div class="dm-hero__actions">
                                <a class="dm-btn dm-btn--gold" href="<?php echo esc_url($urls['tarot_card']); ?>">Try the Tarot Card of the Day <span aria-hidden="true">→</span></a>
                                <a class="dm-btn dm-btn--ghost" href="<?php echo esc_url($urls['spiritual_meanings']); ?>">Explore Meanings <span aria-hidden="true">☉</span></a>
                            </div>
                        </div>

                        <div class="dm-hero-stats" aria-label="Popular content sections">
                            <?php foreach ($hero_stats as $stat) : ?>
                                <a href="<?php echo esc_url($stat['url']); ?>"><strong><?php echo esc_html($stat['count']); ?></strong><span><?php echo esc_html($stat['label']); ?></span></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <section id="dm-tools" class="dm-section dm-tools" aria-labelledby="dm-tools-title">
                    <div class="dm-wrap">
                        <div class="dm-section-head dm-section-head--center">
                            <span class="dm-divider" aria-hidden="true"></span>
                            <p class="dm-kicker dm-kicker--gold">Start With a Tool</p>
                            <h2 id="dm-tools-title">Find the insight you came for.</h2>
                            <p>Quick spiritual tools designed to turn curiosity into a meaningful next click.</p>
                        </div>

                        <div class="dm-tool-grid-v2">
                            <article class="dm-tool-v2 dm-tool-v2--featured">
                                <div class="dm-tool-v2__top">
                                    <span class="dm-tool-v2__icon" aria-hidden="true">☼</span>
                                    <span class="dm-tool-v2__badge">Most Popular</span>
                                </div>
                                <div class="dm-tool-v2__body">
                                    <h3>Tarot Card of the Day</h3>
                                    <p>Draw daily guidance and uncover the message the universe has for you today.</p>
                                </div>
                                <a class="dm-tool-v2__cta" href="<?php echo esc_url($urls['tarot_card']); ?>">Reveal Today’s Card <span aria-hidden="true">→</span></a>
                            </article>

                            <article class="dm-tool-v2 dm-tool-v2--zodiac">
                                <div class="dm-tool-v2__top">
                                    <span class="dm-tool-v2__icon" aria-hidden="true">♡</span>
                                </div>
                                <div class="dm-tool-v2__body">
                                    <h3>Zodiac Compatibility</h3>
                                    <p>See how your sign connects in love, friendship, energy, and emotional rhythm.</p>
                                </div>
                                <a class="dm-tool-v2__cta" href="<?php echo esc_url($urls['zodiac_compatibility']); ?>">Check Compatibility <span aria-hidden="true">→</span></a>
                            </article>

                            <article class="dm-tool-v2 dm-tool-v2--life-path">
                                <div class="dm-tool-v2__top">
                                    <span class="dm-tool-v2__icon" aria-hidden="true">7</span>
                                </div>
                                <div class="dm-tool-v2__body">
                                    <h3>Life Path Calculator</h3>
                                    <p>Reveal your life path number and the blueprint behind your personality and purpose.</p>
                                </div>
                                <a class="dm-tool-v2__cta" href="<?php echo esc_url($urls['life_path']); ?>">Calculate My Path <span aria-hidden="true">→</span></a>
                            </article>

                            <article class="dm-tool-v2 dm-tool-v2--horoscope">
                                <div class="dm-tool-v2__top">
                                    <span class="dm-tool-v2__icon" aria-hidden="true">☾</span>
                                </div>
                                <div class="dm-tool-v2__body">
                                    <h3>Daily Horoscope</h3>
                                    <p>Get today’s zodiac insight for timing, choices, relationships, and self-reflection.</p>
                                </div>
                                <a class="dm-tool-v2__cta" href="<?php echo esc_url($urls['daily_horoscope']); ?>">Read Today’s Horoscope <span aria-hidden="true">→</span></a>
                            </article>
                        </div>
                    </div>
                </section>

                <section class="dm-section dm-tarot-feature" aria-labelledby="dm-tarot-feature-title">
                    <div class="dm-wrap">
                        <div class="dm-tarot-panel">
                            <div class="dm-browser-card" aria-label="Tarot Card of the Day preview">
                                <div class="dm-browser-card__bar" aria-hidden="true"><span></span><span></span><span></span></div>
                                <img src="<?php echo esc_url($tarot_preview); ?>" alt="Preview of the DivineMarkings Tarot Card of the Day page showing The Sun tarot card" loading="lazy">
                            </div>

                            <div class="dm-tarot-copy">
                                <p class="dm-kicker dm-kicker--gold">☼ Today’s Featured Reading</p>
                                <h2 id="dm-tarot-feature-title">The Sun (XIX)</h2>
                                <blockquote>“The Sun represents success, abundance, and clarity. Step into your light today.”</blockquote>
                                <div class="dm-chip-row" aria-label="Tarot themes">
                                    <span>success</span><span>clarity</span><span>joy</span>
                                </div>
                                <div class="dm-tarot-actions">
                                    <a class="dm-btn dm-btn--primary" href="<?php echo esc_url($urls['tarot_card']); ?>">Reveal Today’s Card <span aria-hidden="true">→</span></a>
                                    <a class="dm-text-link" href="<?php echo esc_url($urls['tarot']); ?>">View all tarot meanings <span aria-hidden="true">→</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dm-section dm-categories" aria-labelledby="dm-categories-title">
                    <div class="dm-wrap">
                        <div class="dm-section-head dm-section-head--center">
                            <span class="dm-divider" aria-hidden="true"></span>
                            <p class="dm-kicker dm-kicker--gold">Explore Popular Topics</p>
                            <h2 id="dm-categories-title">Choose the doorway that matches your question.</h2>
                            <p>Deep content hubs built around the themes visitors already love most.</p>
                        </div>

                        <div class="dm-category-grid">
                            <?php foreach ($categories as $category) : ?>
                                <a class="dm-category-card" href="<?php echo esc_url($category['url']); ?>">
                                    <span class="dm-category-card__icon" aria-hidden="true"><?php echo esc_html($category['icon']); ?></span>
                                    <span class="dm-category-card__title"><?php echo esc_html($category['title']); ?></span>
                                    <span class="dm-category-card__text"><?php echo esc_html($category['text']); ?></span>
                                    <span class="dm-category-card__count"><?php echo esc_html($category['count']); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <div class="dm-center-link">
                            <a class="dm-text-link" href="<?php echo esc_url($urls['articles']); ?>">Browse all articles <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </section>

                <section class="dm-section dm-articles" aria-labelledby="dm-articles-title">
                    <div class="dm-wrap">
                        <div class="dm-section-head dm-section-head--split">
                            <div>
                                <p class="dm-kicker dm-kicker--gold">Latest Insights</p>
                                <h2 id="dm-articles-title">Fresh guides for curious souls.</h2>
                            </div>
                            <a class="dm-text-link" href="<?php echo esc_url($urls['articles']); ?>">View all articles <span aria-hidden="true">→</span></a>
                        </div>

                        <div class="dm-article-grid">
                            <?php foreach ($articles as $index => $article) : ?>
                                <article class="dm-article-card <?php echo $index === 0 ? 'dm-article-card--large' : ''; ?>">
                                    <a class="dm-article-card__art <?php echo esc_attr($article['class']); ?>" href="<?php echo esc_url($article['url']); ?>" aria-label="<?php echo esc_attr($article['title']); ?>"></a>
                                    <div class="dm-article-card__body">
                                        <span class="dm-article-card__cat"><?php echo esc_html($article['category']); ?></span>
                                        <h3><a href="<?php echo esc_url($article['url']); ?>"><?php echo esc_html($article['title']); ?></a></h3>
                                        <p><?php echo esc_html($article['excerpt']); ?></p>
                                        <span class="dm-article-card__meta"><?php echo esc_html($article['date']); ?></span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <section class="dm-intentions" aria-labelledby="dm-intentions-title">
                    <div class="dm-wrap">
                        <h2 id="dm-intentions-title">Browse by Intention</h2>
                        <div class="dm-intention-row">
                            <?php foreach ($intentions as $intention) : ?>
                                <a href="<?php echo esc_url($intention[2]); ?>"><span aria-hidden="true"><?php echo esc_html($intention[1]); ?></span><?php echo esc_html($intention[0]); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <section class="dm-community" aria-labelledby="dm-community-title">
                    <div class="dm-wrap dm-community__inner">
                        <div class="dm-community__symbol" aria-hidden="true">☽☼</div>
                        <div class="dm-community__copy">
                            <p class="dm-kicker">Join the Circle</p>
                            <h2 id="dm-community-title">Get weekly spiritual insights and new guides.</h2>
                            <p>Tarot reflections, meaning guides, number symbolism, and fresh articles delivered with a little extra sparkle.</p>
                        </div>
                        <div class="dm-community__form-wrap">
                            <?php echo DM_Utils::render_convertkit_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="dm-footer" aria-label="Divine Markings footer">
                <div class="dm-wrap dm-footer__grid">
                    <div class="dm-footer__brand">
                        <a class="dm-brand dm-brand--footer" href="<?php echo esc_url(home_url('/')); ?>">
                            <img class="dm-brand__logo" src="<?php echo esc_url($logo_url); ?>" alt="Divine Markings" loading="lazy" decoding="async">
                        </a>
                        <p>Ancient wisdom. Modern guidance. Empowering you to live with clarity, purpose, and spiritual alignment.</p>
                    </div>

                    <nav aria-label="Explore links">
                        <h3>Explore</h3>
                        <a href="<?php echo esc_url($urls['tarot']); ?>">Tarot</a>
                        <a href="<?php echo esc_url($urls['zodiac']); ?>">Zodiac</a>
                        <a href="<?php echo esc_url($urls['numerology']); ?>">Numerology</a>
                        <a href="<?php echo esc_url($urls['spiritual_meanings']); ?>">Spiritual Meanings</a>
                        <a href="<?php echo esc_url($urls['angel_numbers']); ?>">Angel Numbers</a>
                    </nav>

                    <nav aria-label="Resource links">
                        <h3>Resources</h3>
                        <a href="<?php echo esc_url($urls['biblical_meanings']); ?>">Biblical Meanings</a>
                        <a href="<?php echo esc_url($urls['daily_horoscope']); ?>">Daily Horoscope</a>
                        <a href="<?php echo esc_url($urls['tarot_card']); ?>">Tarot Card of the Day</a>
                        <a href="<?php echo esc_url($urls['life_path']); ?>">Life Path Calculator</a>
                        <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>">Compatibility Checker</a>
                    </nav>

                    <nav aria-label="Company links">
                        <h3>Company</h3>
                        <a href="<?php echo esc_url($urls['about']); ?>">About Us</a>
                        <a href="<?php echo esc_url($urls['contact']); ?>">Contact Us</a>
                        <a href="<?php echo esc_url($urls['privacy']); ?>">Privacy Policy</a>
                        <a href="<?php echo esc_url($urls['articles']); ?>">Articles</a>
                    </nav>
                </div>

                <div class="dm-wrap dm-footer__bottom">
                    <span>✦ © <?php echo esc_html(date_i18n('Y')); ?> DivineMarkings.com. All rights reserved.</span>
                </div>
            </footer>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}
