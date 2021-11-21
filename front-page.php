<?php

/**
 * 
 * Home page for the gradschoolzero Theme.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
get_header();
require 'inc/front-page-function.php';
?>
<div class="banner mb-5">
  <div class="heading container">
    <h1 class="text-white">Grad School Zero.</h1>
  </div>
</div>
<div class="container">
	<h2>Top Average Ratings</h2>
    <div class="table-responsive">
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">Class Name</th>
					<th scope="col">Rating</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($average_ratings as $average) :
					echo ('<tr> <th class="w-5">' . $average->getClass_name() . '</th>
								<th class="w-5">' . $average->getAverage_rating() . '</th> </tr>');
				endforeach;
			?>
			</tbody>
		</table>
	</div>
</div>
<?php get_footer(); ?>