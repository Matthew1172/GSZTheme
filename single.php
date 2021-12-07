<?php

/**
 * 
 * Displays a single post
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */

get_header();
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$postID = get_the_ID();
		//if the post category is studentTutorial then only students can view it.
		$cats = get_the_category($postID);

		$currentUser = wp_get_current_user();
		$uid = $currentUser->ID;
		$info = get_userdata($uid);
		$role = $info ? $info->roles[0] : 'none';

		if(($role == 'student' || $role == 'administrator') && $cats[1]->slug == 'studenttutorial' && count($cats) > 1){
		//display student tutorial
?>
	<div class="banner mb-5">
	  <div class="heading container">
		<h1 class="text-white"><?php the_title(); ?></h1>
	  </div>
	</div>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
			<h2>Posted on <?php the_date(); ?></h2>
			<?php the_content(); ?>
		</div>
	  </div>
	</div>
<?php	
		}else if($cats[1]->slug == 'studenttutorial' && count($cats) > 1){
		//you must be logged in as a student to view student tutorial
?>
	<div class="banner mb-5">
	  <div class="heading container">
		<h1 class="text-white">You must be logged in as a student to view the student tutorial.</h1>
	  </div>
	</div>
<?php	
		}else{
		//display the announcement
?>
	<div class="banner mb-5">
	  <div class="heading container">
		<h1 class="text-white"><?php the_title(); ?></h1>
	  </div>
	</div>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
			<h2>Posted on <?php the_date(); ?></h2>
			<?php the_content(); ?>
		</div>
	  </div>
	</div>
<?php	
		}
	}
}
get_footer();
