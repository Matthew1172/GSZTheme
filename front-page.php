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
    <h1 class="text-white">Welcome to Grad School Zero.</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
		<h2 class="">Registrar announcements</h2>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-light">
					<tr>
						<th scope="col">Posted</th>
						<th scope="col">Title</th>
						<th scope="col">Excerpt</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$announcement_qry = array(
					'category_name' => 'announcement'
					);
					$query = new WP_Query($announcement_qry);
					if($query->have_posts())
					{
						while($query->have_posts())
						{
							$query->the_post();
							$date = get_the_date();
							$perma = get_the_permalink();
							$title = get_the_title();
							$excerpt = get_the_excerpt();
							echo "<tr>";
								echo "<td>$date</td>";
								echo "<td><a href='$perma'>$title</a></td>";
								echo "<td>$excerpt</td>";
							echo "</tr>";
						}
					}else{
						echo '<tr><td colspan="3">There are no announcements at this time.</td></tr>';
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-12">
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
  </div>
</div>
<?php get_footer(); ?>