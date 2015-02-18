<?php
/*

Plugin Name: Utah - Body Callout
Plugin UI: http://umc.utah.edu
Description: Add a body callout. Choose background color, image, copy and/or button.
Version: 0.3
Author: Dave White
Author URI: http://umc.utah.edu
License: 

*/

class umc_body_callout extends WP_Widget {
	
	function __construct() {
		parent::__construct(false, $name = __('Utah - Body Callout'));
	}

	function form( $instance ) {  /* set */
		
		$alignment = 'left';
		$image = '';
		$color = '';
		$title = '';
		$text = '';
		$link = '';
		$button = '';

		if (isset($instance['alignment'])) {
			$alignment = $instance['alignment'];
		}

		if (isset($instance['image'])) {
			$image = $instance['image'];
		}

		if (isset($instance['color'])) {
			$color = $instance['color'];
		}

		if (isset($instance['title'])) {
			$title = $instance['title'];
		}

		if (isset($instance['text'])) {
			$text = $instance['text'];
		}

		if (isset($instance['link'])) {
			$link = $instance['link'];
		}

		if (isset($instance['button'])) {
			$button = $instance['button'];
		}

	?>
		<br />Callout box alignment:<br /><br />
		<label for="<?php echo $this->get_field_id('left'); ?>"><input type="radio" name="<?php echo $this->get_field_name('alignment'); ?>" value="left" id="<?php echo $this->get_field_id('left'); ?>" <?php checked($alignment, "left"); ?> />  <?php echo __("Left"); ?></label><br />
		<label for="<?php echo $this->get_field_id('center'); ?>"><input type="radio" name="<?php echo $this->get_field_name('alignment'); ?>" value="center" id="<?php echo $this->get_field_id('center'); ?>" <?php checked($alignment, "center"); ?> />  <?php echo __("Center"); ?></label><br />
		
		<br /><br />Callout box color:<br /><br />
		<label for="<?php echo $this->get_field_id('dark-gray'); ?>"><input type="radio" name="<?php echo $this->get_field_name('color'); ?>" value="dark-gray" id="<?php echo $this->get_field_id('dark-gray'); ?>" <?php checked($color, "dark-gray"); ?> />  <?php echo __("Dark Gray"); ?></label><br />
		<label for="<?php echo $this->get_field_id('light-gray'); ?>"><input type="radio" name="<?php echo $this->get_field_name('color'); ?>" value="light-gray" id="<?php echo $this->get_field_id('light-gray'); ?>" <?php checked($color, "light-gray"); ?> />  <?php echo __("Light Gray"); ?></label><br />
		<label for="<?php echo $this->get_field_id('white'); ?>"><input type="radio" name="<?php echo $this->get_field_name('color'); ?>" value="white" id="<?php echo $this->get_field_id('white'); ?>" <?php checked($color, "white"); ?> />  <?php echo __("White"); ?></label><br />
		
		<p>* The image can be a media asset in your WordPress Media Library as well as an externally hosted image (i.e. an image hosted on a CDN or some other asset manager). </p>
		<p>* The image is scaled to fit, but for the best resolution a width of at least 400 pixels is recommended.</p>
		<p>* Not all fields are required. If a field is left blank it will simply be left out of the widget.</p>

	<?php

		echo '<br /><br /><label for="' . $this->get_field_id('image') . '">Image URL: </label>';
		echo '<br /><input type="text" class="widefat" value="' . $image . '" name="' . $this->get_field_name('image') . '" id="' . $this->get_field_id('image') . '">';

		echo '<br /><br /><label for="' . $this->get_field_id('title') . '">Title: </label>';
		echo '<br /><input type="text" class="widefat" value="' . $title . '" name="' . $this->get_field_name('title') . '" id="' . $this->get_field_id('title') . '">';

		echo '<br /><br /><label for="' . $this->get_field_id('text') . '">Text: </label>';
		echo '<br /><textarea rows="4" class="widefat" value="' . $text . '" name="' . $this->get_field_name('text') . '" id="' . $this->get_field_id('text') . '">' . $text . '</textarea>';

		echo '<br /><br /><label for="' . $this->get_field_id('link') . '">Link URL:<br />(be sure to include "http://")</label>';
		echo '<br /><input type="text" class="widefat" value="' . $link . '" name="' . $this->get_field_name('link') . '" id="' . $this->get_field_id('link') . '">';

		echo '<br /><br /><label for="' . $this->get_field_id('button') . '">Button Text: </label>';
		echo '<br /><input type="text" class="widefat" value="' . $button . '" name="' . $this->get_field_name('button') . '" id="' . $this->get_field_id('button') . '"><br /><br />';
	}

	function update( $new_instance, $old_instance) {  /* update */
		$instance['alignment'] = filter_var(stripslashes($new_instance['alignment']), FILTER_SANITIZE_STRING);
		$instance['image'] = filter_var(stripslashes($new_instance['image']), FILTER_SANITIZE_URL);
		$instance['color'] = filter_var(stripslashes($new_instance['color']), FILTER_SANITIZE_STRING);
		$instance['title'] = filter_var(stripslashes($new_instance['title']), FILTER_SANITIZE_STRING);
		$instance['text'] = filter_var(stripslashes($new_instance['text']), FILTER_SANITIZE_STRING);
		$instance['link'] = filter_var(stripslashes($new_instance['link']), FILTER_SANITIZE_URL);
		$instance['button'] = filter_var(stripslashes($new_instance['button']), FILTER_SANITIZE_STRING);					
		return $instance;
	}

	function widget($args, $instance) {  /* display */	
  		echo '<div class="body-callout-box ' . $instance['color'] . '-callout row clearfix">';
        echo '<div class="ten-twenty-four">';
        if ($instance['image'] != '') {
        	echo '<div class="callout-image col-sm-5">';
            echo '<img src="' . $instance['image'] . '" /></div>';
            echo '<div class="callout-description ' . $instance['alignment'] . '-align col-sm-7">';
        }
        else {
        	echo '<div class="callout-description ' . $instance['alignment'] . '-align col-sm-12">';
        }
        echo '<h2>' . $instance['title'] . '</h2>';
        echo $instance['text'];
        if ($instance['button'] != '') {
        	echo '<br /><br /><div class="callout-button clearfix"><a class="button" href="' . $instance['link'] . '">' . $instance['button'] . '</a></div>';
        }
        //if ($instance['image'] != '') {
        //	echo '</div></div> <!-- #body photo/feature callout -->';
        //}
        //else {
        	echo '</div></div></div> <!-- #body photo/feature callout -->';
        //}

	}
}

add_action('widgets_init', function() {
	register_widget('umc_body_callout');
})

?>