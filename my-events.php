<?php
/*
Plugin Name: My events
Plugin URI: http://www.bootjefinland.be
Description: Publish al the future events in your event category
Version: 1.0
License: GPL
Author: Nick Deboo
Author URI: http://www.bootjefinland.be
*/

function my_events()
{
	global $wpdb;
	$tposts	= $wpdb->posts;	
	$trel 	= $wpdb->term_relationships;
	
	// get event cat id
	$me_cat_id = get_option('myevents_cat_id');
	
	// select ID's
	$sql =	"SELECT object_id
				FROM $trel as r
				WHERE r.term_taxonomy_id = '$me_cat_id'";
				
	$res = $wpdb->get_results($sql);		
				
	foreach ($res as $p)
		$post_ids .= ','.$p->object_id;
		
	$post_ids =  substr($post_ids, 1);	//strip first comma
	
	// set future posts
	$sql =	"UPDATE $tposts SET post_status = 'publish'
				WHERE post_status = 'future'
				and ID IN ($post_ids)";
	$wpdb->get_results($sql);
}

// set menu
function me_menu($content)
{
	if (function_exists('add_options_page')) {
		add_options_page('My Events', 'My Events', 'manage_options', dirname(plugin_basename(__FILE__)).'/options.php') ;
	}
}

// create options
function me_create_options()
{
	add_option('myevents_cat_id', '');
}

// uninstall
function me_uninstall()
{
	delete_option('myevents_cat_id');
}

// Uninstall hook
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'me_uninstall'); 

add_action('init', 'my_events');
add_action('admin_menu', 'me_menu');
register_activation_hook(__FILE__,'me_create_options');

?>