<?php
/*
Plugin Name: Jacht - Werken bij DCS
Plugin URI: https://jacht.digital
Description: Job vacancies management for WordPress websites.
Requires PHP: 8.1
Requires at least: 6.2
Requires Plugins: advanced-custom-fields-pro
Author: Jacht Digital Marketing
Author URI: https://jacht.digital
Version: 1.0.1
Text Domain: jacht-vacancies
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}

define('REC_PLUGIN', __FILE__);
define('REC_PLUGIN_BASENAME', plugin_basename(REC_PLUGIN));
define('REC_PLUGIN_NAME', trim(dirname(REC_PLUGIN_BASENAME), '/'));
define('REC_PLUGIN_DIR', untrailingslashit(dirname(REC_PLUGIN)));
define('REC_PLUGIN_URI', plugin_dir_url(__FILE__));

require_once REC_PLUGIN_DIR . '/load.php';