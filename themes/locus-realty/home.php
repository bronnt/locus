<?php
/**
 * The main template file for the blog index.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package University of Utah
 */

get_header(); ?>

<div class="container-fluid">

    <div class="ten-twenty-four row clearfix">
    	<?php// if(function_exists(simple_breadcrumb)) {simple_breadcrumb();} ?>
    	<?php if ( ! dynamic_sidebar( 'sidebar-above-columns' ) ) : endif; ?>
    	<div class="two-column-margin">
	    	<div class="col-sm-8 main-channel">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

					<?php if ( have_posts() ) : ?>

						<?php /* Start the Loop */ ?>

						<div class="content-padding">

						<h2>In the News</h2>

		  					<?php query_posts('posts_per_page=10');
								$first_post = ( $paged == 0 ) ? $posts[0]->ID : '';
		  						while (have_posts()) : the_post();

								if ($first_post == $post->ID) {
									if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
									  the_post_thumbnail();
									} 
								} ?>

		  					<div class="news-exerpt clearfix">
								<?php 
				  					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. 
				  						if ($first_post == $post->ID) { ?>
					    					<br class="clearfix" />
					    					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					    					<p><?php the_date(); ?></p>
					    					<p><?php the_excerpt(); ?></p>
				  						<?php }
				  						else { ?>
			  							<div class="home-news-thumbnail">
				  							<?php the_post_thumbnail(); ?>
										</div>
					 					<div class="home-news-description">
					    					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					    					<p><?php the_date(); ?></p>
					    					<p><?php the_excerpt(); ?></p>
					    				</div>									
								<?php } 

					    		
									}
									else { ?>
					    					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					    					<p><?php the_date(); ?></p>
					    					<p><?php the_excerpt(); ?></p>	
					    		<?php								
									}
			 					?>				    		
			    			</div>
			    			<hr />

	<!--
		    				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		    				<p><?php the_date(); ?></p>
		    				<p><?php the_excerpt(); ?></p>
		    				<hr />
	-->
		  					<?php endwhile;?>

						</div>

					<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div>

		</div>

		<?php get_sidebar(); ?>	

	</div><!-- #ten twenty four -->

</div><!-- #container fluid -->


<?php get_footer(); ?>
