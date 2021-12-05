<?php
/* 
Function add an msg
*/
function add_msg()
{
	global $wpdb;
	$response = array(
		'r' => ''
	);
	
	$messagetypes = array();
	$type = $_POST['type'];

	switch($type){
		case 'comp':
			$category = get_term_by('name', 'Complaint', 'messagetypes');
			break;
		case 'grad':
			$category = get_term_by('name', 'Graduation application', 'messagetypes');
			break;
		case 'just':
			$category = get_term_by('name', 'Justification', 'messagetypes');
			break;
	}

	$desc = $_POST['desc'];

	$wp_msg = array(
		'post_type' => 'gradschoolzeromsg',
		'post_title' => $_POST['title'],
		'post_content' => $desc,
		'post_status' => 'pending',
		'ping_status' => 'closed',
		'post_author' => get_current_user_id()
	);


	if (strlen($_POST['title']) < 1 || strlen($_POST['desc']) < 1) {
		$response['r'] = 'empty';
	} else if (strlen($_POST['title']) <= 4) {
		$response['r'] = 'notValid';
	} else if (strlen($_POST['desc']) < 80) {
		$response['r'] = 'desc';
	} else {
		$post_id = wp_insert_post($wp_msg);
		if ($post_id) {
			$response['r'] = 'success';
			$taxonomy = 'messagetypes';
			wp_set_object_terms( $post_id, intval( $category->term_id ), $taxonomy );
		}else{
			$response['r'] = 'error';
		}
	}
	wp_send_json($response);
}
add_action('wp_ajax_call_add_msg', 'add_msg');

/*
Function for an instructor to admit a waitlisted student into a class
*/
add_action('wp_ajax_call_change_waitlist', 'change_waitlist');
function change_waitlist()
{
	$response = array(
		'r' => ''
	);
	if (is_user_logged_in()) {
		$uidDashTitle = $_POST['uidDashTitle'];
		$enrollment = $_POST['enrollment'];
		$uid = explode('-', $uidDashTitle)[0];
		$title_dirty = explode('-', $uidDashTitle)[1];
		$title = strtolower(str_replace(' ', '', $title_dirty));
		$enrollment_key = $title . "_enrollment";
		$r = update_user_meta($uid, $enrollment_key, $enrollment); 
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
Function for an instructor to save a grade for a student in a given class
NOTE: if the instructor is updating a grade for a student and it's the same as the current grade in the database, it will "fail"
*/
add_action('wp_ajax_call_assign_grade', 'assign_grade');
function assign_grade()
{
	$response = array(
		'r' => ''
	);
	if (is_user_logged_in()) {
		$uidDashTitle = $_POST['uidDashTitle'];
		$grade = $_POST['grade'];
		$uid = explode('-', $uidDashTitle)[0];
		$title_dirty = explode('-', $uidDashTitle)[1];
		$title = strtolower(str_replace(' ', '', $title_dirty));
		$grade_key = $title . "_grade";
		$r = update_user_meta($uid, $grade_key, $grade);
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
 * Function to delete account
 */
add_action('wp_ajax_call_delete_acc', 'delete_acc');
function delete_acc()
{
	$response = array(
		'r' => '',
		'url' => ''
	);
	if (is_user_logged_in() && !empty($_POST['delete'])) {
		require_once(ABSPATH . 'wp-admin/includes/user.php');
		$current_user = wp_get_current_user();
		wp_delete_user($current_user->ID);
		$response['r'] = 'success';
		$response['url'] = home_url() . '/index.php';
	} else {
		$response['r'] = 'failed';
	}
	wp_send_json($response);
}

/*
 *
 * Function to reset user first and last name
 *
 */
function update_name()
{
	$response = array(
		'r' => ''
	);
	$wp_user_data = array(
		'ID' => get_current_user_id(),
		'first_name' => esc_attr($_POST['fName']),
		'last_name' => esc_attr($_POST['lName'])
	);
	if (strlen($_POST['fName']) < 1 || strlen($_POST['lName']) < 1) {
		$response['r'] = 'empty';
	} else if (!valid_name($_POST['fName'])) {
		$response['r'] = 'validF';
	} else if (!valid_name($_POST['lName'])) {
		$response['r'] = 'validL';
	} else {
		$user_data = wp_update_user($wp_user_data);
		if (is_wp_error($user_data)) {
			$response['r'] = 'failed';
		} else {
			$response['r'] = 'success';
		}
	}
	wp_send_json($response);
}
add_action('wp_ajax_call_update_name', 'update_name');

/*
 *
 * Function to reset user email
 *
 */
function update_email()
{
	$response = array(
		'r' => ''
	);
	$wp_user_data = array(
		'ID' => get_current_user_id(),
		'user_email' => esc_attr($_POST['email'])
	);
	if (strlen($_POST['email']) < 1 || strlen($_POST['email2']) < 1) {
		$response['r'] = 'empty';
	} else if (!valid_email($_POST['email'])) {
		$response['r'] = 'valid';
	} else if ($_POST['email'] !== $_POST['email2']) {
		$response['r'] = 'match';
	} else if (checkEmailDB($_POST['email'])) {
		$response['r'] = 'taken';
	} else {
		$user_data = wp_update_user($wp_user_data);
		if (is_wp_error($user_data)) {
			$response['r'] = 'failed';
		} else {
			$response['r'] = 'success';
		}
	}
	wp_send_json($response);
}
add_action('wp_ajax_call_update_email', 'update_email');

/*
 *
 * Function to reset user pw
 *
 */
function update_pw()
{
	$response = array(
		'r' => ''
	);
	$wp_user_data = array(
		'ID' => get_current_user_id(),
		'user_pass' => $_POST['pw']
	);
	if (strlen($_POST['pw']) < 1 || strlen($_POST['pw2']) < 1) {
		$response['r'] = 'empty';
	} else if (!valid_pw($_POST['pw'])) {
		$response['r'] = 'valid';
	} else if ($_POST['pw'] !== $_POST['pw2']) {
		$response['r'] = 'match';
	} else {
		$user_data = wp_update_user($wp_user_data);
		if (is_wp_error($user_data)) {
			$response['r'] = 'failed';
		} else {
			$response['r'] = 'success';
		}
	}
	wp_send_json($response);
}
add_action('wp_ajax_call_update_pw', 'update_pw');
