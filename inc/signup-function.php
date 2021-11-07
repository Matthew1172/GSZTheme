<?php

/*
 *
 * Function to sign up users
 *
 */
function signup_insert()
{

}
add_action('wp_ajax_nopriv_call_signup', 'signup_insert');