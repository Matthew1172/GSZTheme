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
		<h2>Highest Rated Classes </h2>
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

	<div class="row">
    <div class="col-md-12">
		<h2>Lowest Rated Classes</h2>
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
					sort($average_ratings);
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

	<div class="row">
    <div class="col-md-12">
		<h2>Deans List</h2>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-light">
					<tr>
						<th scope="col">Ranking</th>
						<th scope="col">Student Name</th>
						<th scope="col">GPA</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$gp = 0.0;
				$numOfFactors = 0.0;
				$classes_query = array('post_type' => 'gradschoolzeroclass');
				$q = new WP_Query($classes_query);
				if($q->have_posts()){
						while($q->have_posts()){
								$q->the_post();
								$transcript_key = str_replace(" ", "", strtolower(get_the_title()))."_transcript";
								$fgrade_key = str_replace(" ", "", strtolower(get_the_title())) . "_fgrade";
								$blogusers = get_users(array('role__in' => array('student')));
								foreach($blogusers as $user){
										$uid = $user->ID;
										$name = $user->display_name;
										for($i = 1; $i < 5; $i++){
												if(get_user_meta($uid, $transcript_key."_".strval($i), true) == "taken"){
													$gf = get_user_meta($uid, $fgrade_key."_".strval($i), true);
													switch($gf){
                            case 'f':
                                $gp += 0.0;
                                $numOfFactors += 1.0;
                                break;
                            case 'd':
                                $gp += 1.0;
                                $numOfFactors += 1.0;
                                break;
                            case 'cm':
                                $gp += 1.7;
                                $numOfFactors += 1.0;
                                break;
                            case 'c':
                                $gp += 2.0;
                                $numOfFactors += 1.0;
                                break;
                            case 'cp':
                                $gp += 2.3;
                                $numOfFactors += 1.0;
                                break;
                            case 'bm':
                                $gp += 2.7;
                                $numOfFactors += 1.0;
                                break;
														case 'b':
																$gp += 3.0;
																$numOfFactors += 1.0;
																$gf_p = 'B';
																break;
														case 'bp':
																$gp += 3.3;
																$numOfFactors += 1.0;
																$gf_p = 'B+';
																break;
														case 'am':
																$gp += 3.7;
																$numOfFactors += 1.0;
																$gf_p = 'A-';
																break;
														case 'a':
																$gp += 4.0;
																$numOfFactors += 1.0;
																$gf_p = 'A';
																break;
														case 'ap':
																$gp += 4.0;
																$numOfFactors += 1.0;
																$gf_p = 'A+';
																break;
													}
												}
												if($numOfFactors > 0){
														$gpa = $gp/$numOfFactors;
														$allGpas[$name] = $gpa;
												}
										}
								}
						}
				}
				arsort($allGpas);
				array_slice($allGpas,0,5);
				$i = 0;
				foreach($allGpas as $name => $gpa){
					$i++;
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>$name</td>";
					echo "<td>$gpa</td>";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
		</div>
    </div>
  </div>
</div>
<?php get_footer(); ?>