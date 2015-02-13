<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package University of Utah
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="page-title"><?php the_title(); ?></h2>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php 
			$custom_fields = get_post_custom();
			$title_1 = $custom_fields[box_1_title_text][0];
			$body_1 = $custom_fields[box_1_body_text][0];
			$img_url_1 = $custom_fields[box_1_img_url][0];

			$title_2 = $custom_fields[box_2_title_text][0];
			$body_2 = $custom_fields[box_2_body_text][0];
			$img_url_2 = $custom_fields[box_2_img_url][0];
			
			echo $title_1; 
			echo "<br/><br/>";
			echo $body_1; 
			echo "<br/><br/>";
			echo '<img src="' .$img_url_1. '"/>';
			echo "<br/><br/>";
			echo "<br/><br/>";
			echo $title_2; 
			echo "<br/><br/>";
			echo $body_2; 
			echo "<br/><br/>";
			echo '<img src="' .$img_url_2. '"/>';
			
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'umc2014' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->





