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
