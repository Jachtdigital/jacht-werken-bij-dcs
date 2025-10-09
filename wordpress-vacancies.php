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
Version: 1.0.10
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

// Plugin activation hook
register_activation_hook(__FILE__, 'jacht_vacancies_activate');
function jacht_vacancies_activate() {
	require_once REC_PLUGIN_DIR . '/cpt/capabilities.php';

	// Set up capabilities for administrators and editors
	rec_post_type_add_capabilities('vacancy', 'vacancies', array('administrator', 'editor'));
	rec_post_type_add_capabilities_create('vacancy', 'vacancies', array('administrator', 'editor'));
	rec_post_type_add_capabilities_edit('vacancy', 'vacancies', array('administrator', 'editor'));
	rec_post_type_add_capabilities_publish('vacancy', 'vacancies', array('administrator', 'editor'));
	rec_post_type_add_capabilities_delete('vacancy', 'vacancies', array('administrator', 'editor'));

	// Flush rewrite rules
	flush_rewrite_rules();
}