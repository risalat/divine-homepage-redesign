<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Global_Chrome {
    public function __construct() {
        add_action('wp_body_open', [$this, 'render_global_header']);
        add_action('wp_footer', [$this, 'render_global_footer'], 30);
        add_filter('body_class', [$this, 'add_body_class']);
    }

    private function global_chrome_enabled(): bool {
        return !is_admin();
    }

    private function current_page_has_shortcode(string $tag): bool {
        global $post;
        return is_a($post, 'WP_Post') && has_shortcode((string) $post->post_content, $tag);
    }

    public function add_body_class(array $classes): array {
        if ($this->global_chrome_enabled()) {
            $classes[] = 'dm-global-chrome-enabled';
        }
        return $classes;
    }

    public function render_global_header(): void {
        if (!$this->global_chrome_enabled() || $this->current_page_has_shortcode('divine_homepage')) {
            return;
        }

        $urls = DM_Utils::get_urls();
        $logo_url = DM_Utils::get_logo_url();
        ?>
        <div class="dm-global-chrome dm-global-chrome--header">
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

            <header class="dm-site-header" aria-label="Divine Markings site header">
                <div class="dm-wrap dm-site-header__inner">
                    <a class="dm-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Divine Markings home">
                        <img class="dm-brand__logo" src="<?php echo esc_url($logo_url); ?>" alt="Divine Markings" loading="eager" decoding="async">
                    </a>

                    <button class="dm-menu-toggle" type="button" aria-expanded="false" aria-controls="dm-primary-nav-global">
                        <span></span><span></span><span></span>
                        <span class="screen-reader-text">Menu</span>
                    </button>

                    <nav id="dm-primary-nav-global" class="dm-primary-nav" aria-label="Primary navigation">
                        <?php echo DM_Utils::render_primary_navigation($urls); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </nav>

                    <div class="dm-header-actions">
                        <a class="dm-btn dm-btn--primary dm-btn--small" href="<?php echo esc_url(home_url('/#dm-tools')); ?>">Explore Tools <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </header>
        </div>
        <?php
    }

    public function render_global_footer(): void {
        if (!$this->global_chrome_enabled() || $this->current_page_has_shortcode('divine_homepage')) {
            return;
        }

        $urls = DM_Utils::get_urls();
        $logo_url = DM_Utils::get_logo_url();
        ?>
        <div class="dm-global-chrome dm-global-chrome--footer">
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
    }
}
