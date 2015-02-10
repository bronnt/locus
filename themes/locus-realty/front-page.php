<?php
/**
 * The front page template file.
 *
 * This is the template used to generate all of the content 
 * on the home page of the site. It pulls in content from
 * a sidebar location that is specific to the home page.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package University of Utah
 */

get_header(); ?>

<div class="container-fluid">
	<div id="primary" class="content-area home-page-content">
		<?php if ( ! dynamic_sidebar( 'front-page' ) ) : endif; ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content();?>
			<?php endwhile; endif; ?>
		<div class='ten-twenty-four'>
			
				<?php $title = get_post_meta( 34 ); ?>

				<?php $paragraph_1 = get_post_meta( 34, 'box_2_text' ); ?>
			
				<?php $paragraph_2 = get_post_meta( 34, 'box_3_text' ); ?>
			


			<div class="home-content-wrapper clearfix">
				<div class='copy'>
					<?php if (isset($title)):?>
					<h2 class="page-title"><?php echo $title[0]; ?></h2>
					<?php endif ?>
					<p><?php echo $paragraph_1[0]; ?></p>
					<?php if (isset($paragraph_2)):?>
						<p><?php echo $paragraph_2[0]; ?></p>
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
		</div><!-- ten twenty four -->
	</div><!-- #primary -->

</div>
<?php get_footer(); ?>
