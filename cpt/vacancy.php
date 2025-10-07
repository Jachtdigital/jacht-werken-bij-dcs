<?php

use Jacht\Constants;

/* CPT - VACANCY | DECLARE
=================================================== */
add_action('init', 'rec_cpt_vacancy', 0);
function rec_cpt_vacancy() {

	$cpt_title 		= apply_filters('rec_cpt_title', __('Vacatures', 'jacht-vacancies'));
	$cpt_single 	= apply_filters('rec_cpt_single', __('Vacature', 'jacht-vacancies'));
	$capabilities   = rec_post_type_capabilities(Constants::POST_TYPE, 'vacancies');

	$labels = array(
		'name'               	=> $cpt_title,
		'singular_name'      	=> $cpt_single,
        'add_new'            	=> sprintf(_x('Nieuwe %s', 'Variant 1', 'jacht-vacancies'), strtolower($cpt_single)),
        'add_new_item'       	=> sprintf(_x('Nieuwe %s', 'Variant 1', 'jacht-vacancies'), strtolower($cpt_single)),
        'edit_item'          	=> sprintf(__('Bewerk %s', 'jacht-vacancies'), strtolower($cpt_single)),
        'new_item'           	=> sprintf(_x('Nieuwe %s', 'Variant 1', 'jacht-vacancies'), strtolower($cpt_single)),
		'view_item'          	=> sprintf(__('Bekijk %s', 'jacht-vacancies'), strtolower($cpt_single)),
        'view_items'          	=> sprintf(__('Bekijk %s', 'jacht-vacancies'), strtolower($cpt_title)),
        'search_items'       	=> sprintf(__('Zoek %s', 'jacht-vacancies'), strtolower($cpt_title)),
        'not_found'          	=> sprintf(__('Geen %s gevonden', 'jacht-vacancies'), strtolower($cpt_title)),
		'not_found_in_trash' 	=> sprintf(__('Geen %s gevonden in prullenbak', 'jacht-vacancies'), strtolower($cpt_title)),
        'all_items'          	=> sprintf(__('Alle %s', 'jacht-vacancies'), strtolower($cpt_title)),
        'attributes'            => sprintf(__('%s attributen', 'jacht-vacancies'), $cpt_single),
		'insert_into_item'      => sprintf(__('Invoegen in deze %s', 'jacht-vacancies'), strtolower($cpt_single)),
        'uploaded_to_this_item' => sprintf(__('Geüpload naar deze %s', 'jacht-vacancies'), strtolower($cpt_single)),
		'featured_image'        => __( 'Uitgelichte afbeelding', 'jacht-vacancies' ),
		'set_featured_image'    => __( 'Uitgelichte afbeelding instellen', 'jacht-vacancies' ),
		'remove_featured_image' => __( 'Uitgelichte afbeelding verwijderen', 'jacht-vacancies' ),
		'use_featured_image'    => __( 'Gebruik als uitgelichte afbeelding', 'jacht-vacancies' ),
	);

	$args = [
		'labels'              	=> $labels,
		'description'         	=> $cpt_title,
		'public'              	=> true,
        'hierarchical'        	=> false,
        'show_ui'             	=> true,
        'show_in_rest'          => true,
        'menu_position'       	=> 5,
		'menu_icon'           	=> apply_filters('rec_cpt_icon', 'dashicons-universal-access-alt'),
		'supports'            	=> apply_filters('rec_cpt_supports', array('title', 'editor')),
		'capabilities'			=> $capabilities,
		'has_archive'         	=> true,
		'rewrite' 			  	=> array('slug' => apply_filters('rec_cpt_slug', 'jobs'), 'with_front' => false),
        'can_export'          	=> true,
	];

	register_post_type(Constants::POST_TYPE, $args);
}


/* CPT - VACANCY | TAXONOMIES
=================================================== */
add_action('init', 'rec_taxonomies_vacancy', 0);
function rec_taxonomies_vacancy() {

	$taxonomies = apply_filters('rec_cpt_taxonomies', array(
		'department' => [
			'slug' 			=> 'department',
			'title' 		=> __('Afdelingen', 'jacht-vacancies'),
			'single' 		=> __('Afdeling', 'jacht-vacancies'),
			'manage_roles' 	=> array('administrator'),
			'assign_roles' 	=> array('administrator')
		],
	));

	foreach($taxonomies as $taxonomy) {
		$tax_slug 		= $taxonomy['slug'];
		$tax_title 		= $taxonomy['title'];
		$tax_single 	= $taxonomy['single'];

		$labels = array(
			'name'                  => $tax_title,
			'singular_name'         => $tax_single,
			'menu_name'             => $tax_title,
			'all_items'          	=> sprintf(__('Alle %s', 'jacht-vacancies'), strtolower($tax_title)),
			'edit_item'          	=> sprintf(__('Bewerk %s', 'jacht-vacancies'), strtolower($tax_single)),
			'view_item'          	=> sprintf(__('Bekijk %s', 'jacht-vacancies'), strtolower($tax_single)),
			'update_item'          	=> sprintf(__('Update %s', 'jacht-vacancies'), strtolower($tax_single)),
			'add_new_item'       	=> sprintf(__('Nieuwe %s toevoegen', 'jacht-vacancies'), strtolower($tax_single)),
			'new_item_name'         => sprintf(__('Nieuwe %s naam', 'jacht-vacancies'), strtolower($tax_single)),
			'search_items'          => sprintf(__('Zoek %s', 'jacht-vacancies'), strtolower($tax_title)),
			'popular_items'         => sprintf(__('Populaire %s', 'jacht-vacancies'), strtolower($tax_title)),
			'add_or_remove_items'   => sprintf(__('Toevoegen of verwijderen %s', 'jacht-vacancies'), strtolower($tax_title)),
			'choose_from_most_used' => sprintf(__('Kies uit de meest gebruikte %s', 'jacht-vacancies'), strtolower($tax_title)),
			'not_found'             => sprintf(__('Geen %s gevonden', 'jacht-vacancies'), strtolower($tax_title)),
			'back_to_items'         => sprintf(__('Terug naar %s', 'jacht-vacancies'), strtolower($tax_title)),
		);
	
		$args = array(
			'labels'            => $labels,
			'public'			=> false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
			'capabilities'      => array(
				'manage_terms'	=>	'manage_rec_' . $tax_slug,
				'edit_terms'	=>	'manage_rec_' . $tax_slug,
				'delete_terms'	=>	'manage_rec_' . $tax_slug,
				'assign_terms'	=>	'edit_rec_' . $tax_slug,
			),
		);

		rec_taxonomy_add_manage($tax_slug, $taxonomy['manage_roles']);
		rec_taxonomy_add_assign($tax_slug, $taxonomy['assign_roles']);

		register_taxonomy('rec_' . $tax_slug, Constants::POST_TYPE, $args);
	}
}



/* CPT - VACANCY | ADMIN COLUMNS / DATA
=================================================== */
add_filter('manage_vacancy_posts_columns', 'rec_admin_columns_vacancy');
function rec_admin_columns_vacancy($columns){

	$columns = apply_filters('rec_cpt_columns', [
		'cb'       					=> '<input type="checkbox" />',
		'title'    					=> __('Functietitel', 'jacht-vacancies'),
		'taxonomy-rec_department' 	=> __('Afdelingen', 'jacht-vacancies')
	]);

	return $columns;
}




/* CPT - VACANCY | Add settings page
=================================================== */
add_action('admin_menu', 'rec_register_settings');
function rec_register_settings() {
	add_submenu_page(
		'edit.php?post_type=' . Constants::POST_TYPE,
		__('Instellingen', 'jacht-vacancies'),
		__('Instellingen', 'jacht-vacancies'),
		'rec_manage_options',
		'recruitee-settings',
		'rec_callback_settings_page'
	);

	rec_add_capabilities_acf_page('rec_manage_options', apply_filters('rec_settings_caps_roles', array('administrator')));
}

function rec_callback_settings_page() {
	include_once(REC_PLUGIN_DIR . "/templates/settings.php");
}


/* CPT - VACANCY | Add duplicate functionality
=================================================== */
add_filter('post_row_actions', 'rec_duplicate_vacancy_link', 10, 2);
function rec_duplicate_vacancy_link($actions, $post) {
	if ($post->post_type === Constants::POST_TYPE && current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rec_duplicate_vacancy&post=' . $post->ID, 'rec_duplicate_' . $post->ID) . '" title="' . __('Dupliceer deze vacature', 'jacht-vacancies') . '">' . __('Dupliceren', 'jacht-vacancies') . '</a>';
	}
	return $actions;
}

add_action('admin_action_rec_duplicate_vacancy', 'rec_duplicate_vacancy');
function rec_duplicate_vacancy() {
	if (empty($_GET['post'])) {
		wp_die(__('Geen vacature om te dupliceren geselecteerd', 'jacht-vacancies'));
	}

	$post_id = absint($_GET['post']);
	check_admin_referer('rec_duplicate_' . $post_id);

	$post = get_post($post_id);
	if (!$post || $post->post_type !== Constants::POST_TYPE) {
		wp_die(__('Dupliceren mislukt: vacature niet gevonden', 'jacht-vacancies'));
	}

	// Create duplicate post
	$new_post = array(
		'post_title'   => $post->post_title . ' (kopie)',
		'post_content' => $post->post_content,
		'post_status'  => 'draft',
		'post_type'    => $post->post_type,
		'post_author'  => get_current_user_id()
	);

	$new_post_id = wp_insert_post($new_post);

	if (is_wp_error($new_post_id)) {
		wp_die(__('Dupliceren mislukt', 'jacht-vacancies'));
	}

	// Duplicate all post meta
	$post_meta = get_post_meta($post_id);
	foreach ($post_meta as $meta_key => $meta_values) {
		foreach ($meta_values as $meta_value) {
			add_post_meta($new_post_id, $meta_key, maybe_unserialize($meta_value));
		}
	}

	// Duplicate taxonomies
	$taxonomies = get_object_taxonomies($post->post_type);
	foreach ($taxonomies as $taxonomy) {
		$terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'ids'));
		wp_set_object_terms($new_post_id, $terms, $taxonomy);
	}

	wp_redirect(admin_url('edit.php?post_type=' . Constants::POST_TYPE));
	exit;
}