<?php

/**
 * 
 * Displays a single Grad School Zero message
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
		$terms = wp_get_object_terms($pid, 'messagetypes');
		$type = "";
		foreach($terms as $i){
			$type .= $i->name.', ';
		}
		$type = substr($type, 0, -2);
		?>
		<div class="banner mb-5">
		  <div class="heading container">
			<h1 class="text-white"><?php the_title(); ?></h1>
		  </div>
		</div>
		<div class="container">
		  <div class="row">
			<div class="col-md-12">
				<h5>Posted on <?php the_date(); ?></h5>
				
				<h5>Type: <?php echo $type; ?></h5>
				<?php the_content(); ?>
			</div>
		  </div>
		</div>
		<?php
		get_footer();
    }else{
		//redirect home
		wp_redirect(home_url());
    }
  }
}