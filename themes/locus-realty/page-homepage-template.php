<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Locus Realty
 */

get_header(); ?>

<div class="container-fluid">
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class='homepage-content'>
				<?php if ( ! dynamic_sidebar( 'sidebar-top' ) ) : endif; ?>
				<div class="ten-twenty-four row clearfix loop-padding">
					<?php //if(function_exists(simple_breadcrumb)) {simple_breadcrumb();} ?>
					
					
	
					<?php while ( have_posts() ) : the_post(); ?>
	
						<?php get_template_part( 'content', 'homepage' ); ?>
	
						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>
						
						<?php endwhile; // end of the loop. ?>
				</div><!-- #ten twenty four -->	
	
				<?php if ( ! dynamic_sidebar( 'sidebar-bottom' ) ) : endif; ?>
			
					</main><!-- #main -->
			</div><!-- .homepage-content -->
	</div><!-- #primary -->

	

</div><!-- #container fluid -->


<?php get_footer(); ?>