<?php
/**
 * @package University of Utah
 */
?>
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300);
body{margin: 0; padding: 0;}
@media only screen and (max-width: 660px){
	table.container, table.container .logo img, table.footer{width: 100% !important;}
	td.logo{resize: both !important; width: 100% !important;}
	td.content{padding-bottom: 30px !important;}
	td.content, td.promos{padding-right: 12px !important; padding-left: 12px !important;}
	td.promos table{width: 48% !important;}
	td.promos table td img{ width:100%;}
	td.promos table.button{width: 100% !important;}
	td.grey_callout table {width: 48% !important;}
	td.grey_callout table img{width: 100% !important;}
	td h1{font-size: 26px !important;}
}
@media only screen and (max-width: 510px){
	table.container {width: 100% !important;}
	table.container td {border: none !important;}
	td h1{font-size: 24px !important;}
	td.content{line-height: 20px !important; padding-bottom: 30px !important;}
	td.footer{padding: 20px 30px !important;}
	td.promos {padding: 0px 10px !important;}
	td.promos table{width: 100% !important; padding-bottom: 30px !important;}
	td.grey_callout table {width: 100% !important; text-align: center !important; padding: 0px 20px 20px 20px !important;}
	td.grey_callout table img{width: 72% !important;}
	td.grey_callout table td {padding-top: 0px !important;}
}
</style>

<!-- **********************************
Loops Begin
***********************************-->
<?php
$title_date = get_the_title();
$tracking_URL = 'http://umc.utah.edu/campaign/track.html?utm_source=at-the-u&utm_medium=email&utm_campaign=' . $title_date . '&utm_content=';	
$promo_title_style = 'style="margin:12px 0px 15px 0px; font-weight:normal; font-size:28px; color:#696767; font-family: \'Open Sans Condensed\', Helvetica;"';

/*******************************
Pull in article ID's
********************************/
$custom_fields = get_post_custom();
    $header_image_id = get_the_ID(); //featured image
    $header_content = 'p=' . ($custom_fields[header_content][0]);
    $article_id_1 = 'p=' . ($custom_fields[box_1][0]);
    $article_id_2 = 'p=' . ($custom_fields[box_2][0]);
    $article_id_3 = 'p=' . ($custom_fields[box_3][0]);
    $article_id_4 = 'p=' . ($custom_fields[box_4][0]);
    $article_id_5 = 'p=' . ($custom_fields[box_5][0]);
    $article_id_6 = 'p=' . ($custom_fields[box_6][0]);
    $article_id_7 = 'p=' . ($custom_fields[box_7][0]);
    $article_id_8 = 'p=' . ($custom_fields[box_8][0]);
    $article_id_9 = 'p=' . ($custom_fields[box_9][0]);
    $article_id_10 = 'p=' . ($custom_fields[box_10][0]);
    $article_id_11 = 'p=' . ($custom_fields[box_11][0]);
    $article_id_12 = 'p=' . ($custom_fields[box_12][0]);
    ?>


<!-- **********************************
Email Tables Begin
***********************************-->
<body bgcolor="#555">
	<div style="font-size:1px;color:#000;display:none;">
		&#64; The U Newsletter
	</div>
	<table width="100%" border="0" cellspacing='0' cellpadding="0" bgcolor="#ccc">
		<tr>
			<td>
				<table class="container" bgcolor="#fff" width="640" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" class="logo" bgcolor="#fff" style="padding:0;">
							<?php
							$first_query = new WP_Query($header_content); 
							while($first_query->have_posts()) : $first_query->the_post();
							?>
							<a href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
								<?php 
								if(has_post_thumbnail($header_image_id)) {                    
									$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($header_image_id),'full' );
									echo '<img src="' . $image_src[0]  . '" width="640"  />';
								} 
					                 	//echo get_the_post_thumbnail( $header_image_id, array(640, 9999) ); 
								?>
							</a>
						</td>
					</tr>
					<tr>
						<td valign="top" bgcolor="#fff" class="content" style="padding: 35px 30px 10px 30px; font-family:Helvetica, sans-serif; font-size: 16px; line-height:22px; color: #696767;">
							<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
								<h1 <?php echo $promo_title_style;?>><?php the_title() ?></h1>
							</a>
								<?php the_excerpt();
								endwhile;
								wp_reset_postdata();
								?>
						</td>
					</tr>
					<!--########### promos ############ -->
					<tr>
						<td valign="top" bgcolor="#fff" class="promos" style="padding: 22px 30px 25px 30px; background-color: #fff; font-family: Helvetica, sans-serif; color: #696767;">
							<table class="promo_1" width="262" align="left">
								<tr>
									<td style="color: #696767;">
											<?php
											$first_query = new WP_Query($article_id_1); 
											while($first_query->have_posts()) : $first_query->the_post();
											if (has_post_thumbnail() ): ?>
											<a href="<?php echo $tracking_URL; ?><?php the_permalink() ?>"><?php the_post_thumbnail('email', array( 'class' => 'promo' )); ?></a>
										<?php endif ?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<h1 <?php echo $promo_title_style;?>><?php the_title() ?></h1>
										</a>
										<?php the_excerpt();
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
							</table>
							<table class="promo_2" width="262" align="right">
								<tr>
									<td style="color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_2); 
										while($first_query->have_posts()) : $first_query->the_post();
										if (has_post_thumbnail() ): ?>
										<a href="<?php echo $tracking_URL; ?><?php the_permalink() ?>"><?php the_post_thumbnail('email', array( 'class' => 'promo' )); ?></a>
										<?php endif ?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<h1 <?php echo $promo_title_style;?>><?php the_title() ?></h1>
										</a>
										<?php the_excerpt();
										endwhile;
										wp_reset_postdata();
										?>
								    </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#fff" style="padding: 22px 30px 0 30px; background-color: #fff;">
							<table width="100%">
								<tr>
									<td width="100%" style="border-top:1px solid #696767;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--################ Happening Now ################### -->
					<tr>
						<td valign="top" bgcolor="#fff" class="promos" style="padding: 22px 30px 25px 30px; background-color: #fff; font-family: Helvetica, sans-serif; color:#696767;">
							<table width="270" align="left">
								<tr>
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_3); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_4); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_5); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_6); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
							</table>
							<table width="270" align="right">
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_7); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_8); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_9); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
								<tr>	
									<td style="padding:0px 0px 15px 0px; color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_10); 
										while($first_query->have_posts()) : $first_query->the_post();?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<span style="color:#880606;"><?php the_title() ?></span>
										</a>
										<br/>
										<?php 
										$mykey_values = get_post_custom_values( 'happening_now' );
										if (isset($mykey_values)) {echo $mykey_values[0];}
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr> 
					<tr>
						<td bgcolor="#fff" style="padding: 0 30px 0 30px; background-color: #fff;">
							<table width="100%">
								<tr>
									<td width="100%" style="border-top:1px solid #696767;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr> 
					<tr>
						<td valign="top" bgcolor="#fff" class="promos" style="padding: 22px 30px 25px 30px; background-color: #fff; font-family: Helvetica, sans-serif; color: #696767;">
							<table class="promo_3" width="262" align="left">
								<tr>
									<td style="color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_11); 
										while($first_query->have_posts()) : $first_query->the_post();
										if (has_post_thumbnail() ): ?>
										<a href="<?php echo $tracking_URL; ?><?php the_permalink() ?>"><?php the_post_thumbnail('email', array( 'class' => 'promo' )); ?></a>
										<?php endif ?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<h1 <?php echo $promo_title_style;?>><?php the_title() ?></h1>
										</a>
										<?php the_excerpt();
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
							</table>
							<table class="promo_4" width="262" align="right">
								<tr>
									<td style="color: #696767;">
										<?php
										$first_query = new WP_Query($article_id_12); 
										while($first_query->have_posts()) : $first_query->the_post();
										if (has_post_thumbnail() ): ?>
										<a href="<?php echo $tracking_URL; ?><?php the_permalink() ?>"><?php the_post_thumbnail('email', array( 'class' => 'promo' )); ?></a>
										<?php endif ?>
										<a style="text-decoration:none;" href="<?php echo $tracking_URL; ?><?php the_permalink() ?>">
											<h1 <?php echo $promo_title_style;?>><?php the_title() ?></h1>
										</a>
										<?php the_excerpt();
										endwhile;
										wp_reset_postdata();
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--################ Footer ################ -->
					<tr>
						<!-- <td valign="top" bgcolor="#555555" class="callout" style="background-color: #555555; padding: 0px;"> -->
							<!-- <table class="footer" width="640" align="center" border="0" cellspacing="0" cellpadding="0" style="padding:20px;"> -->
								<!-- <tr> -->
									<td bgcolor="#555555" class="callout" valign="top" align="center" style="padding-left: 10px; padding-right: 10px; font-family:Helvetica, Helvetica; font-size:13px; line-height: 16px; color: #ffffff;background-color: #555555;">
										<img src="http://attheu.utah.edu/wp-content/uploads/2015/01/footer-logo.png" width="191" height="34" style="padding-bottom:5px;"><br>
										<p>You are receiving this newsletter because you are a member of the University of Utah community.</p>
										<p>If you'd like to submit an article or event for consideration in the @TheU Newsletter, please send an email to <a href="mailto:janelle.hanson@utah.edu" target="_blank" style="color:#fff;">janelle.hanson@utah.edu</a>.</p>
										<p>University Marketing and Communications<br />
											75 Fort Douglas Blvd.<br />
											Salt Lake City, UT 84113</p>
											<p>&copy; 2015 The University of Utah</p>
									</td>
								<!-- </tr> -->
							<!-- </table> -->
							<!-- <br style="clear:both;"> -->
						<!-- </td> -->
					</tr>
				</table><!-- end 640 width table -->
			</td>
		</tr>
	</table><!-- end 100% width table -->
</body>      
 <!-- **********************************
Email Tables End
***********************************-->



