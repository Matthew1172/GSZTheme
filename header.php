<?php
/**
 * 
 * Header file for gradschoolzero Theme 
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
?>
<!DOCTYPE html>
<html lang="en">

<head id="header">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/pics/HD123.png" />

    <title>gradZero</title>
    <?php wp_head(); ?>




</head>

<body id="content">
    <div class="">
        <nav id="navbar" class="navbar navbar-expand-md navbar-light bg-white container">
  <div class="container-fluid">
  <a class="navbar-brand" href="<?php echo home_url(); ?>"><img style="width: 80%;" id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/pictures/logo.jpg" /></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php
            if (is_user_logged_in()) {
                wp_nav_menu( array(
                    'menu' 				=> 'top-navbar-user',
                    'theme_location' 	=> 'top-navbar-user-loc',
                    'depth'             => 2,
                    'container'         => 'div',
                    'container_class'   => 'collapse navbar-collapse',
                    'container_id'      => 'bs4navbar',
                    'menu_id' 			=> 'logoutNav',
                    'menu_class'        => 'nav navbar-nav ms-auto',
                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'            => new WP_Bootstrap_Navwalker(),
                ) );
            } else {
                wp_nav_menu( array(
                    'menu' 				=> 'top-navbar-guest',
                    'theme_location'	=> 'top-navbar-guest-loc',
                    'depth'             => 2,
                    'container'         => 'div',
                    'container_class'   => 'collapse navbar-collapse',
                    'container_id'      => 'bs4navbar',
                    'menu_class'        => 'nav navbar-nav ms-auto',
                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'            => new WP_Bootstrap_Navwalker(),
                ) );
            }
            ?>
            </div>
        </nav>




    </div>