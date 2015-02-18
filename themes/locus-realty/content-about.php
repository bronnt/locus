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

			$title_3 = $custom_fields[box_3_title_text][0];
			$body_3 = $custom_fields[box_3_body_text][0];
			$img_url_3 = $custom_fields[box_3_img_url][0];

			$title_4 = $custom_fields[box_4_title_text][0];
			$body_4 = $custom_fields[box_4_body_text][0];
			$img_url_4 = $custom_fields[box_4_img_url][0];
			
		?>

		<div class="about clearfix">
			<img src="<?php echo $img_url_1; ?>"/>
			<h2><?php echo $title_1; ?></h2>
			<p><?php echo $body_1; ?></p>
		</div>
		<div class="about clearfix">
			<img src="<?php echo $img_url_2; ?>"/>
			<h2><?php echo $title_2; ?></h2>
			<p><?php echo $body_2; ?></p>
		</div>
		<div class="about clearfix">
			<img src="<?php echo $img_url_3; ?>"/>
			<h2><?php echo $title_3; ?></h2>
			<p><?php echo $body_3; ?></p>
		</div>
		<div class="about clearfix">
			<img src="<?php echo $img_url_4; ?>"/>
			<h2><?php echo $title_4; ?></h2>
			<p><?php echo $body_4; ?></p>
		</div>



	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'umc2014' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->





