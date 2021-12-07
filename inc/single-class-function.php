<?php
/**
 * Functions and definitions for a single class post in the GSZ theme by Team M
 *
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
 
 /*
Function for a student to enroll into a class
  */
add_action('wp_ajax_call_enroll_class', 'enroll_class');
function enroll_class()
{
	$response = array(
		'r' => ''
	);
	if (is_user_logged_in()) {
		$titleDashUidDashEnroll = $_POST['titleDashUidDashEnroll'];
		$title = explode('-', $titleDashUidDashEnroll)[0];
		$new_title = str_replace(' ', '', $title);
		$uid = explode('-', $titleDashUidDashEnroll)[1];
		$enrollment_key = strtolower($new_title) . "_enrollment";
		
		//check if class is full
		//check if prereqs are satisfied
		//check if no time conflicts
		//check if student has already more than 3 classes, deny the request to enroll and send back too many error code
		$enroll=0;
		$qry = array(
		    'post_type' => 'gradschoolzeroclass'
		);
		$classes = new WP_Query($qry);
		if ($classes->have_posts()) {
		    while ($classes->have_posts()) {
			$classes->the_post();
			$e_pid = get_the_id();
			$e_title = get_the_title();
			$e_enrollment_key = str_replace(" ", "", strtolower($e_title)) . "_enrollment";
			$e = get_user_meta($uid, $e_enrollment_key, true);
			if($e == 'e'){
			    $enroll++;
			}
		    }
		}
		if($enroll > 3){
		    $response['r'] = 'tooMany';
		    wp_send_json($response);
		}


		//check if this student has this class on their transcript. If they have a passing grade for this class then they can't enroll.
		//check if student has this class on their transcript
		$taken = false;
		$can_enroll = false;
		$transcript_key = str_replace(" ", "", strtolower($new_title)) . "_transcript";
		for ($i = 1; $i < 5; $i++) {
		        if (get_user_meta($uid, $transcript_key . "_" . strval($i), true) == "taken") {
                                //this student has taken this class on some attempt 1->5
                                $taken = true;
                                //get the final grade for the attempt
				$fgrade_key = str_replace(" ", "", strtolower($new_title)) . "_fgrade_".strval($i);
                                $gf = get_user_meta($uid, $fgrade_key, true);
                                switch($gf){
                                case 'f':
                                        $can_enroll = true;
                                        break;
                                default:
                                        $can_enroll = false;
                                        break;
				}
                        }
		}
		if(!$taken){
			$can_enroll = true;
		}

		if(!$can_enroll){
		    $response['r'] = 'suffGrade';
		    wp_send_json($response);
		}
		
		$r = update_user_meta($uid, $enrollment_key, 'e');
		if($r){
			$response['r'] = 'success';
		}else{
			$response['r'] = 'failed';
		}
	} else {
		$response['r'] = 'failed';
	}
	wp_send_json($response);
}

/*
Function for a student to drop a class
*/
add_action('wp_ajax_call_drop_class', 'drop_class');
function drop_class()
{
	$response = array(
		'r' => '',
		'c' => ''
	);
	if (is_user_logged_in()) {
		$titleDashUidDashWithdraw = $_POST['titleDashUidDashWithdraw'];
		$title = explode('-', $titleDashUidDashWithdraw)[0];
		$new_title = str_replace(' ', '', $title);
		$uid = explode('-', $titleDashUidDashWithdraw)[1];
		$enrollment_key = strtolower($new_title) . "_enrollment";
		$phase = get_user_meta($uid, 'phase', true);
		$k = $phase == 'crup' ? true : false;
		$j = $phase == 'gp' ? true : false;
		
		//change the enrollment meta to not enrolled, check the students phase meta to see if they're in
		//the course running period, or grading period; and if they are check they're transcript and add this attempt with a grade of W.
		
		//check after we drop the class if they're not enrolled in any class and they're in the course running period or grading period, if they are then issue a warning.
		
		$r = update_user_meta($uid, $enrollment_key, 'ne');
		if(!$r){
			$response['r'] = 'failed';
			wp_send_json($response);
		}

		//check students enrollment in all classes
		$last_class = true;
		$qry = array(
			'post_type' => 'gradschoolzeroclass'
		);
		$classes = new WP_Query($qry);
		if ($classes->have_posts()) {
			while ($classes->have_posts()) {
				$classes->the_post();
				$last_pid = get_the_id();
				$last_title = get_the_title();
				$last_enrollment_key = strtolower($last_title) . "_enrollment";
				$en = get_user_meta($uid, $last_enrollment_key, true);
				if($en == 'e'){
					//student is enrolled in this class, so make last class flag false
					$last_class = false;
				}
			}
		}
		
		if($last_class && ($k || $j)){
			//the student is dropping their last class in the course running period or the grading period. issue a warning.
			$warn = absint(get_user_meta($uid, 'warn', true));
			if($warn > 4){
				//this user already has 5 warnings so don't do anything
			}else{
				$warn++;
				$r = update_user_meta($uid, 'warn', $warn);
				if(!$r){
					$response['r'] = 'failed';
					$response['c'] = $warn;
					wp_send_json($response);
				}
			}
		}
		
		
		if($k || $j){
			//they need a W on their transcript
			$attempt = 1;
			$transcript_key = str_replace(" ", "", strtolower($title)) . "_transcript";
			$fgrade_key = str_replace(" ", "", strtolower($title)) . "_fgrade";
				
			for ($i = 1; $i < 5; $i++) {
				if (get_user_meta($uid, $transcript_key . "_" . strval($i), true) == "taken") {
					//this student has taken this class on some attempt 1->4
					$attempt++;
				}
			}
			
			if($attempt > 4){
				//this is the students 5th attempt. don't add it
			}else{
				$r = update_user_meta($uid, $transcript_key . "_" . strval($attempt), 'taken');
				if(!$r){
					$response['r'] = 'failed';
					wp_send_json($response);
				}
				$r = update_user_meta($uid, $fgrade_key . "_" . strval($attempt), 'w');
				if(!$r){
					$response['r'] = 'failed';
					wp_send_json($response);
				}
			}
		}
		//if we got this far then everything was successful
		$response['r'] = 'success';
	} else {
		$response['r'] = 'failed';
	}
	wp_send_json($response);
}

 /*
Function for a student to waitlist a class
*/
add_action('wp_ajax_call_waitlist_class', 'waitlist_class');
function waitlist_class()
{
	$response = array(
		'r' => ''
	);
	if (is_user_logged_in()) {
		$titleDashUidDashWaitlist = $_POST['titleDashUidDashWaitlist'];
		$title = explode('-', $titleDashUidDashWaitlist)[0];
		$new_title = str_replace(' ', '', $title);
		$uid = explode('-', $titleDashUidDashWaitlist)[1];
		$enrollment_key = strtolower($new_title) . "_enrollment";
		$r = update_user_meta($uid, $enrollment_key, 'wl'); 
		if($r){
			$response['r'] = 'success';
		}else{
			$response['r'] = 'failed';
		}
	} else {
		$response['r'] = 'failed';
	}
	wp_send_json($response);
}

/**
 * Check the two time periods overlap
 *
 * Example:
 * $periods = [
 *      ['start_time' => "09:00", 'end_time' => '10:30'],
 *      ['start_time' => "14:30", "end_time" => "16:30"],
 *      ['start_time' => "11:30", "end_time" => "13:00"],
 *      ['start_time' => "10:30", "end_time" => "11:30"],
 * ]
 *
 * @param $periods
 * @param string $start_time_key
 * @param string $end_time_key
 * @return bool
 */
function isOverlapped($periods, $start_time_key = 'start_time', $end_time_key = 'end_time')
{
    // order periods by start_time
    usort($periods, function ($a, $b) use ($start_time_key, $end_time_key) {
        return strtotime($a[$start_time_key]) <=> strtotime($b[$end_time_key]);
    });
    // check two periods overlap
    foreach ($periods as $key => $period) {
        if ($key != 0) {
            if (strtotime($period[$start_time_key]) < strtotime($periods[$key - 1][$end_time_key])) {
                return true;
            }
        }
    }
    return false;
}

function datesOverlap($start_one,$end_one,$start_two,$end_two) {
   if($start_one <= $end_two && $end_one >= $start_two) { //If the dates overlap
        return true;
   }
   return false;
}

// Add custom meta (ratings) fields to the default comment form
// Default comment form includes name, email address and website URL
// Default comment form elements are hidden when user is logged in

// Add fields after default fields above the comment box, always visible

add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );

function additional_fields () {
  echo '<p class="comment-form-rating">'.
  '<label for="rating">'. __('Rating') . '<span class="required">*</span></label>
  <span class="commentratingbox">';

    //Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
    for( $i=1; $i <= 5; $i++ ){
    	echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"/>'. $i .'</span>';
    }

  echo'</span></p>';
}
// Save the comment meta data along with comment

add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
	if (isset($_POST['rating'])){
		$rating = wp_filter_nohtml_kses($_POST['rating']);
		add_comment_meta( $comment_id, 'rating', $rating );
	}
}
// Add the filter to check whether the comment meta data has been filled

add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
	$p = isset($_POST['rating']);
	$q = current_user_can('administrator');
	$k = is_admin();
	if (!$p && !($q && $k)){
		wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
	}
	return $commentdata;
}
// Add the comment meta (saved earlier) to the comment text
// You can also output the comment meta values directly to the comments template  

add_filter( 'comment_text', 'modify_comment');
function modify_comment( $text ){
	if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		//$commentrating = '<p class="comment-rating"><br/>Rating: <strong>'. review(absint($commentrating)) .'</strong></p>';
		$rating = review(absint($commentrating));
		$text = $text . $rating;
		return $text;
	} else {
		return $text;
	}
}
// Add an edit option to comment editing screen

function extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
		<label for="rating"><?php _e( 'Rating: ' ); ?></label>
		<span class="commentratingbox">
		<?php 
		for( $i=1; $i <= 5; $i++ ) {
			echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
			if ( $rating == $i ){
				echo ' checked="checked"';
			}
			echo ' />'. $i .' </span>';
		}
		?>
		</span>
    </p>
    <?php
}

// Update comment meta data from comment editing screen 
add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ){
		return;
	}

	if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != ’) ){
		$rating = wp_filter_nohtml_kses($_POST['rating']);
		update_comment_meta( $comment_id, 'rating', $rating );
	}else{
		delete_comment_meta( $comment_id, 'rating');
	}
}

function review($rating) {
    switch ($rating) {
        case '0':
            $alt = 'Zero';
            break;
        case '1':
            $alt = 'Very Bad';
            break;
        case '2':
            $alt = 'Bad';
            break;
        case '3':
            $alt = 'Good';
            break;
        case '4':
            $alt = 'Very Good';
            break;
        case '5':
            $alt = 'Excellent';
            break;
        default:
            $alt = 'No Rating';
            break;
    }
 
	$html = "";
    if(isset($rating) && $rating != ''){
        for ($i = 0; $i < 5; $i++) {
            if ($rating > $i)
                $html .= '<img src="'.get_stylesheet_directory_uri().'/images/star_on.png" alt="'.$alt.'" title="'.$alt.'" />';
            else
                $html .= '<img src="'.get_stylesheet_directory_uri().'/images/star_off.png" alt="'.$alt.'" title="'.$alt.'" />';
        }
	} else {
		$html .= $alt;
    }
	return $html;
}

