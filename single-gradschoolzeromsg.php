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

require 'header.php';
if (have_posts()) {
  while (have_posts()) {
    the_post();
    $postID = get_the_ID();
    $postType = get_post_type(get_the_ID());

    $currentUser = wp_get_current_user();
    $current_user_id = $currentUser->ID;
    $info = get_userdata($current_user_id);
    $role = $info ? $info->roles[0] : 'none';

    //if they are an admin, they can see all messages.
    //we need to query the post meta for this message with the key <current user id>_recipient is equal to "yes"
    //else they're either not signed in, or they're not a recipient of this message, so redirect them to the home page
    if ($role == 'administrator') {
      //display the message
      the_title();
    }else if(get_post_meta($postID, $current_user_id.'_recipient') == "yes"){
      //they are a recipient of this message, so display it
      the_title();
    }else{
      //redirect home
      wp_redirect(home_url());
    }
  }
}
require 'footer.php';