<?php

/* CAPS | For CPT array
=================================================== */
function rec_post_type_capabilities($singular, $plural) {
    return [
		'create_posts'           	=> "create_$plural",
		'read'                   	=> "read_$plural",
        'read_post'		 			=> "read_$singular",
		'read_private_posts'	 	=> "read_private_$plural",
		'edit_post'		 			=> "edit_$singular",
        'edit_posts'		 		=> "edit_$plural",
        'edit_others_posts'	 		=> "edit_others_$plural",
		'edit_private_posts'     	=> "edit_private_$plural",
        'edit_published_posts'   	=> "edit_published_$plural",
        'delete_post'		 		=> "delete_$singular",
        'delete_posts'           	=> "delete_$plural",
        'delete_private_posts'   	=> "delete_private_$plural",
        'delete_published_posts' 	=> "delete_published_$plural",
        'delete_others_posts'   	=> "delete_others_$plural",
        'publish_posts'		 		=> "publish_$plural",
    ];
}




/* CAPS | For CPT
=================================================== */
function rec_post_type_add_capabilities($singular, $plural, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "read_$plural" );
			$role->add_cap( "read_$singular" );
			$role->add_cap( "read_private_$plural" );
			$role->add_cap( "edit_$plural" );
			$role->add_cap( "delete_$plural" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "read_$plural" );
			$role->remove_cap( "read_$singular" );
			$role->remove_cap( "read_private_$plural" );
			$role->remove_cap( "edit_$plural" );
			$role->remove_cap( "delete_$plural" );
		}
	}
}

function rec_post_type_add_capabilities_create($singular, $plural, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "create_$plural" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "create_$plural" );
		}
	}
}

function rec_post_type_add_capabilities_edit($singular, $plural, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "edit_$singular" );
			$role->add_cap( "edit_others_$plural" );
			$role->add_cap( "edit_private_$plural" );
			$role->add_cap( "edit_published_$plural" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "edit_$singular" );
			$role->remove_cap( "edit_others_$plural" );
			$role->remove_cap( "edit_private_$plural" );
			$role->remove_cap( "edit_published_$plural" );
		}
	}
}

function rec_post_type_add_capabilities_publish($singular, $plural, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "publish_$plural" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "publish_$plural" );
		}
	}
}

function rec_post_type_add_capabilities_delete($singular, $plural, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "delete_$singular" );
			$role->add_cap( "delete_others_$plural" );
			$role->add_cap( "delete_private_$plural" );
			$role->add_cap( "delete_published_$plural" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "delete_$singular" );
			$role->remove_cap( "delete_others_$plural" );
			$role->remove_cap( "delete_private_$plural" );
			$role->remove_cap( "delete_published_$plural" );
		}
	}
}




/* CAPS | For Taxonomy
=================================================== */
function rec_taxonomy_add_manage($tax, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "manage_rec_$tax" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "manage_rec_$tax" );
		}
	}
}

function rec_taxonomy_add_assign($tax, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( "edit_rec_$tax" );
		} else {
			$role = get_role( $role );
			$role->remove_cap( "edit_rec_$tax" );
		}
	}
}




/* CAPS | For ACF (SUB)PAGE
=================================================== */
function rec_add_capabilities_acf_page($page, $avaible_roles) {
	require_once ABSPATH .'wp-admin/includes/user.php';
	$roles = get_editable_roles();

	foreach($roles as $role => $caps) {
		if(in_array($role, $avaible_roles)) {
			$role = get_role( $role );
			$role->add_cap( $page );
		} else {
			$role = get_role( $role );
			$role->remove_cap( $page );
		}
	}
}