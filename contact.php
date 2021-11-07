<?php
/**
 * 
 * Template for displaying Contact office and staff page.
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
/* Template Name: contact */ 

require 'header.php'; ?>


<div class="banner">
  <div class="heading container">
    <h1 class="text-white">Contact us</h1>
  </div>
</div>

<div class="container control-area">
  <div class="row">
    <div class="col-md-6">
      <h2 class="bColor">Office contacts: </h2>
      <hr>
      <?php
      $contactOffice_qry = array(
        'category_name' => 'contactOffice'
      );
      $query = new WP_Query($contactOffice_qry);
      if($query->have_posts())
      {
        while($query->have_posts())
        {
          $query->the_post();
          the_content();
        }
      }
      ?>
    </div>
    <div class="col-md-6">
      <h2 class="bColor">Staff contacts: </h2>
      <hr>
      <?php
      $contactOffice_qry = array(
        'category_name' => 'contactStaff'
      );
      $query = new WP_Query($contactOffice_qry);
      if($query->have_posts())
      {
        while($query->have_posts())
        {
          $query->the_post();
          the_content();
        }
      }
      ?>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>