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
    }

    public function sanitize_checkbox(mixed $value): bool {
        return !empty($value);
    }

    public function render_settings_page(): void {
        if (!current_user_can(self::CAPABILITY)) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'divine-homepage-redesign'));
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <p>
                <strong><?php esc_html_e('Plugin Version:', 'divine-homepage-redesign'); ?></strong>
                <?php echo esc_html(DMHR_VERSION); ?>
            </p>

            <form method="post" action="options.php">
                <?php
                settings_fields('dmhr_settings_group');
                do_settings_sections('dmhr_settings_group');
                $enabled = (bool) get_option(self::OPTION_NAME, false);
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
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
