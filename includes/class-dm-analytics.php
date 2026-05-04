<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Analytics {
    private const OPTION_KEY = 'dmhr_soul_quiz_analytics';

    private const ALLOWED_EVENTS = [
        'quiz_card_seen',
        'quiz_started',
        'quiz_completed',
        'result_clarity',
        'result_love',
        'result_purpose',
        'result_protection',
        'result_transformation',
        'primary_cta_clicked',
        'secondary_cta_clicked',
        'continue_reading_clicked',
        'retake_clicked',
    ];

    private const DEFAULTS = [
        'quiz_card_seen'           => 0,
        'quiz_started'             => 0,
        'quiz_completed'           => 0,
        'result_clarity'           => 0,
        'result_love'              => 0,
        'result_purpose'           => 0,
        'result_protection'        => 0,
        'result_transformation'    => 0,
        'primary_cta_clicked'      => 0,
        'secondary_cta_clicked'    => 0,
        'continue_reading_clicked' => 0,
        'retake_clicked'           => 0,
    ];

    public function __construct() {
        add_action('wp_ajax_nopriv_dmhr_track_soul_quiz', [$this, 'track_event']);
        add_action('wp_ajax_dmhr_track_soul_quiz', [$this, 'track_event']);
        add_action('admin_post_dmhr_reset_soul_quiz_analytics', [$this, 'handle_reset']);
    }

    public function track_event(): void {
        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'] ?? '')), 'dmhr_soul_quiz_analytics')) {
            wp_send_json_error(['message' => 'Invalid security token.']);
        }

        $event = sanitize_text_field(wp_unslash($_POST['event'] ?? ''));
        if (!in_array($event, self::ALLOWED_EVENTS, true)) {
            wp_send_json_error(['message' => 'Invalid event.']);
        }

        $totals = self::get_totals();
        $totals[$event] = ($totals[$event] ?? 0) + 1;
        update_option(self::OPTION_KEY, $totals, false);

        wp_send_json_success(['event' => $event]);
    }

    public static function get_totals(): array {
        $stored = get_option(self::OPTION_KEY, []);
        if (!is_array($stored)) {
            $stored = [];
        }
        return array_merge(self::DEFAULTS, $stored);
    }

    public static function reset(): void {
        update_option(self::OPTION_KEY, self::DEFAULTS, false);
    }

    public function handle_reset(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'divine-homepage-redesign'));
        }

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'] ?? '')), 'dmhr_reset_soul_quiz_analytics')) {
            wp_die(esc_html__('Invalid security token.', 'divine-homepage-redesign'));
        }

        self::reset();

        wp_safe_redirect(admin_url('options-general.php?page=dmhr-settings&dmhr_analytics_reset=1'));
        exit;
    }
}
