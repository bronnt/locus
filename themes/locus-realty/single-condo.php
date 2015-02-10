<?php
/**
 * The Template for displaying all single posts.
 *
 * @package University of Utah
 */

get_header(); ?>

<div class="container-fluid">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
                        
            <div class="ten-twenty-four row clearfix loop-padding">
                
                <div class="content-padding">

                    <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'condo' ); ?>


                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || '0' != get_comments_number() ) :
                            comments_template();
                        endif;
                    ?>

                </div>

                <?php endwhile; // end of the loop. ?>

            </div>
            
        </main><!-- #main -->
			
    </div><!-- #primary -->


</div>


<?php get_footer(); ?>