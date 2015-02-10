<?php
/*

Plugin Name: Locus - Home Page Layout
Plugin UI: http://umc.utah.edu
Description: Home Page template for Locus Realty
Version: 0.1
Author: Brian Thurber
Author URI: http://www.brianthurber.com
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
    register_post_type( 'homepage',
        array(
            'labels' => array(
                'name' => __( 'Layout Home Pg' ),
                'singular_name' => __( 'homepage' )
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
    /*add_image_size( 'email', 262 ); 
    add_image_size( 'email-header', 639, 9999 );*/
}

 /*
remove wisiwig and other features from homepage custom post type
 */
add_action('init', 'init_homepage_remove_support',100);
function init_homepage_remove_support(){
    $post_type = 'homepage';
    remove_post_type_support( $post_type, 'editor');
    remove_post_type_support( $post_type, 'comments');
    remove_post_type_support( $post_type, 'trackbacks');
    remove_post_type_support( $post_type, 'page-attributes');
    remove_post_type_support( $post_type, 'custom-fields');
    remove_post_type_support( $post_type, 'author');

    if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(
        array(
            'label' => 'Small Top Left Image',
            'id' => 'top-left',
            'post_type' => 'homepage'
        )
    );
    new MultiPostThumbnails(
        array(
            'label' => 'Small Bottom Left Image',
            'id' => 'bottom-left',
            'post_type' => 'homepage'
        )
    );
    new MultiPostThumbnails(
        array(
            'label' => 'Tall Right Side Image',
            'id' => 'tall',
            'post_type' => 'homepage'
        )
    );
}

}



add_action( 'add_meta_boxes', 'home_page_meta_box_add' );
function home_page_meta_box_add()
{
    add_meta_box( 'box_1', 'Main Paragraph Title', 'home_page_meta_box_callback', 'homepage', 'normal', 'high', array( 'box_id' => 'box_1'));
    add_meta_box( 'box_2', 'Main Paragraph Body Text', 'home_page_meta_box_callback', 'homepage', 'normal', 'high', array( 'box_id' => 'box_2'));
    add_meta_box( 'box_3', 'Happening Now Position 1', 'home_page_meta_box_callback', 'homepage', 'normal', 'high', array( 'box_id' => 'box_3'));
    add_meta_box( 'box_4', 'Happening Now Position 2', 'home_page_meta_box_callback', 'homepage', 'normal', 'high', array( 'box_id' => 'box_4'));
    /*add_meta_box( 'box_5', 'Happening Now Position 3', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_5'));
    add_meta_box( 'box_6', 'Happening Now Position 4', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_6'));
    add_meta_box( 'box_7', 'Happening Now Position 5', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_7'));
    add_meta_box( 'box_8', 'Happening Now Position 6', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_8'));
    add_meta_box( 'box_9', 'Happening Now Position 7', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_9'));
    add_meta_box( 'box_10', 'Happening Now Position 8', 'home_page_meta_box_callback', 'home_page', 'normal', 'high', array( 'box_id' => 'box_10'));*/
}

function home_page_meta_box_callback( $post, $metabox )
{   
        $values = get_post_custom( $post->ID );
        $this_box = $metabox['args']['box_id'];
        $text = isset( $values[$this_box . '_text'] ) ? $values[$this_box . '_text'][0] : '';
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
        ?>  
            <p>
                <label for="<?php echo $this_box . '_text'; ?>">Text</label>
                <textarea class="widefat" cols="50" rows="4" name="<?php echo $this_box . '_text'; ?>" id="<?php echo $this_box . '_text'; ?>" value="<?php echo $text; ?>"><?php echo $text; ?></textarea>
            </p>
    <?php    
}

add_action( 'save_post', 'home_page_meta_box_save' );
function home_page_meta_box_save( $post_id )
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
    if( isset( $_POST['box_1_text'] ) ) update_post_meta( $post_id, 'box_1_text', wp_kses( $_POST['box_1_text'], $allowed ) );    
    if( isset( $_POST['box_2_text'] ) ) update_post_meta( $post_id, 'box_2_text', wp_kses( $_POST['box_2_text'], $allowed ) );
    if( isset( $_POST['box_3_text'] ) ) update_post_meta( $post_id, 'box_3_text', wp_kses( $_POST['box_3_text'], $allowed ) );    
    if( isset( $_POST['box_4_text'] ) ) update_post_meta( $post_id, 'box_4_text', wp_kses( $_POST['box_4_text'], $allowed ) );
    if( isset( $_POST['box_5_text'] ) ) update_post_meta( $post_id, 'box_5_text', wp_kses( $_POST['box_5_text'], $allowed ) );    
    if( isset( $_POST['box_6_text'] ) ) update_post_meta( $post_id, 'box_6_text', wp_kses( $_POST['box_6_text'], $allowed ) );
    if( isset( $_POST['box_7_text'] ) ) update_post_meta( $post_id, 'box_7_text', wp_kses( $_POST['box_7_text'], $allowed ) );    
    if( isset( $_POST['box_8_text'] ) ) update_post_meta( $post_id, 'box_8_text', wp_kses( $_POST['box_8_text'], $allowed ) );
    if( isset( $_POST['box_9_text'] ) ) update_post_meta( $post_id, 'box_9_text', wp_kses( $_POST['box_9_text'], $allowed ) );    
    if( isset( $_POST['box_10_text'] ) ) update_post_meta( $post_id, 'box_10_text', wp_kses( $_POST['box_10_text'], $allowed ) );
    }     
}  

function load_locus_home_page_CPT_scripts() {
    //wp_enqueue_style( 'utah-grid-css', plugin_dir_url(__FILE__) .'css/utah-grid.css' );
    //wp_enqueue_script( 'utah-grid', plugin_dir_url(__FILE__) .'js/utah-grid.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'load_locus_home_page_CPT_scripts' );
?>