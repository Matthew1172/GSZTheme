<?php

/**
 * 
 * Profile page for the gradschoolzero Theme.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */

if (is_user_logged_in()) {
	//get the current user logged in
  $currentUser = wp_get_current_user();
  //retrieve their wp user id
  $currentId = $currentUser->ID;
  //get all the wp data associated with this user
  $info = get_userdata($currentId);
  //get the first role they have (either student, instructor, or administrator)
  $currentRole = $info->roles[0];
  //base on their role, include seperate php files.
  switch ($currentRole) {
    case 'instructor':
      get_header();
      include 'template-parts/profile/profile_instructor.php';
      get_footer();
      break;
    case 'student':
      get_header();
      include 'template-parts/profile/profile_student.php';
      get_footer();
      break;
    case 'administrator':
		wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
      break;
  }
} else {
  wp_redirect(home_url());
}