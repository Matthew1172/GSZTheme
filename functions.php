<?php

/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */



if (!function_exists('gradschoolzero_setup')) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since gradschoolzero 1.0
	 *
	 * @return void
	 */
	function gradschoolzero_setup()
	{
		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support('title-tag');


		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1568, 9999);


		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		//Create the post categories that this theme uses for the about us, contact, and footer
		wp_insert_term(
			'About',
			'category',
			array(
				'description' => 'A description of Grad School Zero.',
				'slug' => 'about'
			)
		);
		wp_insert_term(
			'Announcement',
			'category',
			array(
				'description' => 'This is an announcement made by the Registrar.',
				'slug' => 'announcement'
			)
		);
		$parent_announ = term_exists('Announcement', 'category');
		wp_insert_term(
			'Student tutorial',
			'category',
			array(
				'description' => 'A tutorial by the registrar on how to use the Grad School Zero website as a student.',
				'slug' => 'studentTutorial',
				'parent' => $parent_announ['term_id']
			)
		);
		wp_insert_term(
			'Contact',
			'category',
			array(
				'description' => 'The Grad School Zero contact information',
				'slug' => 'contact'
			)
		);
		$parent_contact = term_exists('Contact', 'category');
		wp_insert_term(
			'Contact page',
			'category',
			array(
				'description' => 'The registrar contact information on the contact page.',
				'slug' => 'contactPage',
				'parent' => $parent_contact['term_id']
			)
		);
		wp_insert_term(
			'Contact footer',
			'category',
			array(
				'description' => 'The contact information in the footer for the registrar.',
				'slug' => 'contactFooter',
				'parent' => $parent_contact['term_id']
			)
		);


		//create all pages for theme
		//home
		//about
		//contact
		//sign in
		//register
		//recover account
		//profile
		//search for classes

		// Set the title, template, etc
		$new_page_title     = __('Home', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'index.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$new_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
			}
		}

		// Set the title, template, etc
		$new_page_title     = __('About', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'about.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$about_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($about_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$about_page_id = get_page_by_title('about', OBJECT, 'page');
		}

		// Set the title, template, etc
		$new_page_title     = __('Contact', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'contact.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$contact_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($contact_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$contact_page_id = get_page_by_title('contact', OBJECT, 'page');
		}

		// Set the title, template, etc
		$new_page_title     = __('Sign in', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'sign-in.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$signin_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($signin_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$signin_page_id = get_page_by_title('sign in', OBJECT, 'page');
		}

		// Set the title, template, etc
		$new_page_title     = __('Register', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'register.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$register_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($register_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$register_page_id = get_page_by_title('register', OBJECT, 'page');
		}

		/*
		$new_page_title     = __('Recover account', 'text-domain');
		$new_page_content   = '';
		$new_page_template  = 'recover.php';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		if (!isset($page_check->ID)) {
			$recoveraccount_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($recoveraccount_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$recoveraccount_page_id = get_page_by_title('recover account', OBJECT, 'page');
		}
		 */
		// Set the title, template, etc
		$new_page_title     = __('Profile', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'profile.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$profile_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($profile_page_id, '_wp_page_template', $new_page_template);
			}
		}else{		
			$profile_page_id = get_page_by_title('profile', OBJECT, 'page');
		}

		// Set the title, template, etc
		$new_page_title     = __('Search for classes', 'text-domain');
		$new_page_content   = '';                           // Content goes here
		$new_page_template  = 'search-gradschoolzeroclasses.php';       // The template to use for the page
		$page_check = get_page_by_title($new_page_title);   // Check if the page already exists
		// Store the above data in an array
		$new_page = array(
			'post_type'     => 'page',
			'post_title'    => $new_page_title,
			'post_content'  => $new_page_content,
			'post_status'   => 'publish',
			'post_author'   => 1
		);
		// If the page doesn't already exist, create it
		if (!isset($page_check->ID)) {
			$sfc_page_id = wp_insert_post($new_page);
			if (!empty($new_page_template)) {
				update_post_meta($sfc_page_id, '_wp_page_template', $new_page_template);
			}
		}else{
			$sfc_page_id = get_page_by_title('search for classes', OBJECT, 'page');
		}

		register_nav_menus(
			array(
				'top-navbar-guest' => __('top-navbar-guest'),
				'top-navbar-user' => __('top-navbar-user'),
				'footer-navbar' => __('footer-navbar')
			)
		);

		//Get the permalinks for all pages
		$about_perma = get_permalink($about_page_id);
		$contact_perma = get_permalink($contact_page_id);
		$signin_perma = get_permalink($signin_page_id);
		$register_perma = get_permalink($register_page_id);
		//$recoveraccount_perma = get_permalink($recoveraccount_page_id);
		$profile_perma = get_permalink($profile_page_id);
		$searchforclasses_perma = get_permalink($sfc_page_id);

		$menuname = 'top-navbar-guest';
		$bpmenulocation = 'top-navbar-guest';
		// Does the menu exist already?
		$menu_exists = wp_get_nav_menu_object($menuname);

		// If it doesn't exist, let's create it.
		if (!$menu_exists) {
			$menu_id = wp_create_nav_menu($menuname);

			// Set up default BuddyPress links and add them to the menu.

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Home'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'),
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('About'),
				'menu-item-classes' => 'about',
				'menu-item-url' => $about_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Contact'),
				'menu-item-classes' => 'contact',
				'menu-item-url' => $contact_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Sign in'),
				'menu-item-classes' => 'sign-in',
				'menu-item-url' => $signin_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Register'),
				'menu-item-classes' => 'register',
				'menu-item-url' => $register_perma,
				'menu-item-status' => 'publish'
			));
/*
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Recover account'),
				'menu-item-classes' => 'recover-account',
				'menu-item-url' => $recoveraccount_perma,
				'menu-item-status' => 'publish'
			));
 */
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Search classes'),
				'menu-item-classes' => 'search-classes',
				'menu-item-url' => $searchforclasses_perma,
				'menu-item-status' => 'publish'
			));

			// Grab the theme locations and assign our newly-created menu
			// to the top-navbar-guest menu location.
			if (!has_nav_menu($bpmenulocation)) {
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$bpmenulocation] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}

		$menuname = 'top-navbar-user';
		$bpmenulocation = 'top-navbar-user';
		// Does the menu exist already?
		$menu_exists = wp_get_nav_menu_object($menuname);

		// If it doesn't exist, let's create it.
		if (!$menu_exists) {
			$menu_id = wp_create_nav_menu($menuname);

			// Set up default BuddyPress links and add them to the menu.
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Home'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'),
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('About'),
				'menu-item-classes' => 'about',
				'menu-item-url' => $about_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Contact'),
				'menu-item-classes' => 'contact',
				'menu-item-url' => $contact_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Profile'),
				'menu-item-classes' => 'profile',
				'menu-item-url' => $profile_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Search classes'),
				'menu-item-classes' => 'search-classes',
				'menu-item-url' => $searchforclasses_perma,
				'menu-item-status' => 'publish'
			));

			// Grab the theme locations and assign our newly-created menu
			// to the top-navbar-guest menu location.
			if (!has_nav_menu($bpmenulocation)) {
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$bpmenulocation] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}

		$menuname = 'footer-navbar';
		$bpmenulocation = 'footer-navbar';
		// Does the menu exist already?
		$menu_exists = wp_get_nav_menu_object($menuname);

		// If it doesn't exist, let's create it.
		if (!$menu_exists) {
			$menu_id = wp_create_nav_menu($menuname);

			// Set up default BuddyPress links and add them to the menu.
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Home'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'),
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('About'),
				'menu-item-classes' => 'about',
				'menu-item-url' => $about_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Contact'),
				'menu-item-classes' => 'contact',
				'menu-item-url' => $contact_perma,
				'menu-item-status' => 'publish'
			));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Search classes'),
				'menu-item-classes' => 'search-classes',
				'menu-item-url' => $searchforclasses_perma,
				'menu-item-status' => 'publish'
			));

			// Grab the theme locations and assign our newly-created menu
			// to the top-navbar-guest menu location.
			if (!has_nav_menu($bpmenulocation)) {
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$bpmenulocation] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}
	}
}
add_action('after_setup_theme', 'gradschoolzero_setup');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
	require_once get_template_directory() . '/classes/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

function deactivate_my_theme( $new_theme ) {
	//delete menus
	unregister_nav_menu( 'top-navbar-user' );
	unregister_nav_menu( 'top-navbar-guest' );
	unregister_nav_menu( 'footer-navbar' );

	//delete pages

	flush_rewrite_rules(false);
}
add_action( 'switch_theme', 'deactivate_my_theme' );


/*
 * Function to sign in users
 */
function my_login_redirect($redirected_to, $requested_redirect_to, $user)
{
	if (is_wp_error($user)) {
		$error_types = array_keys($user->errors);
		$error_type = 'Empty fields';
		if (is_array($error_types) && !empty($error_types)) {
			$error_type = $error_types[0];
		}
		wp_redirect(get_permalink(get_page_by_path('sign-in')->ID) . '?login=failed');
		exit;
	} else {
		return $requested_redirect_to;
	}
}
add_filter('login_redirect', 'my_login_redirect', 10, 3);

function checkUsernameDB($x)
{
	global $wpdb;
	$qry = $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "users WHERE user_login = %s", $x)
	);
	return $qry == true ? true : false;
}

function checkEmailDB($x)
{
	global $wpdb;
	$qry = $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "users WHERE user_email = %s", $x)
	);
	return $qry == true ? true : false;
}

function valid_name($x)
{
	if (preg_match("/^[a-zA-Z]*$/", $x) && strlen($x) > 1) {
		return true;
	} else {
		return false;
	}
}

function valid_email($x)
{
	if (filter_var($x, FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}

function valid_uid($x)
{
	if (preg_match("/^[a-zA-Z0-9]*$/", $x) && strlen($x) > 6) {
		return true;
	} else {
		return false;
	}
}

function valid_pw($x)
{
	if (preg_match("/^[a-zA-Z0-9!?@$*&%]*$/", $x) && strlen($x) > 7) {
		return true;
	} else {
		return false;
	}
}

function valid_student_gpa($x)
{
	if (is_numeric($x) && $x > 0 && $x <= 5) {
		return true;
	} else {
		return false;
	}
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

























































/*
 *
 * Hook into css and js files
 *
 */
function index_script_enqueue()
{
	//core bootstrap files, core css files
	wp_enqueue_style('bootstrapCSS', get_template_directory_uri() . '/assets/bootstrap-5.1.3-dist/css/bootstrap.min.css');
	/*Main css file, contatins styles that only affect the entire theme like adding color classes and changing font-type of elements*/
	wp_enqueue_style('mainCSS', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('dashicons');
	wp_enqueue_script('popperJS', get_template_directory_uri() . '/assets/popperjs-2.10.2-dist/popper.min.js');
	wp_enqueue_script('bootstrapJS', get_template_directory_uri() . '/assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js');
	//wp_enqueue_script('bootboxJS', get_template_directory_uri() . '/assets/bootbox-5.5.2-dist/bootbox.min.js');
	/*Configuration file for this theme, includes AJAX config and creating bootbox prompts for system messages*/
	wp_enqueue_script('configJS', get_template_directory_uri() . '/assets/js/configure.js', array('jquery'));

	/*
	Add javascript files here, the comment below is an example, make sure the first parameter is unique, just keep parameters 3-5 the same
	 */
	//wp_enqueue_script('myFileJS', get_template_directory_uri() . '/assets/js/my-file.js', array('jquery'), '1.0', true);
	wp_enqueue_script('signupJS', get_template_directory_uri() . '/assets/js/signup_controls.js', array('jquery'), '1.0', true);
	/* Student and instructor profile javascript controls */
	wp_enqueue_script('profileJS', get_template_directory_uri() . '/assets/js/profile_controls.js', array('jquery'), '1.0', true);
	/* Single class page javascript controls */
	wp_enqueue_script('classJS', get_template_directory_uri() . '/assets/js/single_class_controls.js', array('jquery'), '1.0', true);


	/*
	Add css files here, the comment below is an example
	 */
	//wp_enqueue_style('myFileCSS', get_template_directory_uri() . '/assets/css/my-file.css');
	/* Signup stylesheet */
	wp_enqueue_style('signupCSS', get_template_directory_uri() . '/assets/css/signup_style.css');
	/* Student and instructor profile stylesheets */
	wp_enqueue_style('profileCSS', get_template_directory_uri() . '/assets/css/profile_style.css');




	//add logout url and logout button html so we can localize it in the config.js file where we append it to the navbar after loading the page
	$logoutRaw = wp_loginout($_SERVER['REQUEST_URI'], false);
	$logoutNav = "<li class='nav-item nav-link'>$logoutRaw<span class='dashicons dashicons-migrate pl-1'></span></li>";

	/*This allows PHP variables to be passed as a javascript object called gsz into the specified javascript file. 
	 * We need to pass the admin-agax url into the configuration.js file so it can setup AJAX accordingly
	 * We also need to pass the logout html so that it can append it to the navbar
	 */
	wp_localize_script('configJS', 'gsz', array(
		'url' => admin_url('admin-ajax.php'),
		'logOut' => $logoutNav
	));
}
add_action('wp_enqueue_scripts', 'index_script_enqueue');


/*
Add php files with hook names matching the ajax function calls in JS file
 */

//Class search functions
require  get_template_directory() . '/inc/search-classes-function.php';
//Signup functions
require  get_template_directory() . '/inc/signup-function.php';
//Profile functions
require  get_template_directory() . '/inc/profile-function.php';
//Single class functions
require  get_template_directory() . '/inc/single-class-function.php';
