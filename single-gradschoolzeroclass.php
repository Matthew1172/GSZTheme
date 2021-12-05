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
		$args = array(
			'post_id' => $pid, 
			'status' => 'approve'
		);
		
		$comments = get_comments($args);

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

		$d = array();
		if(get_post_meta($pid, 'm', true) == 'yes'){
			array_push($d, 'Mo');
		}
		if(get_post_meta($pid, 't', true) == 'yes'){
			array_push($d, 'Tu');
		}
		if(get_post_meta($pid, 'w', true) == 'yes'){
			array_push($d, 'We');
		}
		if(get_post_meta($pid, 'h', true) == 'yes'){
			array_push($d, 'Th');
		}
		if(get_post_meta($pid, 'f', true) == 'yes'){
			array_push($d, 'Fr');
		}
		if(get_post_meta($pid, 's', true) == 'yes'){
			array_push($d, 'Sa');
		}

		$days = "";
		foreach($d as $day){
			$days .= $day;
		}
		
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
		
		//get the instructors assigned to this class
		$instructors = array();
		$blogusers = get_users(array('role__in' => array('instructor')));
		foreach ($blogusers as $user) {
			$iid = absint($user->ID);
			$assignment_key = str_replace(" ", "", strtolower($title)) . "_assignment";
			$as = get_user_meta($iid, $assignment_key, true);
			if ($as == 'a') {
				array_push($instructors, $user->display_name);
			}
		}
		
		$instructors_pretty = "";
		if(count($instructors) > 0){
			foreach($instructors as $i){
				$instructors_pretty .= $i.', ';
			}
			$instructors_pretty = substr($instructors_pretty, 0, -2);
		}else{
			$instructors_pretty = "TBD";
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
					echo "<ul>";
						echo "<li>Capacity: $stu_count/$cap</li>";
						echo "<li>Time: $startTimeFinal-$endTimeFinal</li>";
						echo "<li>Semester: $startDateFinal to $endDateFinal</li>";
						echo "<li>Location: $loc</li>";
						echo "<li>Days: $days</li>";
						echo "<li>Instructor: $instructors_pretty</li>";
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

									$comment_rating = get_comment_meta($c->comment_ID, 'rating', true);
									$sum += $comment_rating; //this line is causing an error
									$comment_rating = review($comment_rating);
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
			$phase = get_user_meta($uid, 'phase', true);
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
						$id_title = strtolower(str_replace(' ', '', $title));
						$en = get_user_meta($uid, $enrollment_key, true);
						
						//check if student meets all prereqs
						$satisfy_pre = true;
						foreach ($prereq as $name => $link) {
							//check if student has this class on their transcript
							$taken = false;
							$transcript_key = str_replace(" ", "", strtolower($name)) . "_transcript";
							for ($i = 1; $i < 5; $i++) {
								if (get_user_meta($uid, $transcript_key . "_" . strval($i), true) == "taken") {
									//this student has taken this class on some attempt 1->5
									$taken = true;
								}
							}
							if(!$taken){
								$satisfy_pre = false;
								break;
							}
						}
						
						//check if this user has a time conflict
						$time_conflict = false;
						//Get all the courses this student is enrolled in
						//and check for a time conflict with this class
						$enrolled = array();
						$qry = array(
							'post_type' => 'gradschoolzeroclass'
						);
						$classes = new WP_Query($qry);
						if ($classes->have_posts()) {
							while ($classes->have_posts()) {
								$classes->the_post();
								$e_pid = get_the_id();
								$e_title = get_the_title();
								$enrollment_key = str_replace(" ", "", strtolower($e_title)) . "_enrollment";
								$e = get_user_meta($uid, $enrollment_key, true);
								if ($e == 'e') {
									//the student is enrolled in the class, so get the time, date, and days of the class
									$e_st = get_post_meta($e_pid, 'startTime', true);
									$e_et = get_post_meta($e_pid, 'endTime', true);
									$e_sd = get_post_meta($e_pid, 'startDate', true);
									$e_ed = get_post_meta($e_pid, 'endDate', true);

									
									$e_d = array();
									if(get_post_meta($e_pid, 'm', true) == 'yes'){
										array_push($e_d, 'Mo');
									}
									if(get_post_meta($e_pid, 't', true) == 'yes'){
										array_push($e_d, 'Tu');
									}
									if(get_post_meta($e_pid, 'w', true) == 'yes'){
										array_push($e_d, 'We');
									}
									if(get_post_meta($e_pid, 'h', true) == 'yes'){
										array_push($e_d, 'Th');
									}
									if(get_post_meta($e_pid, 'f', true) == 'yes'){
										array_push($e_d, 'Fr');
									}
									if(get_post_meta($e_pid, 's', true) == 'yes'){
										array_push($e_d, 'Sa');
									}
									
									
									$periods = array(
										array(
											'start_time' => $st,
											'end_time' => $et
										),
										array(
											'start_time' => $e_st,
											'end_time' => $e_et
										)
									);
									//check if this class is in the same start and end date
									$p = datesOverlap($sd, $ed, $e_sd, $e_ed);
									//check if times overlap
									$q = isOverlapped($periods);
									//check if days overlap
									$k = count(array_intersect($d, $e_d)) > 0 ? true : false;
									//set time conflict flag
									if($p && $q && $k){
										$time_conflict = true;
										break;
									}
								}
							}
						}
						
						if($en == 'e'){
							echo "<span class='w-100'>You are currently enrolled in this class. If you would like to drop the class, please click below to withdraw.</span>";
							echo "<button id='$id_title-$uid-withdraw' class='drop-class btn btn-primary w-100'>Withdraw</button>";
							
						}else if(!$satisfy_pre){
							echo "<span class='w-100'>You do not meet the pre-requisites for this class.</span>";
						}else if($time_conflict){
							echo "<span class='w-100'>This class has a time conflict with another class you're currently enrolled in.</span>";
						}else{
							//display enroll or waitlist button
							if ($stu_count < $cap) {
								//display enroll button
								echo "<button id='$id_title-$uid-enroll' class='enroll-class btn btn-primary w-100'>Enroll</button>";
							} else if ($en != 'wl') {
								//display waitlist button
								echo "<button id='$id_title-$uid-waitlist' class='waitlist-class btn btn-primary w-100'>Waitlist</button>";
							} else {
								echo "<span class='w-100'>You're currently waitlisted for this class, however it is still closed. Please try again another time.</span>";
							}
						}

						?>
					</div>

					<div class="col-md-8">
						<?php
						//display comment area if student hasn't left a previous comment on this class

						$prev_review = false;
						foreach ($comments as $c) {
							if ($c->user_id == $uid) {
								$prev_review = true;
							}
						}
						
						//if the user is in the grading period or course running period they can leave a review
						switch($phase){
							case 'crup':
							case 'gp':
								if(!$prev_review){
									comments_template();
								}else{
									echo "<span>You have already left a review for this class.</span>";
								}
							
							break;
							default:
								echo "<span>You can only leave a review during the course running period, or the grading period.</span>";
								break;
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
