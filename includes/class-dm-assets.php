<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Assets {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    private function current_page_has_shortcode(string $tag): bool {
        global $post;
        return is_a($post, 'WP_Post') && has_shortcode((string) $post->post_content, $tag);
    }

    private function global_chrome_enabled(): bool {
        return !is_admin();
    }

    private function is_single_post_polish(): bool {
        return DM_Utils::post_polish_enabled() && !is_admin() && is_singular('post') && get_post_type() === 'post';
    }

    private function any_feature_active(): bool {
        return $this->current_page_has_shortcode('divine_homepage')
            || $this->current_page_has_shortcode('divine_zodiac_compatibility')
            || $this->current_page_has_shortcode('divine_life_path_calculator')
            || $this->current_page_has_shortcode('divine_daily_horoscope')
            || $this->global_chrome_enabled()
            || $this->is_single_post_polish();
    }

    public function enqueue_assets(): void {
        if (!$this->any_feature_active()) {
            return;
        }

        $base_url = DMHR_PLUGIN_URL . 'assets/';

        wp_enqueue_style('dm-core', $base_url . 'css/dm-core.css', [], DMHR_VERSION);
        wp_enqueue_script('dm-core', $base_url . 'js/dm-core.js', [], DMHR_VERSION, true);
        wp_script_add_data('dm-core', 'defer', true);

        if ($this->current_page_has_shortcode('divine_homepage')) {
            wp_enqueue_style('dm-homepage', $base_url . 'css/dm-homepage.css', ['dm-core'], DMHR_VERSION);
        }

        if ($this->current_page_has_shortcode('divine_zodiac_compatibility')) {
            wp_enqueue_style('dm-tool-zodiac', $base_url . 'css/dm-tool-zodiac.css', ['dm-core'], DMHR_VERSION);
            wp_enqueue_script('dm-tool-zodiac', $base_url . 'js/dm-tool-zodiac.js', [], DMHR_VERSION, true);
            wp_script_add_data('dm-tool-zodiac', 'defer', true);
        }

        if ($this->current_page_has_shortcode('divine_life_path_calculator')) {
            wp_enqueue_style('dm-tool-life-path', $base_url . 'css/dm-tool-life-path.css', ['dm-core'], DMHR_VERSION);
            wp_enqueue_script('dm-tool-life-path', $base_url . 'js/dm-tool-life-path.js', [], DMHR_VERSION, true);
            wp_script_add_data('dm-tool-life-path', 'defer', true);
        }

        if ($this->current_page_has_shortcode('divine_daily_horoscope')) {
            wp_enqueue_style('dm-tool-horoscope', $base_url . 'css/dm-tool-horoscope.css', ['dm-core'], DMHR_VERSION);
            wp_enqueue_script('dm-tool-horoscope', $base_url . 'js/dm-tool-horoscope.js', [], DMHR_VERSION, true);
            wp_script_add_data('dm-tool-horoscope', 'defer', true);
        }

        if ($this->is_single_post_polish()) {
            wp_enqueue_style('dm-post-polish', $base_url . 'css/dm-post-polish.css', ['dm-core'], DMHR_VERSION);
            wp_enqueue_script('dm-post-polish', $base_url . 'js/dm-post-polish.js', [], DMHR_VERSION, true);
            wp_script_add_data('dm-post-polish', 'defer', true);
        }
    }
}
