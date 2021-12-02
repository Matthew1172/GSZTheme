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

get_header();
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$pid = get_the_ID();
		$title = get_the_title();
		$comments = get_comments(array('post_id' => $pid));

		$cap = get_post_meta($pid, 'cap', true);
		$st = get_post_meta($pid, 'startTime', true);
		$et = get_post_meta($pid, 'endTime', true);
		$sd = get_post_meta($pid, 'startDate', true);
		$ed = get_post_meta($pid, 'endDate', true);

		//pretty print date and times
		$start = $sd . $st;
		$end = $ed . $et;
		$startObj = new DateTime($start);
		$endObj = new DateTime($end);
		$startDateFinal = $startObj->format('F jS Y');
		$startTimeFinal = $startObj->format('h:i A');
		$endDateFinal = $endObj->format('F jS Y');
		$endTimeFinal = $endObj->format('h:i A');


		$loc = get_post_meta($pid, 'loc', true) == 'c' ? ' On campus' : 'In person';

		$days = "";
		$days .= get_post_meta($pid, 'm', true) == 'yes' ? 'Mo' : '';
		$days .= get_post_meta($pid, 't', true) == 'yes' ? 'Tu' : '';
		$days .= get_post_meta($pid, 'w', true) == 'yes' ? 'We' : '';
		$days .= get_post_meta($pid, 'h', true) == 'yes' ? 'Th' : '';
		$days .= get_post_meta($pid, 'f', true) == 'yes' ? 'Fr' : '';
		$days .= get_post_meta($pid, 's', true) == 'yes' ? 'Sa' : '';

		//Get an array of all the pre requisites for this course
		$prereq = array();
		$qry = array(
			'post_type' => 'gradschoolzeroclass'
		);
		$classes = new WP_Query($qry);
		if ($classes->have_posts()) {
			while ($classes->have_posts()) {
				$classes->the_post();
				$pre_pid = get_the_id();
				$pre_key = $pre_pid . '_pre';
				$pre = get_post_meta($pid, $pre_key, true);
				if ($pre == 'yes') {
					$p = get_post($pre_pid);
					$pre_name = $p->post_title;
					$pre_link = get_permalink($p);
					//key is prereq post title, value is prereq post link
					$prereq[$pre_name] = $pre_link;
				}
			}
		}

		$stu_count = 0;
		//get a count of all students currently enrolled in this course
		$blogusers = get_users(array('role__in' => array('student')));
		foreach ($blogusers as $user) {
			$uid = absint($user->ID);
			$enrollment_key = str_replace(" ", "", strtolower($title)) . "_enrollment";
			//get the enrollment status assigned for this user
			$en = get_user_meta($uid, $enrollment_key, true);
			//check if this user is enrolled to this class
			if ($en == 'e') {
				$stu_count++;
			}
		}

?>
		<div class="banner mb-5">
			<div class="heading container">
				<h1 class="text-white"><?php echo $title; ?></h1>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<?php
					echo "<h5>Class information</h5>";
					/*
				echo "<div class='table-responsive'>";
					echo "<table class='table'>";
						echo '<thead>';
							echo '<tr>';
								echo '<th scope="col">Capacity</th>';
								echo '<th scope="col">Time</th>';
								echo '<th scope="col">Semester</th>';
								echo '<th scope="col">Location</th>';
								echo '<th scope="col">Days</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
							echo '<tr>';
								echo "<td>$stu_count/$cap</td>";
								echo "<td>$startTimeFinal-$endTimeFinal</td>";
								echo "<td>$startDateFinal to $endDateFinal</td>";
								echo "<td>$loc</td>";
								echo "<td>$days</td>";
							echo '</tr>';
						echo '</tbody>';
					echo "</table>";
				echo "</div>";
				*/
					echo "<ul>";
					echo "<li>Capacity: $stu_count/$cap</li>";
					echo "<li>Time: $startTimeFinal-$endTimeFinal</li>";
					echo "<li>Semester: $startDateFinal to $endDateFinal</li>";
					echo "<li>Location: $loc</li>";
					echo "<li>Days: $days</li>";
					echo "</ul>";

					echo "<h5>Class pre-requisites</h5>";
					echo "<ul>";
					foreach ($prereq as $name => $link) {
						echo "<li><a href='$link'>$name</a></li>";
					}
					echo "</ul>";
					?>
				</div>

				<div class="col-md-8">
					<h5>Class description</h5>
					<?php the_content(); ?>
					<h5>Student reviews</h5>
					<?php
					echo "<div class='table-responsive'>";
					echo "<table class='table'>";
					echo '<thead>';
					echo '<tr>';
					echo '<th scope="col">DATE</th>';
					echo '<th scope="col">REVIEW</th>';
					echo '<th scope="col">RATING</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					$avg = 0.0;
					$sum = 0;
					$comment_count = count($comments);
					if ($comment_count > 0) {
						foreach ($comments as $c) {
							$comment_dateTime = $c->comment_date;
							$comment_dateTime_pretty = new DateTime($comment_dateTime);
							$comment_date_pretty = $startObj->format('F jS Y');

							$comment_content = $c->comment_content;

							$comment_rating = get_comment_meta($c->comment_ID, 'rat', true);
							$sum += $comment_rating;
							echo '<tr>';
							echo "<td>$comment_date_pretty</td>";
							echo "<td>$comment_content</td>";
							echo "<td>$comment_rating</td>";
							echo '</tr>';
						}
					} else {
						echo '<tr>';
						echo "<td>There are no reviews for this class.</td>";
						echo '</tr>';
					}
					echo '</tbody>';
					echo "</table>";
					echo "</div>";
					if ($comment_count > 0) {
						$avg = $sum / $comment_count;
						echo "<h5>Average rating: $avg</h5>";
					}
					?>
				</div>
			</div>



			<?php
			$currentUser = wp_get_current_user();
			$uid = $currentUser->ID;
			$info = get_userdata($uid);
			$role = $info ? $info->roles[0] : 'none';
			if ($role == 'student') :
				//display html button for enroll to class if capacity is not full
				//if it is, diplay a waitlist button
				//if the student has this class on their transcript, display an area to leave a comments
			?>
				<div class='row'>
					<div class="col-md-4">
						<?php
						//only display this area if the student is not enrolled
						//NOTE: a student can enroll or waitlist if taken before, because multiple attempts are allowed, even if that student got an A+
						$enrollment_key = str_replace(" ", "", strtolower($title)) . "_enrollment";
						$en = get_user_meta($uid, $enrollment_key, true);
						if ($en != 'e') {
							//display enroll or waitlist button
							if ($stu_count < $cap) {
								//display enroll button
								echo "<button id='$title-$uid-enroll' class='enroll-class btn btn-primary w-100'>Enroll</button>";
							} else if ($en != 'wl') {
								//display waitlist button
								echo "<button id='$title-$uid-waitlist' class='waitlist-class btn btn-primary w-100'>Waitlist</button>";
							} else {
								echo "<span class='w-100'>You're currently waitlisted for this class, however it is still closed. Please try again another time.</span>";
							}
						} else if ($en == 'e') {
							echo "<span class='w-100'>You are currently enrolled in this class. If you would like to drop the class, please click below to withdraw.</span> </p>";
							echo "<button id='$title-$uid-withdraw' class='drop-class btn btn-primary w-100'>Withdraw</button>";
						}
						?>
					</div>

					<div class="col-md-8">
						<?php
						//display comment area if student has this class on transcript and hasn't left a previous comment on this class

						//check if student has this class on their transcript
						$taken = false;
						$transcript_key = str_replace(" ", "", strtolower($title)) . "_transcript";
						for ($i = 1; $i < 5; $i++) {
							if (get_user_meta($uid, $transcript_key . "_" . strval($i), true) == "taken") {
								//this student has taken this class on some attempt 1->5
								$taken = true;
							}
						}

						$prev_review = false;
						foreach ($comments as $c) {
							if ($c->user_id == $uid) {
								$prev_review = true;
							}
						}

						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
<?php
	}
}
get_footer();
