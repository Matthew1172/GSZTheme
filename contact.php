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

get_header();
?>


<div class="banner mb-5">
  <div class="heading container">
    <h1 class="text-white">Contact us.</h1>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2 class="">Office contacts: </h2>
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
      <h2 class="">Staff contacts: </h2>
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
<?php get_footer(); ?>