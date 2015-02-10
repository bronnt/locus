<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package University of Utah
 */
?>

<?php

    if ( !isset($themeOptions) )
    	$themeOptions = UtahThemeOptions::getOptions();
    

?>

	</div><!-- #main container -->



		<div id="footer-container" class="clearfix">
			 <footer class="wrapper clearfix">
					<nav id="bottom-nav" role="navigation">
						<a href="javascript:///" class="bottom-mobile-nav mobile-menu-trigger" rel="bottom">QUICK LINKS <span> </span></a>
				<?php wp_nav_menu( array( 
					'theme_location' 	=> 'footer', 
					'menu_class' 		=> 'bottom-menu menu-trigger',
					'container' 		=> false,
					'before'      => '<h3>',
					'after'       => '</h3>',
					'items_wrap'    => '<ul id="%1$s" class="%2$s" rel="bottom">%3$s</ul>'
				) ); ?>
					</nav>

					<section class="brand-area clearfix">
						
						<div class="bottom-brand">
							<div class="spacer">
							
								<!--<?php if ( ! dynamic_sidebar( 'footer-logo' ) ) : endif; ?> -->

								<?php if ( !empty($themeOptions['department_logo']) ) { ?>
									<img src="<?php echo $themeOptions['department_logo']; ?>" /><br />
								<?php } ?>

								<br />

								<div class="socons">
									
									<ul class="icon-list">
											<?php if ( !empty($themeOptions['email_url']) ) { ?>
											<li><a title="Join Our Email List" class="email-icon" href="<?php echo $themeOptions['email_url']; ?>">email list</a></li>	
										<?php } if ( !empty($themeOptions['facebook_url']) ) { ?>
											<li><a title="twitter" class="facebook-icon" href="<?php echo $themeOptions['facebook_url']; ?>">facebook</a></li>	
										<?php }?>


                                            <!-- <li><a title="Join Our Email List" class="email-icon" href="#">email list</a></li>
										    <li><a title="Link to our Facebook Page" class="facebook-icon" href="#">facebook</a></li> -->
									</ul>
									
								</div>								

							</div>
						</div>


						<section class="address">
							<div class="spacer">


								<!--<?php if ( ! dynamic_sidebar( 'footer-address' ) ) : endif; ?>-->
								
								<p>
								<?php if ( !empty($themeOptions['department_name']) ) {
									echo $themeOptions['department_name']; ?><br />
								<?php } if ( !empty($themeOptions['department_address']) ) {
									echo $themeOptions['department_address']; ?><br />
								<?php } if ( !empty($themeOptions['department_address2']) ) {
									echo $themeOptions['department_address2']; ?><br />
								<?php } if ( !empty($themeOptions['department_phone']) ) {
									echo $themeOptions['department_phone']; ?><br />
								<?php } ?>
								</p> 
								<p>
									&copy; <?php echo date("Y"); ?> Locus Realty
								</p>
							</div>
						</section>
					</section>
			 </footer>

</div><!-- #footer container -->

<?php wp_footer(); ?>

		<?php if ( !empty($themeOptions['google_analytics']) ) { ?>

			<script>
			 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			 })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			 ga('create', '<?php echo $themeOptions['google_analytics']; ?>', 'auto');
			 ga('send', 'pageview');

			</script>
		<?php }?>
</body>
</html>
