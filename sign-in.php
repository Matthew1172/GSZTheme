<?php

/**
 * 
 * Home page for the gradschoolzero Theme.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
/* Template Name: sign-up */ 

if (!is_user_logged_in()) {
	get_header();

    $html = '';
    $msg = (get_query_var('login')) ? "Your username or password was entered incorrectly." : null;
    ?>

    <div class="banner">
        <div class="heading container">
            <h1 class="text-white">Sign in.</h1>
        </div>
    </div>
    <div class="container control-area">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php
                    echo "<h4 class='text-center' style='color: red;'>$msg</h4>";
                    $args = array(
                        'form_id' => 'login_form',
                        'redirect' => (get_permalink(get_page_by_path('profile')->ID)),
                        'id_username' => 'login_username',
                        'id_password' => 'login_password',
                        'id_remember' => 'login_remember',
                        'id_submit' => 'login_submit',
                        'label_username' => 'Username',
                        'label_password' => 'Password',
                        'label_remember' => 'Remember me',
                        'label_log_in' => 'Log in'
                    );
                    wp_login_form($args);

                    $create = get_permalink(get_page_by_path('register')->ID);
                    echo "<p class='text-center py-1'><a href=$create>Create account</a></p>";
                    ?>
            </div>
        </div>
    </div>
    <?php if ($msg): ?>
        <script>
            document.getElementById('login_username').className += ' input-error';
            document.getElementById('login_password').className += ' input-error';
        </script>
    <?php endif; ?>
<?php
	get_footer();
} else {
    wp_redirect(home_url());
}