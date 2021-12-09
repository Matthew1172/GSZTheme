<?php

/**
 * 
 * Profile page for the instructor of gradschoolzero.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
 ?>
 
<div class="banner">
    <div class="heading container">
		<?php
			$fname = $info->first_name;
			$lname = $info->last_name;
			echo "<h1 class='text-white'>Welcome back, $fname $lname</h1>";
		?>
    </div>
    <div class="container" style="padding-left: 0px; padding-right: 0px;">
        <div id='dashBtn' class="dashRow btn-group btn-group-justified">
            <button onclick="openPage('my-info')" class="tablink dash-my-info-btn btn-outline-secondary profile-btn" id="defaultOpen">My information</button>
            <button onclick="openPage('my-schedule')" class="tablink dash-my-schedule-btn btn-outline-secondary profile-btn">My Schedule</button>
            <button onclick="openPage('my-msg')" class="tablink dash-my-msg-btn btn-outline-secondary profile-btn">My Messages</button>
            <button onclick="openPage('update')" class="tablink dash-update-btn btn-outline-secondary profile-btn">Update my account</button>
        </div>
    </div>
    <div id='dashDrp' class="dashRow" style="display: none;">
        <select class="form-select" id="drop-selector">
            <option selected="selected" value="my-info">My information</option>
            <option value="my-schedule">My Schedule</option>
            <option value="my-msg">My Messages</option>
            <option value="update">Update my account</option>
        </select>
    </div>
</div>
<div class="control-area">
    <div id="my-info" class="tabcontent">
        <div class="container">
            <h2 class="">My information</h2>
            <hr />
            <?php
			$warn = get_user_meta($currentId, 'warn', true);
			$status = get_user_meta($currentId, 'status', true);
			switch($status){
				case 'emp':
					$status = 'Employed';
					break;
				case 'fir':
					$status = 'Fired';
					break;
			}
			$phase = get_user_meta($currentId, 'phase', true);
			switch($phase){
				case 'csp':
					$phasePretty = 'Course set-up period';
					break;
				case 'crp':
					$phasePretty = 'Course registration period';
					break;
				case 'scrp':
					$phasePretty = 'Special course registration period';
					break;
				case 'crup':
					$phasePretty = 'Course running period';
					break;
				case 'gp':
					$phasePretty = 'Grading period';
					break;
				case 'pgp':
					$phasePretty = 'Post grading period';
					break;
			}
			echo "<h5 class='bColor2'>Warnings: <span class='bColor'>$warn</span></h5>";
			echo "<h5 class='bColor2'>Status: <span class='bColor'>$status</span></h5>";
			echo "<h5 class='bColor2'>Phase: <span class='bColor'>$phasePretty</span></h5>";
			
			//If instructor is in phase <gp> then we will display a table of each class they're assigned to,
			//as well as a dropdown menu with a grade for each student in that class
				echo "<h2>My students</h2>";
				echo "<hr />";
				//the instructor is in the grading period, so display a table for each class they're assigned to
				$classes_query = array('post_type' => 'gradschoolzeroclass');
				$q = new WP_Query($classes_query);
				if($q->have_posts()){
					while($q->have_posts()){
						$q->the_post();
						$pid = get_the_id();
						$link = get_permalink();
						$title = get_the_title();
						$title_id = str_replace(" ", "", strtolower($title));
						$assignment_key = str_replace(" ", "", strtolower($title)) . "_assignment";
						$as = get_user_meta($currentId, $assignment_key, true);
						if($as == 'a'){
							//instructor is assigned to this class
							echo "<h5>$title</h5>";
							echo "<div class='table-responsive'>";
								echo "<table class='table'>";
									echo '<thead>';
										echo '<tr>';
											echo '<th scope="col">Student name</th>';
											echo '<th scope="col">Final grade</th>';
											echo '<th scope="col">Assign final grade</th>';
										echo '</tr>';
									echo '</thead>';
									echo '<tbody>';
										//get all students enrolled in this class and display a dropdown to assign a grade.
										$blogusers = get_users(array('role__in' => array('student')));
										foreach ($blogusers as $user) {
											$uid = absint($user->ID);
											$fname = $user->first_name;	
											$lname = $user->last_name;	

											$enrollment_key = str_replace(" ", "", strtolower($title)) . "_enrollment";
											$grade_key = str_replace(" ", "", strtolower($title)) . "_grade";
											//get the enrollment status and grade assigned for this user
											$en = get_user_meta($uid, $enrollment_key, true);
											$gr = get_user_meta($uid, $grade_key, true);
											
											//check if this user is enrolled to this class
											if($en == 'e'){
												//student is enrolled in this class
												echo '<tr>';
													echo "<td>$fname $lname</td>";
												//only display this dropdown if instructor is in grading period
												if($phase == 'gp'){

													echo '<td>';
														echo "<select id='$uid-$title_id-grade' class='form-select'>";
															echo '<option value="na" '; 
															selected($gr, 'na');
															echo '>N/A</option>';

															echo '<option value="ap" ';
															selected($gr, 'ap'); 
															echo '>A+</option>';

															echo '<option value="a" '; 
															selected($gr, 'a');
															echo '>A</option>';

															echo '<option value="am" '; 
															selected($gr, 'am');
															echo '>A-</option>';

															echo '<option value="bp" ';
															selected($gr, 'bp'); 
															echo '>B+</option>';

															echo '<option value="b" '; 
															selected($gr, 'b');
															echo '>B</option>';

															echo '<option value="bm" '; 
															selected($gr, 'bm');
															echo '>B-</option>';

															echo '<option value="cp" ';
															selected($gr, 'cp'); 
															echo '>C+</option>';

															echo '<option value="c" '; 
															selected($gr, 'c');
															echo '>C</option>';

															echo '<option value="cm" '; 
															selected($gr, 'cm');
															echo '>C-</option>';

															echo '<option value="d" ';
															selected($gr, 'd'); 
															echo '>D</option>';

															echo '<option value="f" '; 
															selected($gr, 'f');
															echo '>F</option>';

															echo '<option value="cr" '; 
															selected($gr, 'cr');
															echo '>CR</option>';

															echo '<option value="ncr" '; 
															selected($gr, 'ncr');
															echo '>NCR</option>';

															echo '<option value="w" '; 
															selected($gr, 'w');
															echo '>W</option>';
														echo '</select>';
													echo '</td>';
													echo "<td><button id='$uid-$title_id' class='assign-grade btn btn-primary'>Assign</button></td>";
												}else{
													echo "<td colspan='2'>You can only assign grades in the grading period</td>";
												}	
												echo '</tr>';
											}
										}
									echo '</tbody>';
								echo "</table>";
							echo "</div>";
						}
					}
				}
			
			//If the instructor is in the <csp> phase, then display everyclass that this instructor is assigned to
			//and that a student is waitlisted for. Then display all students that are waitlisted for that class along
			//with a dropdown selector with two options, <admit> or <waitlisted>. And display a submit button next to it.
			
			
			if($phase == 'crp' || $phase == 'scrp'){
				echo "<h2>My waitlisted students</h2>";
				echo "<hr />";
				$classes_query = array('post_type' => 'gradschoolzeroclass');
				$q = new WP_Query($classes_query);
				if($q->have_posts()){
					while($q->have_posts()){
						$q->the_post();
						$pid = get_the_id();
						$link = get_permalink();
						$title = get_the_title();
						$title_id = str_replace(" ", "", strtolower($title));
						$assignment_key = str_replace(" ", "", strtolower($title)) . "_assignment";
						$as = get_user_meta($currentId, $assignment_key, true);
						if($as == 'a'){
							//instructor is assigned to this class
							echo "<h5>$title</h5>";
							echo "<div class='table-responsive'>";
								echo "<table class='table'>";
									echo '<thead>';
										echo '<tr>';
											echo '<th scope="col">Student name</th>';
											echo '<th scope="col">Waitlist status</th>';
											echo '<th scope="col">Change waitlist status</th>';
										echo '</tr>';
									echo '</thead>';
									echo '<tbody>';
										//get all students enrolled in this class and display a dropdown to assign a grade.
										$blogusers = get_users(array('role__in' => array('student')));
										foreach ($blogusers as $user) {
											$uid = absint($user->ID);
											$name = $user->display_name;
											$enrollment_key = str_replace(" ", "", strtolower($title)) . "_enrollment";
											//get the enrollment status for this user
											$en = get_user_meta($uid, $enrollment_key, true);
											
											//check if this user is waitlisted for this class
											if($en == 'wl'){
												echo '<tr>';
													echo "<td>$name</td>";
													echo '<td>';
														echo "<select id='$uid-$title_id-enrollment' class='form-select'>";
															echo '<option value="wl" ';
															selected($en, 'wl');
															echo '>Remain waitlisted</option>';

															echo '<option value="e" ';
															selected($en, 'e');
															echo '>Enroll</option>';

														echo '</select>';
													echo '</td>';
													echo "<td><button id='$uid-$title_id' class='change-waitlist btn btn-primary'>Change waitlist</button></td>";
												echo '</tr>';
											}
										}
									echo '</tbody>';
								echo "</table>";
							echo "</div>";
						}
					}
				}
			}
			?>
        </div>
    </div>
	
	<div id="my-schedule" class="tabcontent">
        <div class="container">
            <h2 class="">Schedule</h2>
            <hr />
            <?php
			echo '<div class="table-responsive">';
				echo '<table class="table">';
					echo '<thead>';
						echo '<tr>';
							echo '<th scope="col">ID</th>';
							echo '<th scope="col">Class</th>';
							echo '<th scope="col">Schedule</th>';
						echo '</tr>';
					echo '</thead>';

					echo '<tbody>';
						$classes_query = array('post_type' => 'gradschoolzeroclass');
						$q = new WP_Query($classes_query);
						if($q->have_posts()){
							while($q->have_posts()){
								$q->the_post();
								$pid = get_the_id();
								$link = get_permalink();
								$title = get_the_title();
								$assignment_key = str_replace(" ", "", strtolower(get_the_title())) . "_assignment";
								$as = get_user_meta($currentId, $assignment_key, true);
								if($as == 'a'){
									//instructor is assigned to this class
									//get the days of the week for this class
									$days = "";
									$days .= get_post_meta($pid, 'm', true) == 'yes' ? 'Mo' : '';
									$days .= get_post_meta($pid, 't', true) == 'yes' ? 'Tu' : '';
									$days .= get_post_meta($pid, 'w', true) == 'yes' ? 'We' : '';
									$days .= get_post_meta($pid, 'h', true) == 'yes' ? 'Th' : '';
									$days .= get_post_meta($pid, 'f', true) == 'yes' ? 'Fr' : '';
									$days .= get_post_meta($pid, 's', true) == 'yes' ? 'Sa' : '';

									$st = get_post_meta($pid, 'startTime', true);
									$et = get_post_meta($pid, 'endTime', true);

									$loc = get_post_meta($pid, 'loc', true) == 'v' ? 'Virtual' : 'In person';

									echo '<tr>';
										echo "<th>$pid</th>";
										echo "<td><a href='$link'>$title</td>";
										echo "<td>$days<br>$st-$et<br>$loc</td>";
									echo '</tr>';
								}
							}
						}
					echo '</tbody>';
				echo '</table>';
			echo '</div>';
            ?>
        </div>
    </div>
	
	<div id="my-msg" class="tabcontent">
        <div class="container">
            <h1 class="">New message</h1>
            <hr />
			<form id='add-msg-form'>
                <div class="form-row">
			        <div class="form-group col-md-12">
                        <label for="msg-title">Title</label>
                        <input id='msg-title' type='text' placeholder='Message title' class='form-control' aria-label='small' data-toggle='tooltip' title='Enter a title'>
                    </div>
				</div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="msg-type">Message type</label>
                        <select class="form-select selector" id="msg-type">
                            <option value="comp">Complaint</option>
                            <option value="grad">Graduation application</option>
                            <option value="just">Justification</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <?php
                        $msg_content = 'Enter description here.';
                        $msg_editor_id = 'msg-desc';
                        $settings = array(
                            'textarea_rows' => 20,
                            'editor_height' => 225,
                            'media_buttons' => false,
                            'quicktags' => array('buttons' => 'strong,em,del,ul,ol,li,close'),
                            'teeny' => true
                        );
                        wp_editor($msg_content, $msg_editor_id, $settings);

                        ?>
                    </div>
                </div>
                <button type='submit' class='w-50 btn btn-primary main-btn'>Send message</button>
            </form>
			
            <hr />
            <h1 class="">Messages</h1>
            <?php
			echo '<div class="table-responsive">';
			echo '<table class="table">';
				echo '<thead>';
				echo '<tr>';
					echo '<th scope="col">Type</th>';
					echo '<th scope="col">Message</th>';
					echo '<th scope="col">Excerpt</th>';
				echo '</tr>';
				echo '</thead>';
				
				echo '<tbody>';
				$classes_query = array('post_type' => 'gradschoolzeromsg');
				$q = new WP_Query($classes_query);
				if($q->have_posts()){
					while($q->have_posts()){
						$q->the_post();
						$pid = get_the_id();
						$link = get_permalink();
						$rec_key = strval($currentId).'_recipient';
						$rec = get_post_meta($pid ,$rec_key, true);
						if($rec == 'yes'){
							$terms = wp_get_object_terms($pid, 'messagetypes');
							$type = "";
							foreach($terms as $i){
								$type .= $i->name.', ';
							}
							$type = substr($type, 0, -2);
							
							echo '<tr>';
								echo '<td>'.$type.'</td>';
								echo '<td><a href="'.$link.'">'.get_the_title().'</td>';
								echo '<td>'.get_the_excerpt().'</td>';
							echo '</tr>';
						}
					}
				}else{
					echo '<tr>';
						echo '<th>You have no messages.</th>';
					echo '</tr>';
				}
				echo '</tbody>';
			echo '</table>';
			echo '</div>';
            ?>			
        </div>
    </div>

    <div id="update" class="tabcontent">
        <div class="container">
            <h1 class="">Profile Information</h1>
            <hr />

<?php
$current_user = wp_get_current_user();
$name = $current_user->user_firstname." ".$current_user->user_lastname;
$role = 'instructor';
$email = $current_user->user_email;
$login = $current_user->user_login;


echo '<div class="table-responsive">';
echo '<table class="table">';
	echo '<thead>';
		echo '<tr>';
			echo '<th scope="col">Field</th>';
			echo '<th scope="col">Value</th>';
		echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
		echo '<tr>';
			echo '<td>Name</td>';
			echo "<td><a href='' data-bs-toggle='modal' data-bs-target='#resetName'> $name <span class='dashicons dashicons-edit'></span></a></td>";
		echo '</tr>';
		echo '<tr>';
			echo '<td>Role</td>';
			echo "<td>$role </td>";
		echo '</tr>';
		echo '<tr>';
			echo '<td>Email</td>';
			echo "<td><a href='' data-bs-toggle='modal' data-bs-target='#resetEmail'> $email <span class='dashicons dashicons-edit'></span></a></td>";
		echo '</tr>';
		echo '<tr>';
			echo '<td>Username</td>';
			echo "<td>$login </td>";
		echo '</tr>';
		echo '<tr>';
			echo '<td>Password</td>';
			echo "<td><a href='' data-bs-toggle='modal' data-bs-target='#resetPass'> ******** <span class='dashicons dashicons-edit'></span></a></td>";
		echo '</tr>';
		echo '<tr>';
			echo '<td>Delete account</td>';
			echo '<td><a href="" data-bs-toggle="modal" data-bs-target="#deleteAcc"><button class="btn btn-danger">DELETE ACCOUNT</button></a></td>';
		echo '</tr>';
	echo '</tbody>';
echo '</table>';
echo '</div>';
?>
    <!-- DELETE ACCOUNT -->
    <div class="modal fade" id="deleteAcc" tabindex="-1" aria-labelledby="deleteAccLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccLabel">Are you sure you want to delete this account?</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="delete-acc">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button id="submit-delete-acc" type="submit" class="w-100 btn btn-warning main-btn">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- RESET NAME -->
    <div class="modal fade" id="resetName" tabindex="-1" aria-labelledby="resetNameLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetNameLabel">New name</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="update-name">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="reset-fName">First name</label>
                                <input id="reset-fName" type="text" class="form-control" placeholder="Update first name" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reset-lName">Last name</label>
                                <input id="reset-lName" type="text" class="form-control" placeholder="Update last name" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button id="submit-reset-name" type="submit" class="btn btn-warning main-btn">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- RESET EMAIL -->
    <div class="modal fade" id="resetEmail" tabindex="-1" aria-labelledby="resetEmailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetEmailLabel">New email</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="update-email">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="reset-email">Email</label>
                                <input id="reset-email" type="text" class="form-control" placeholder="New email" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reset-email2">Re-Type Email</label>
                                <input id="reset-email2" type="text" class="form-control" placeholder="Re-Type" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button id="submit-reset-email" type="submit" class="btn btn-warning main-btn">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- RESET PASSWORD -->
    <div class="modal fade" id="resetPass" tabindex="-1" aria-labelledby="resetPassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPassLabel">New password</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="update-pw">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="reset-pw">Password</label>
                                <input id="reset-pw" type="password" class="form-control" placeholder="New password" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reset-pw2">Re-type password</label>
                                <input id="reset-pw2" type="password" class="form-control" placeholder="Re-Type" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-warning main-btn">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
