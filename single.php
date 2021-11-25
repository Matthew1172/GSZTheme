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
get_footer();