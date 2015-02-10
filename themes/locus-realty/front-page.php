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
			<h1>
				<?php $title = get_post_meta( 34, 'box_1_text' ); 
				echo($title[0]);?>
			</h1>
			<p>
				<?php $body = get_post_meta( 34, 'box_2_text' ); 
				echo($body[0]);?>
			</p>
			<p>
				<?php $quote = get_post_meta( 34, 'box_3_text' ); 
				echo($quote[0]);?>
			</p>
			
		</div><!-- ten twenty four -->
	</div><!-- #primary -->

</div>
<?php get_footer(); ?>
