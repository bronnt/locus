<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package locus realty
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
			$primary_select = $custom_fields[primary_select][0];
			$happening_text = $custom_fields[happening_text][0];
			$subtitle_text = $custom_fields[subtitle_text][0];
			$student_text = $custom_fields[student_text][0];
			
			echo $primary_select; //category red ribbon link on home page with conditional
			echo "<br/><br/>";
			echo $happening_text; // Happening Now loop located in sidepbar.php - happening now excerpt
			echo "<br/><br/>";
			echo $subtitle_text; // Feature article conditional subtext
			echo "<br/><br/>";
			echo $student_text; // Email Only for student excerpt
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'umc2014' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->





