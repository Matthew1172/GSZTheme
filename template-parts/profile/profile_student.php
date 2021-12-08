<?php

/**
 * 
 * Profile page for the student of gradschoolzero.
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
            <button onclick="openPage('academic-info')" class="tablink dash-academic-info-btn btn-outline-secondary profile-btn" id="defaultOpen">My academic information</button>
            <button onclick="openPage('my-schedule')" class="tablink dash-my-schedule-btn btn-outline-secondary profile-btn">My Schedule</button>
            <button onclick="openPage('my-msg')" class="tablink dash-my-msg-btn btn-outline-secondary profile-btn">My Messages</button>
            <button onclick="openPage('update')" class="tablink dash-update-btn btn-outline-secondary profile-btn">Update my account</button>
        </div>
    </div>
    <div id='dashDrp' class="dashRow" style="display: none;">
        <select class="form-select" id="drop-selector">
            <option selected="selected" value="academic-info">My academic information</option>
            <option value="my-schedule">My Schedule</option>
            <option value="my-msg">My Messages</option>
            <option value="update">Update my account</option>
        </select>
    </div>
</div>
<div class="control-area">
    <div id="academic-info" class="tabcontent">
        <div class="container">
            <h2 class="">Academic information</h2>
            <hr />
            <?php
			$warn = get_user_meta($currentId, 'warn', true);
			$status = get_user_meta($currentId, 'status', true);
			switch($status){
				case 'mat':
				$status = 'Matriculated';
				break;
				case 'sus':
				$status = 'Suspended';
				break;
				case 'exp':
				$status = 'Expelled';
				break;
				case 'alu':
				$status = 'Alumni';
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
					
			$gp = 0.0;
			$numOfFactors = 0.0;
			echo '<h5>Transcript</h5>';
			echo "<div class='table-responsive'>";
				echo '<table class="table">';
					echo '<thead>';
						echo '<tr>';
							echo '<th scope="col">Class</th>';
							echo '<th scope="col">Grade</th>';
							echo '<th scope="col">Attempt</th>';
						echo '</tr>';
					echo '</thead>';
				
					echo '<tbody>';
					$classes_query = array('post_type' => 'gradschoolzeroclass');
					$q = new WP_Query($classes_query);
					if($q->have_posts()){
						while($q->have_posts()){
							$q->the_post();
							$transcript_key = str_replace(" ", "", strtolower(get_the_title())) . "_transcript";
							$fgrade_key = str_replace(" ", "", strtolower(get_the_title())) . "_fgrade";
							for($i = 1; $i < 5; $i++){
								if(get_user_meta($currentId, $transcript_key."_".strval($i), true) == "taken"){
									$gf = get_user_meta($currentId, $fgrade_key."_".strval($i), true);
									$remove_key = str_replace(" ", "", strtolower(get_the_title())) . "_remove_".strval($i);

									//sum the grade points here are the factors
									//also set the GradeFinalPretty value here or else it will disply grades as "ap, am, a, cm, bm, ..."
									switch($gf){
										case 'na':
											$gf_p = 'N/A';
											break;
										case 'w':
											$gf_p = 'W';
											break;
										case 'ncr':
											$gf_p = 'NCR';
											break;
										case 'cr':
											$gf_p = 'CR';
											break;
										case 'f':
											$gp += 0.0;
											$numOfFactors += 1.0;
											$gf_p = 'F';
											break;
										case 'd':
											$gp += 1.0;
											$numOfFactors += 1.0;
											$gf_p = 'D';
											break;
										case 'cm':
											$gp += 1.7;
											$numOfFactors += 1.0;
											$gf_p = 'C-';
											break;
										case 'c':
											$gp += 2.0;
											$numOfFactors += 1.0;
											$gf_p = 'C';
											break;
										case 'cp':
											$gp += 2.3;
											$numOfFactors += 1.0;
											$gf_p = 'C+';
											break;
										case 'bm':
											$gp += 2.7;
											$numOfFactors += 1.0;
											$gf_p = 'B-';
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
									
									echo '<tr>';
										echo '<td>'.get_the_title().'</td>';
										echo '<td>'.$gf_p.'</td>';
										echo '<td>'.$i.'</td>';
									echo '</tr>';
								}
							}
						}
					}
					echo '</tbody>';
				echo '</table>';
			echo "</div>";
			//Print the gpa, and honor roll status
			if($numOfFactors > 0){
				$gpa = $gp/$numOfFactors;
				echo '<h5>GPA: '.sprintf("%.3f", $gpa).'</h5>';
				//display if student is on honor roll
				if($gpa > 3.5){
					echo '<h5>HONOR ROLL</h5>';
				}
			}else{
				echo '<h5>You have no classes on your transcript that affect your gpa, or you have no classes on your transcript.</h5>';
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
								$enrollment_key = str_replace(" ", "", strtolower(get_the_title())) . "_enrollment";
								$en = get_user_meta($currentId, $enrollment_key, true);
								if($en == 'e'){
									//student is enrolled in this class
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
$role = 'student';
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
