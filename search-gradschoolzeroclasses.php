<?php

/**
 * 
 * Search classes page for the gradschoolzero Theme.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
get_header();

//Get the <paged> query var from the url
$currentPage = get_query_var('paged');
//Get the <ct> query var from the url
$s = (get_query_var('ct')) ? get_query_var('ct') : false;
//Put these query vars into a WP query argument
$qry = array(
    'post_type'    => 'gradschoolzeroclass',
    'posts_per_page' => 10,
    'paged' => $currentPage,
    's' => $s
);
?>
<div class="banner mb-5">
  <div class="heading container">
    <h1 class="text-white">Search for classes.</h1>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form method='GET' action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <input type="hidden" name="action" value="classSearchForm">
                <div class="form-row">
                    <div class="col-md-12">
                        <input type="text" name="ct" value="" placeholder="search classes" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <button type="submit" class="w-100 btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            <?php
			//Display a message for what the user is searching for from the field <ct>
			$sf = $qry['s'];
            if(!empty($sf)) echo "<h3 class='pt-5'>Searching for $sf</h3>";
            ?>
        </div>
        <div class="col-md-8">
			<div class="table-responsive">
				<table class="table table-list">
					<thead>
						<tr>
							<td scope="col" class="text-muted"><u>POSTED</u></td>
							<td scope="col" class="text-muted"><u>TITLE</u></td>
							<td scope="col" class="text-muted"><u>DESCRIPTION</u></td>
						</tr>
					</thead>
					<tbody>
						<?php
						//Query for WP classes using the arguments from the url
						$classPosts = new WP_Query($qry);
						if ($classPosts->have_posts()) {
							while ($classPosts->have_posts()) {
								$classPosts->the_post();
								$date = get_the_date();
								$perma = get_the_permalink();
								$title = get_the_title();
								$excerpt = get_the_excerpt();
								echo "<tr>";
									echo "<td>$date</td>";
									echo "<td><a href='$perma'>$title</a></td>";
									echo "<td>$excerpt</td>";
								echo "</tr>";
							}
						} else {
							echo '<tr><td colspan="3">Sorry, We couldn\'t find any classes for you. Please alter your search, or try again later.</td></tr>';
						}
						?>
					</tbody>
				</table>
			</div>
			<?php echo paginate_links(array('total' => $classPosts->max_num_pages)); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
