<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Settings {
    private const OPTION_NAME = 'dmhr_enable_post_polish';
    private const PAGE_SLUG   = 'dmhr-settings';
    private const CAPABILITY  = 'manage_options';

    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page(): void {
        add_options_page(
            __('Divine Markings Settings', 'divine-homepage-redesign'),
            __('Divine Markings', 'divine-homepage-redesign'),
            self::CAPABILITY,
            self::PAGE_SLUG,
            [$this, 'render_settings_page']
        );
    }

    public function register_settings(): void {
        register_setting(
            'dmhr_settings_group',
            self::OPTION_NAME,
            [
                'type'              => 'boolean',
                'sanitize_callback' => [$this, 'sanitize_checkbox'],
                'default'           => false,
            ]
        );
        register_setting(
            'dmhr_settings_group',
            'dmhr_enable_soul_quiz',
            [
                'type'              => 'boolean',
                'sanitize_callback' => [$this, 'sanitize_checkbox'],
                'default'           => false,
            ]
        );
    }

    public function sanitize_checkbox(mixed $value): bool {
        return !empty($value);
    }

    public function render_settings_page(): void {
        if (!current_user_can(self::CAPABILITY)) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'divine-homepage-redesign'));
        }

        $enabled = (bool) get_option(self::OPTION_NAME, false);
        $quiz_enabled = (bool) get_option('dmhr_enable_soul_quiz', false);
        $totals = DM_Analytics::get_totals();
        $reset_done = !empty($_GET['dmhr_analytics_reset']);
        ?>
        <style>
          .dmhr-analytics-panel { background: #fff; border: 1px solid #c3c4c7; border-radius: 8px; padding: 20px 24px; margin-top: 24px; max-width: 860px; }
          .dmhr-analytics-panel h2 { margin: 0 0 6px; font-size: 18px; }
          .dmhr-analytics-note { color: #646970; font-size: 12px; margin: 0 0 18px; }
          .dmhr-metric-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-bottom: 20px; }
          .dmhr-metric-card { background: #f6f7f7; border: 1px solid #dcdcde; border-radius: 6px; padding: 14px 16px; }
          .dmhr-metric-card strong { display: block; font-size: 22px; line-height: 1; color: #1d2327; margin-bottom: 6px; }
          .dmhr-metric-card span { font-size: 12px; color: #3c434a; }
          .dmhr-metric-card em { display: block; font-size: 11px; color: #646970; margin-top: 4px; font-style: normal; }
          .dmhr-result-bars { display: grid; gap: 8px; max-width: 520px; }
          .dmhr-result-bar { display: grid; grid-template-columns: 90px 1fr auto; align-items: center; gap: 10px; }
          .dmhr-result-bar__track { height: 10px; background: #f0f0f1; border-radius: 999px; overflow: hidden; }
          .dmhr-result-bar__fill { height: 100%; background: linear-gradient(90deg, #4B0082, #6b11a5); border-radius: 999px; }
          .dmhr-result-bar__label { font-size: 12px; color: #3c434a; }
          .dmhr-result-bar__count { font-size: 12px; color: #646970; text-align: right; }
        </style>

        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <p>
                <strong><?php esc_html_e('Plugin Version:', 'divine-homepage-redesign'); ?></strong>
                <?php echo esc_html(DMHR_VERSION); ?>
            </p>

            <?php if ($reset_done) : ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e('Soul Signal Quiz analytics reset.', 'divine-homepage-redesign'); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('dmhr_settings_group');
                do_settings_sections('dmhr_settings_group');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr(self::OPTION_NAME); ?>">
                                <?php esc_html_e('Enable Single Post Polish', 'divine-homepage-redesign'); ?>
                            </label>
                        </th>
                        <td>
                            <label for="<?php echo esc_attr(self::OPTION_NAME); ?>">
                                <input
                                    type="checkbox"
                                    id="<?php echo esc_attr(self::OPTION_NAME); ?>"
                                    name="<?php echo esc_attr(self::OPTION_NAME); ?>"
                                    value="1"
                                    <?php checked($enabled, true); ?>
                                />
                                <?php esc_html_e('Enable experimental single post polish styles', 'divine-homepage-redesign'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Experimental. Turn off instantly if posts show layout issues.', 'divine-homepage-redesign'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="dmhr_enable_soul_quiz">
                                <?php esc_html_e('Enable Mid-Article Soul Signal Quiz', 'divine-homepage-redesign'); ?>
                            </label>
                        </th>
                        <td>
                            <label for="dmhr_enable_soul_quiz">
                                <input
                                    type="checkbox"
                                    id="dmhr_enable_soul_quiz"
                                    name="dmhr_enable_soul_quiz"
                                    value="1"
                                    <?php checked($quiz_enabled, true); ?>
                                />
                                <?php esc_html_e('Adds an interactive quiz card inside polished single posts', 'divine-homepage-redesign'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Experimental. Turn off if it causes layout issues.', 'divine-homepage-redesign'); ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>

            <div class="dmhr-analytics-panel">
                <h2><?php esc_html_e('Soul Signal Quiz Analytics', 'divine-homepage-redesign'); ?></h2>
                <p class="dmhr-analytics-note">
                    <?php esc_html_e('Privacy-safe lifetime totals. No personal data, IPs, answers, or user identifiers are stored.', 'divine-homepage-redesign'); ?>
                </p>

                <div class="dmhr-metric-grid">
                    <?php
                    $seen = (int) $totals['quiz_card_seen'];
                    $started = (int) $totals['quiz_started'];
                    $completed = (int) $totals['quiz_completed'];
                    $primaryCta = (int) $totals['primary_cta_clicked'];
                    $secondaryCta = (int) $totals['secondary_cta_clicked'];
                    $continueReading = (int) $totals['continue_reading_clicked'];
                    $retakes = (int) $totals['retake_clicked'];

                    $start_rate = $seen > 0 ? round(($started / $seen) * 100, 1) : 0;
                    $completion_rate = $started > 0 ? round(($completed / $started) * 100, 1) : 0;
                    $primary_rate = $completed > 0 ? round(($primaryCta / $completed) * 100, 1) : 0;
                    $secondary_rate = $completed > 0 ? round(($secondaryCta / $completed) * 100, 1) : 0;
                    ?>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($seen); ?></strong>
                        <span><?php esc_html_e('Card views', 'divine-homepage-redesign'); ?></span>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($started); ?></strong>
                        <span><?php esc_html_e('Quiz starts', 'divine-homepage-redesign'); ?></span>
                        <em><?php echo esc_html($start_rate); ?>% <?php esc_html_e('start rate', 'divine-homepage-redesign'); ?></em>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($completed); ?></strong>
                        <span><?php esc_html_e('Completions', 'divine-homepage-redesign'); ?></span>
                        <em><?php echo esc_html($completion_rate); ?>% <?php esc_html_e('completion rate', 'divine-homepage-redesign'); ?></em>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($primaryCta); ?></strong>
                        <span><?php esc_html_e('Primary CTA clicks', 'divine-homepage-redesign'); ?></span>
                        <em><?php echo esc_html($primary_rate); ?>% <?php esc_html_e('of completions', 'divine-homepage-redesign'); ?></em>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($secondaryCta); ?></strong>
                        <span><?php esc_html_e('Secondary CTA clicks', 'divine-homepage-redesign'); ?></span>
                        <em><?php echo esc_html($secondary_rate); ?>% <?php esc_html_e('of completions', 'divine-homepage-redesign'); ?></em>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($continueReading); ?></strong>
                        <span><?php esc_html_e('Continue reading', 'divine-homepage-redesign'); ?></span>
                    </div>
                    <div class="dmhr-metric-card">
                        <strong><?php echo number_format_i18n($retakes); ?></strong>
                        <span><?php esc_html_e('Retakes', 'divine-homepage-redesign'); ?></span>
                    </div>
                </div>

                <h3 style="margin:0 0 10px;font-size:14px;"><?php esc_html_e('Top Results', 'divine-homepage-redesign'); ?></h3>
                <div class="dmhr-result-bars">
                    <?php
                    $result_keys = ['clarity', 'love', 'purpose', 'protection', 'transformation'];
                    $result_total = 0;
                    foreach ($result_keys as $rk) {
                        $result_total += (int) $totals['result_' . $rk];
                    }
                    foreach ($result_keys as $rk) :
                        $count = (int) $totals['result_' . $rk];
                        $pct = $result_total > 0 ? round(($count / $result_total) * 100, 1) : 0;
                        ?>
                        <div class="dmhr-result-bar">
                            <div class="dmhr-result-bar__label"><?php echo esc_html(ucfirst($rk)); ?></div>
                            <div class="dmhr-result-bar__track"><div class="dmhr-result-bar__fill" style="width:<?php echo esc_attr($pct); ?>%"></div></div>
                            <div class="dmhr-result-bar__count"><?php echo number_format_i18n($count); ?> (<?php echo esc_html($pct); ?>%)</div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <p style="margin-top:18px;">
                    <a class="button button-secondary" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=dmhr_reset_soul_quiz_analytics'), 'dmhr_reset_soul_quiz_analytics')); ?>" onclick="return confirm('<?php echo esc_js(__('Reset all Soul Signal Quiz analytics counters to zero? This cannot be undone.', 'divine-homepage-redesign')); ?>');">
                        <?php esc_html_e('Reset quiz analytics', 'divine-homepage-redesign'); ?>
                    </a>
                </p>
            </div>
        </div>
        <?php
    }
}
