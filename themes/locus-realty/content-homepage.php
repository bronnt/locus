<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package locus realty
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php //the_content(); ?>
		<?php 
			$custom_fields = get_post_custom();
			$title = $custom_fields[box_1_text][0];
			$paragraph_1 = $custom_fields[box_2_text][0];
			$paragraph_2 = $custom_fields[box_3_text][0];
		?>
	
<div class="home-content-wrapper">
	<div class='copy'>	
		<?php if (isset($title)):?>
		<h2 class="page-title"><?php echo $title; ?></h2>
		<?php endif ?>
		<p><?php echo $paragraph_1; ?></p>
		<?php if (isset($paragraph_2)):?>
			<p><?php echo $paragraph_2; ?></p>
		<?php endif ?>
	</div>
<div class='photo-cluster'>
	<div class='right-photo'>
		<?php if (class_exists('MultiPostThumbnails')) :
	    MultiPostThumbnails::the_post_thumbnail(
	        get_post_type(),
	        'tall'
	    );
	    endif; ?>
	</div>	<!-- .right-photo -->
	<div class='stacked-photos'>
		<?php if (class_exists('MultiPostThumbnails')) :
	    MultiPostThumbnails::the_post_thumbnail(
	        get_post_type(),
	        'top-left'
	    );
	    endif; ?>
		<?php if (class_exists('MultiPostThumbnails')) :
	    MultiPostThumbnails::the_post_thumbnail(
	        get_post_type(),
	        'bottom-left'
	    );
	    endif; ?>
	</div><!-- .stacked photos -->
</div>
</div><!-- .home-content-wrapper -->
	</div><!-- .entry-content -->
	<?php //edit_post_link( __( 'Edit', 'umc2014' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->





