<?php

use Recruitee\Notification;
use Jacht\Constants;

/* TEXT DOMAIN
=================================================== */
load_plugin_textdomain('jacht-vacancies', false, REC_PLUGIN_NAME . '/languages/');


/* ADMIN | CSS
=================================================== */
add_action('admin_enqueue_scripts', function() {
	if (isset($_GET['post_type']) && $_GET['post_type'] === Constants::POST_TYPE) {
		wp_register_style('custom_wp_admin_css', plugin_dir_url(__FILE__) . 'css/style.css', false, '1.0.0');
		wp_enqueue_style('custom_wp_admin_css');
	}
});


/* AUTO-POPULATE LOCATIE FIELD
=================================================== */
add_action('acf/save_post', 'jacht_auto_populate_location', 20);
function jacht_auto_populate_location($post_id) {
	// Only for vacancy post type
	if (get_post_type($post_id) !== Constants::POST_TYPE) {
		return;
	}

	// Get location components (including empty values)
	$city = get_field('vac_city', $post_id) ?: '';
	$province = get_field('vac_state_name', $post_id) ?: '';
	$country = get_field('vac_country', $post_id) ?: '';

	// Build location string (concat all, even if empty)
	$location = trim($city . ', ' . $province . ', ' . $country, ', ');

	// Update the location field
	update_field('vac_location', $location, $post_id);
}
