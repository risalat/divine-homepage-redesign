<?php
/**
 * Plugin Name: Divine Markings Homepage Redesign
 * Description: A custom shortcode-based homepage redesign for DivineMarkings.com.
 * Version: 1.4.5
 * Author: Divine Markings
 * License: GPL-2.0-or-later
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('DMHR_ENABLE_POST_POLISH')) {
    define('DMHR_ENABLE_POST_POLISH', false);
}

define('DMHR_VERSION', '1.4.5');
define('DMHR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DMHR_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once DMHR_PLUGIN_DIR . 'includes/class-dm-utils.php';
require_once DMHR_PLUGIN_DIR . 'includes/class-dm-assets.php';
require_once DMHR_PLUGIN_DIR . 'includes/class-dm-homepage.php';
require_once DMHR_PLUGIN_DIR . 'includes/class-dm-global-chrome.php';
require_once DMHR_PLUGIN_DIR . 'includes/class-dm-tools.php';
require_once DMHR_PLUGIN_DIR . 'includes/class-dm-post-polish.php';

new DM_Utils();
new DM_Assets();
new DM_Homepage();
new DM_Global_Chrome();
new DM_Tools();
new DM_Post_Polish();
