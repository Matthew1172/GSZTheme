<?php

/**
 * 
 * Displays a single Grad School Zero class
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */

if (have_posts()) {
  while (have_posts()) {
    the_post();
    $pid = get_the_ID();
    $postType = get_post_type(get_the_ID());

    $currentUser = wp_get_current_user();
    $currentId = $currentUser->ID;
    $info = get_userdata($currentId);
    $role = $info ? $info->roles[0] : 'none';
	
	$rec_key = strval($currentId).'_recipient';
	$rec = get_post_meta($pid ,$rec_key, true);

    //if they are an admin, they can see all messages.
    //we need to query the post meta for this message with the key <current user id>_recipient is equal to "yes"
    //else they're either not signed in, or they're not a recipient of this message, so redirect them to the home page
    if ($role == 'administrator' || $rec == "yes") {
		get_header(); 
		//display the message
		the_title();
		get_footer();
    }else{
		//redirect home
		wp_redirect(home_url());
    }
  }
}