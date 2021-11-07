<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */

?>

<?php
/*

$pt = get_the_current_post_type();
switch($pt)
{
	case 'class':
		require class-content.php;
	case 'message':
		require class-content.php;

}

$role = get_the_current_users_role();
switch($role)
{
	case 'student':
		require class-student-view.php;

}
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>

		<?php //gradschoolzero_post_thumbnail(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(
			//gradschoolzero_continue_reading_text()
		);

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'gradschoolzero' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'gradschoolzero' ),
			)
		);

		?>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->
