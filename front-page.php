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
require 'header.php';

?>

<div class="container bg-white">
</div>

<?php

require 'inc/front-page-function.php';

?>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">Class Name</th>
            <th scope="col">Top Average Ratings</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($average_ratings as $average) :
            echo ('<tr> <th class="w-5">' . $average->getClass_name() . '</th>
                        <th class="w-5">' . $average->getAverage_rating() . '</th> </tr>');
        endforeach;
        ?>
    </tbody>
</table>

<?php require 'footer.php'; ?>