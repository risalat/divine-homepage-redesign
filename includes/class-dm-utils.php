<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Utils {
    public static function get_logo_url(): string {
        return 'https://divinemarkings.com/wp-content/uploads/2026/05/Divine-markings-Logo-e1777730751955.png';
    }

    public static function get_urls(): array {
        return [
            'tarot_card' => 'https://divinemarkings.com/free-tarot-card-of-the-day/',
            'zodiac_compatibility' => 'https://divinemarkings.com/zodiac-sign-compatibility-checker/',
            'life_path' => 'https://divinemarkings.com/life-path-number-calculator/',
            'daily_horoscope' => 'https://divinemarkings.com/your-daily-horoscope/',
            'tarot' => 'https://divinemarkings.com/category/tarot/',
            'zodiac' => 'https://divinemarkings.com/category/horoscope/zodiac-flower/',
            'numerology' => 'https://divinemarkings.com/category/numerology/',
            'spiritual_meanings' => 'https://divinemarkings.com/category/spiritual-meanings/',
            'angel_numbers' => 'https://divinemarkings.com/category/numerology/angel-numbers/',
            'biblical_meanings' => 'https://divinemarkings.com/category/biblical-meanings/',
            'dreams_biblical' => 'https://divinemarkings.com/category/biblical-meanings/dreams-biblical-meanings/',
            'articles' => 'https://divinemarkings.com/blog/',
            'about' => 'https://divinemarkings.com/about-serena-willow/',
            'contact' => 'https://divinemarkings.com/contact/',
            'privacy' => 'https://divinemarkings.com/privacy-policy-2/',
        ];
    }

    public static function get_category_count(string $slug, int $fallback): array {
        $term = get_category_by_slug($slug);
        if (!$term) {
            $term = get_term_by('slug', $slug, 'category');
        }
        if ($term instanceof WP_Term) {
            return [(int) $term->count, true];
        }
        return [$fallback, false];
    }

    public static function format_count(string $slug, int $fallback): string {
        [$count, $is_dynamic] = self::get_category_count($slug, $fallback);
        return number_format_i18n($count) . ($is_dynamic ? '' : '+');
    }

    public static function format_article_count(string $slug, int $fallback): string {
        return sprintf('%s Articles', self::format_count($slug, $fallback));
    }

    public static function render_convertkit_form(): string {
        $shortcode = '[convertkit form=8851554]';
        if (shortcode_exists('convertkit')) {
            $output = do_shortcode($shortcode);
            if (trim($output) !== '' && trim($output) !== $shortcode) {
                return '<div class="dm-convertkit-form">' . $output . '</div>';
            }
        }
        $admin_note = '';
        if (is_user_logged_in() && current_user_can('manage_options')) {
            $admin_note = '<p class="dm-convertkit-note">ConvertKit shortcode <code>' . esc_html($shortcode) . '</code> is not rendering yet. Make sure the ConvertKit plugin is active and the form ID exists.</p>';
        }
        return '<div class="dm-convertkit-fallback"><p>Get weekly spiritual insights, meaning guides, and new readings delivered to your inbox.</p>' . $admin_note . '</div>';
    }

    public static function render_primary_navigation(array $urls): string {
        $menu_html = '';
        $menu_id = 0;
        $locations = get_nav_menu_locations();
        $preferred_locations = ['primary', 'main', 'menu-1', 'header', 'main-menu'];

        foreach ($preferred_locations as $location) {
            if (!empty($locations[$location])) {
                $menu_id = (int) $locations[$location];
                break;
            }
        }

        if (!$menu_id) {
            foreach (['Main', 'Primary', 'Main Menu', 'Primary Menu'] as $menu_name) {
                $menu = wp_get_nav_menu_object($menu_name);
                if ($menu instanceof WP_Term) {
                    $menu_id = (int) $menu->term_id;
                    break;
                }
            }
        }

        if ($menu_id) {
            $menu_html = wp_nav_menu([
                'menu' => $menu_id,
                'container' => false,
                'menu_class' => 'dm-primary-nav__list',
                'menu_id' => '',
                'depth' => 1,
                'fallback_cb' => false,
                'echo' => false,
            ]);
        }

        if (is_string($menu_html) && trim($menu_html) !== '') {
            return $menu_html;
        }

        $fallback_items = [
            ['Tarot', $urls['tarot']],
            ['Zodiac', $urls['zodiac']],
            ['Numerology', $urls['numerology']],
            ['Meanings', $urls['spiritual_meanings']],
            ['Articles', $urls['articles']],
        ];

        $html = '<ul class="dm-primary-nav__list dm-primary-nav__list--fallback">';
        foreach ($fallback_items as [$label, $url]) {
            $html .= '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
