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

}
add_action('wp_ajax_nopriv_call_signup', 'signup_insert');