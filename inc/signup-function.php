<?php
/**
 * add to the $_GET variables on the site
 */
function add_signup_query_vars_filter($vars)
{
	$vars[] = "login";
	return $vars;
}
add_filter('query_vars', 'add_signup_query_vars_filter');

/*
 *
 * Function to sign up users
 *
 */
function signup_insert()
{
	global $wpdb;
	$error = array(
		'code' => '',
		'url' => ''
	);
	$wp_userdata = array(
		'ID' => '', //(int) User ID. If supplied, the user will be updated.
		'user_pass' => $_POST['pw'], //(string) The plain-text user password.
		'user_login' => $_POST['uid'], //(string) The user's login username.
		'user_nicename' => $_POST['first'], //(string) The URL-friendly user name.
		'user_url' => $_POST['url'], //(string) The user URL.
		'user_email' => $_POST['email'], //(string) The user email address.
		'display_name' => $_POST['uid'], //(string) The user's display name. Default is the user's username.
		'nickname' => $_POST['uid'], //(string) The user's nickname. Default is the user's username.
		'first_name' => $_POST['first'], //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
		'last_name' => $_POST['last'], //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
		'description' => '', //(string) The user's biographical description.
		'rich_editing' => '', //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
		'syntax_highlighting' => '', //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
		'comment_shortcuts' => '', //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
		'admin_color' => '', //(string) Admin color scheme for the user. Default 'fresh'.
		'use_ssl' => '', //(bool) Whether the user should always access the admin over https. Default false.
		'user_registered' => date('Y-m-d H:i:s'), //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
		'show_admin_bar_front' => 'false', //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
		'role' => $_POST['type'], //(string) User's role.
		'locale' => '', //(string) User's locale. Default empty.
	);

	$userInDB = checkUsernameDB($wp_userdata['user_login']);
	$emailInDB = checkEmailDB($wp_userdata['user_email']);
	if (
		empty($wp_userdata['first_name']) ||
		empty($wp_userdata['last_name']) ||
		empty($wp_userdata['user_email']) ||
		empty($wp_userdata['user_login']) ||
		empty($wp_userdata['user_pass']) ||
		empty($_POST['pw2'])
	) {
		$error['code'] = 'emptyField';
	} else if (!(valid_name($wp_userdata['first_name']) && valid_name($wp_userdata['last_name']))) {
		$error['code'] = 'name';
	} else if (!valid_email($wp_userdata['user_email'])) {
		$error['code'] = 'email';
	} else if (!valid_uid($wp_userdata['user_login'])) {
		$error['code'] = 'uid';
	} else if ($userInDB) {
		$error['code'] = 'userTaken';
	} else if ($emailInDB) {
		$error['code'] = 'emailTaken';
	} else if (!valid_pw($wp_userdata['user_pass'])) {
		$error['code'] = 'pwValid';
	} else if ($wp_userdata['user_pass'] != $_POST['pw2']) {
		$error['code'] = 'pwMatch';
	} else {
		switch ($_POST['type']) {
		case 'student':
			if (empty($_POST['e_gpa']) || !valid_student_gpa($_POST['e_gpa'])) {
				$error['code'] = 'eGPA';
			} else {
				$new_stud_id = wp_insert_user($wp_userdata);
				if ($new_stud_id) {
					$egpa = floatval($_POST['e_gpa']);
					//add entrance gpa
					//add 0 warnings
					//add status matriculated
					//add course setup period
					update_user_meta($new_stud_id, 'egpa', $egpa);
					update_user_meta($new_stud_id, 'warn', 0);
					update_user_meta($new_stud_id, 'status', 'mat');
					update_user_meta($new_stud_id, 'phase', 'csp');

					$error['code'] = 'success';
				} else {
					$error['code'] = 'error';
				}
			}
			break;
		case 'instructor':
			$new_inst_id = wp_insert_user($wp_userdata);
			//add 0 warnings
			//add status matriculated
			//add course setup period
			update_user_meta($new_inst_id, 'warn', 0);
			update_user_meta($new_inst_id, 'status', 'emp');
			update_user_meta($new_inst_id, 'phase', 'csp');
			if ($new_inst_id) {
				$error['code'] = 'success';
			} else {
				$error['code'] = 'error';
			}
			break;
		}
	}
	//$error['url'] = get_permalink(get_page_by_path('sign-in')->ID);
	$error['url'] = home_url('/');
	wp_send_json($error);
}
add_action('wp_ajax_nopriv_call_signup', 'signup_insert');
