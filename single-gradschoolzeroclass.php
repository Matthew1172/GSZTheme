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

    if ($role == 'student') {
      //display html button for enroll to class
    }else if($role == 'instructor'){
      //display html button for request to be instructor?
    }else{
      //nothing
    }


    //put the html for the class
    the_title();
  }
}
require 'footer.php';