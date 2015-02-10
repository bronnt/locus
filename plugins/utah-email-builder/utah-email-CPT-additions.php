<?php
/*

Plugin Name: Utah - Email Builder
Plugin UI: http://umc.utah.edu
Description: Enable this plugin to build custom emails that pull from your most recent posts
Version: 0.1
Author: Brian Thurber
Author URI: http://umc.utah.edu
License: 

*/

/*---------------------------------
* Add a meta box to the UMC email generating custom post type. Reference http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
----------------------------------*/

/**
* Add custom post types.
*/
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'email',
		array(
			'labels' => array(
				'name' => __( 'Email' ),
				'singular_name' => __( 'email' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
		'title',
		'editor',
		'custom-fields',
		'revisions',
		'thumbnail',
		'author',
		'page-attributes',)
		)
	);
    add_image_size( 'email', 262 ); 
    add_image_size( 'email-header', 639, 9999 );
}

function email_customprefix_init() {
	add_post_type_support( 'email', 'simple-page-sidebars' );
}

add_action( 'init', 'email_customprefix_init' );
 /*
remove wisiwig and other features from email custom post type
 */
add_action('init', 'init_remove_support',100);
function init_remove_support(){
    $post_type = 'email';
    remove_post_type_support( $post_type, 'editor');
    remove_post_type_support( $post_type, 'comments');
    remove_post_type_support( $post_type, 'trackbacks');
    remove_post_type_support( $post_type, 'page-attributes');
    remove_post_type_support( $post_type, 'custom-fields');
    remove_post_type_support( $post_type, 'author');
}

add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
    add_meta_box( 'header_content', 'Header Article', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'header_content'));
    add_meta_box( 'box_1', 'Article with Image Top 1', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_1'));
    add_meta_box( 'box_2', 'Article with Image Top 2', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_2'));
    add_meta_box( 'box_3', 'Happening Now Position 1', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_3'));
    add_meta_box( 'box_4', 'Happening Now Position 2', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_4'));
    add_meta_box( 'box_5', 'Happening Now Position 3', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_5'));
    add_meta_box( 'box_6', 'Happening Now Position 4', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_6'));
    add_meta_box( 'box_7', 'Happening Now Position 5', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_7'));
    add_meta_box( 'box_8', 'Happening Now Position 6', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_8'));
    add_meta_box( 'box_9', 'Happening Now Position 7', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_9'));
    add_meta_box( 'box_10', 'Happening Now Position 8', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_10'));
    add_meta_box( 'box_11', 'Article with Image Bottom 1', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_11'));
    add_meta_box( 'box_12', 'Article with Image Bottom 2', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_12'));
    add_meta_box( 'box_13', 'Round Image Callout', 'cd_meta_box_callback', 'email', 'normal', 'high', array( 'box_id' => 'box_13'));
}

function cd_meta_box_callback( $post, $metabox )
{   
$values = get_post_custom( $post->ID ); 
$myId = $metabox['args']['box_id'];
global $this_box;
$this_box = $myId;
$selected = isset( $values[$this_box] ) ? esc_attr( $values[$this_box][0] ) : ”;
wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

$args = array( 'numberposts' => '20' );
		$recent_posts = wp_get_recent_posts( $args );
?>  
    <p> 
        <label for="<?php echo $this_box; ?>">Article Name</label>
        <select name="<?php echo $this_box; ?>" id="<?php echo $this_box; ?>">
            <!-- <option name="" value="" <?/*php selected( $selected, null, true );*/ ?>>None</option> -->
        	<?php
        	foreach( $recent_posts as $recent ){
        	echo '<option name="' . $recent["post_title"] . '" value="' . $recent["ID"] . '"';
        	$recent_post_id = $recent["ID"];
        	selected( $selected,  $recent_post_id, true );
        	echo '>' . $recent["post_title"] . '</option>';
        	}
        	?>
        </select>
    </p>
    <?php    
}

add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{   
    
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
    if( is_admin() ) {
        
// Make sure your data is set before trying to save it
    if( isset( $_POST['header_content']) ) update_post_meta( $post_id, 'header_content', esc_attr( $_POST['header_content'] ) );
    if( isset( $_POST['box_1']) ) update_post_meta( $post_id, 'box_1', esc_attr( $_POST['box_1'] ) );
    if( isset( $_POST['box_2']) ) update_post_meta( $post_id, 'box_2', esc_attr( $_POST['box_2'] ) );
    if( isset( $_POST['box_3']) ) update_post_meta( $post_id, 'box_3', esc_attr( $_POST['box_3'] ) );
    if( isset( $_POST['box_4']) ) update_post_meta( $post_id, 'box_4', esc_attr( $_POST['box_4'] ) );
    if( isset( $_POST['box_5']) ) update_post_meta( $post_id, 'box_5', esc_attr( $_POST['box_5'] ) );
    if( isset( $_POST['box_6']) ) update_post_meta( $post_id, 'box_6', esc_attr( $_POST['box_6'] ) );
    if( isset( $_POST['box_7']) ) update_post_meta( $post_id, 'box_7', esc_attr( $_POST['box_7'] ) );
    if( isset( $_POST['box_8']) ) update_post_meta( $post_id, 'box_8', esc_attr( $_POST['box_8'] ) );
    if( isset( $_POST['box_9']) ) update_post_meta( $post_id, 'box_9', esc_attr( $_POST['box_9'] ) );
    if( isset( $_POST['box_10']) ) update_post_meta( $post_id, 'box_10', esc_attr( $_POST['box_10'] ) );
    if( isset( $_POST['box_11']) ) update_post_meta( $post_id, 'box_11', esc_attr( $_POST['box_11'] ) );
    if( isset( $_POST['box_12']) ) update_post_meta( $post_id, 'box_12', esc_attr( $_POST['box_12'] ) );
    if( isset( $_POST['box_13']) ) update_post_meta( $post_id, 'box_13', esc_attr( $_POST['box_13'] ) );

    }     
}  

function load_utah_email_CPT_scripts() {
	//wp_enqueue_style( 'utah-grid-css', plugin_dir_url(__FILE__) .'css/utah-grid.css' );
	//wp_enqueue_script( 'utah-grid', plugin_dir_url(__FILE__) .'js/utah-grid.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'load_utah_email_CPT_scripts' );
?>