<?php
/**
 * 
 * Footer that displays AJAX Loader for all pages. Also contains About Post category and Contact Office Post category.
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
?>
<!-- AJAX LOADER -->
<div id="loading">
    <div id="spinner" class="spinner-border" role="status">
        <span class="sr-only"></span>
    </div>
</div>

</body>

<footer id="footer" class="footer">
    <div class="container">
        <div class="row py-5">
            <div class="col-sm-4">
                <h5 class="footer-head"><b>Contact</b></h5>
                <div>
                    <?php
                    $contactOffice_qry = array(
                        'category_name' => 'contactFooter'
                    );
                    $query = new WP_Query($contactOffice_qry);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            the_content();
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-2">
                <h5 class="footer-head"><b>About</b></h5>
                <?php
                wp_nav_menu(array(
                    'menu' => 'footer-navbar',
                    'theme_location' => 'footer-navbar-loc',
                    'container_class' => 'custom-menu-class'
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <h5 class="footer-head"><b>Non-Discrimination Statement</b></h5>
                <p class="">Grad School Zero and Team M promote equal opportunity for all people without regard for race, color, creed, national origin, sex, age, lifestyle, sexual orientation, or disability.</p>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12'>
                <p class="text-center">Team M 2021 &copy;</p>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>

</html>
