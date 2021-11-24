<?php
/**
 * 
 * add to the $_GET variables available on the site
 * 
 */
function add_classSearch_query_vars_filter($vars)
{
	$vars[] = "ct";
	return $vars;
}
add_filter('query_vars', 'add_classSearch_query_vars_filter');

/* This function will be called when the form on the search page is submitted.
It takes the result inside of the input of the form called <ct> 
and the number of pages given from the result of the query. It then builds a url with these
query vars and redirects the user to it.
 */
function classSearchForm_save()
{
	// Get the link to the class search page
	$sfc_page_id = get_page_by_title('search for classes', OBJECT, 'page');
	$url = get_permalink($sfc_page_id);
	//Get the <paged> query var, and append it to the url
	$url .= isset($_GET['paged']) ? '?paged=' . $_GET['paged'] : null;
	//Get the <ct> query var and append it to the url
	$url .= isset($_GET['ct']) ? '?ct=' . $_GET['ct'] : null;
	//after the form is submitted and the url is constructed, redirect them to it
	wp_redirect($url);
}
//this hook is fired when the <classSearchForm> form is submitted
add_action('admin_post_classSearchForm', 'classSearchForm_save');
//Two hooks because the one above is fired when a user who is logged in, and the one below for a random visitor
add_action('admin_post_nopriv_classSearchForm', 'classSearchForm_save');

