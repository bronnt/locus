<?php
/**
 * Template Name: 2 Column Template
 *
 * @package University of Utah
 */

get_header(); ?>
<?php get_post_custom(); ?>
<div class="container-fluid">

    <div class="ten-twenty-four row clearfix">
    	<?php if(function_exists(simple_breadcrumb)) {simple_breadcrumb();} ?>
    	<?php if ( ! dynamic_sidebar( 'sidebar-above-columns' ) ) : endif; ?>

		<div class="two-column-margin">
	    	<div class="col-sm-8 main-channel float-left">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

				  		<?php if ( ! dynamic_sidebar( 'sidebar-top' ) ) : endif; ?>		

						<div class="content-padding">

							<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'content', 'page' ); ?>

							<?php //umc2014_post_nav(); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() ) :
									comments_template();
								endif;
							?>

						</div>

					<?php endwhile; // end of the loop. ?>

					<?php if ( ! dynamic_sidebar( 'sidebar-bottom' ) ) : endif; ?>

					</main><!-- #main -->
			
				</div><!-- #primary -->
			</div>
		</div>

		<?php get_sidebar(); ?>

	</div> <!-- #content-wrapper -->

</div>


<?php get_footer(); ?>