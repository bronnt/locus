<?php
/*

Plugin Name: Locus - About Us Page Layout
Plugin UI: http://umc.utah.edu
Description: About Us Page template for Locus Realty
Version: 0.1
Author: Brian Thurber
Author URI: http://www.brianthurber.com
License: 

*/

/*---------------------------------
* Add a meta box to the UMC email generating custom post type. Reference http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
----------------------------------*/
add_action( 'init', 'create_about_post_type' );
function create_about_post_type() {
    register_post_type( 'about',
        array(
            'labels' => array(
                'name' => __( 'Layout About Us' ),
                'singular_name' => __( 'about' )
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
}
 /*
remove wisiwig and other features from about custom post type
 */
add_action('init', 'init_about_remove_support',100);
function init_about_remove_support(){
    $post_type = 'about';
    remove_post_type_support( $post_type, 'editor');
    remove_post_type_support( $post_type, 'comments');
    remove_post_type_support( $post_type, 'trackbacks');
    remove_post_type_support( $post_type, 'page-attributes');
    remove_post_type_support( $post_type, 'custom-fields');
    remove_post_type_support( $post_type, 'author');
}

add_action( 'add_meta_boxes', 'about_meta_box_add' );
function about_meta_box_add(){
    add_meta_box( 'box_1', 'First Employee', 'about_meta_box_callback', 'about', 'normal', 'high', array( 'box_id' => 'box_1'));
    add_meta_box( 'box_2', 'Second Employee', 'about_meta_box_callback', 'about', 'normal', 'high', array( 'box_id' => 'box_2'));
}

function my_admin_scripts() {    
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        //wp_register_script('my-upload', WP_PLUGIN_URL.'image-upload.js', array('jquery','media-upload','thickbox'));
        //wp_enqueue_script('my-upload');
        }

        function my_admin_styles() {
            wp_enqueue_style('thickbox');
        }

        // better use get_current_screen(); or the global $current_screen
        if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {

            add_action('admin_enqueue_scripts', 'my_admin_scripts');
            add_action('admin_enqueue_styles', 'my_admin_styles');
        }    

function about_meta_box_callback( $post, $metabox )
{
        $values = get_post_custom( $post->ID );
        $this_box = $metabox['args']['box_id'];
        $title_text = isset( $values[$this_box . '_title_text'] ) ? $values[$this_box . '_title_text'][0] : '';
        $body_text = isset( $values[$this_box . '_body_text'] ) ? $values[$this_box . '_body_text'][0] : '';
        $img_url = isset( $values[$this_box . '_img_url'] ) ? $values[$this_box . '_img_url'][0] : '';
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
        
        ?>
        <script>
            jQuery(document).ready( function( jQuery ) {
                //var imageURL = '<?php echo $this_box . "_img_url"; ?>';
                //var imageButtonId = '<?php echo $this_box . "_img_button"; ?>';
                jQuery('#<?php echo $this_box . "_img_button"; ?>').click(function() {
                    formfield = jQuery('#upload_image').attr('name');
                    tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
                    return false;
                });

                window.send_to_editor = function(html) {
                    imgurl = jQuery('img',html).attr('src');
                    jQuery('#<?php echo $this_box . "_img_url"; ?>').val(imgurl);
                    tb_remove();
                }
            });
        </script>  

            <p>
                <label for="<?php echo $this_box . '_title_text'; ?>">Name</label>
                <input type="textarea" name="<?php echo $this_box . '_title_text'; ?>" id="<?php echo $this_box . '_title_text'; ?>" value="<?php echo $title_text; ?>" />
            </p>
           <p>
                <label for="<?php echo $this_box . '_body_text'; ?>">Description</label>
                <input type="textarea" name="<?php echo $this_box . '_body_text'; ?>" id="<?php echo $this_box . '_body_text'; ?>" value="<?php echo $body_text; ?>" />
            </p>
            <input id="<?php echo $this_box . '_img_url'; ?>" type="text" size="36" name="<?php echo $this_box . '_img_url'; ?>" value="<?php echo $img_url; ?>" />
            <input id="<?php echo $this_box . "_img_button"; ?>" class="button button-primary button-large" type="button" value="Upload Image" />

    <?php         
}
?>

<?php  
add_action( 'save_post', 'about_meta_box_save' );
function about_meta_box_save( $post_id )
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

    if( isset( $_POST['box_1_title_text'] ) ) update_post_meta( $post_id, 'box_1_title_text', wp_kses( $_POST['box_1_title_text'], $allowed ) ); 
    if( isset( $_POST['box_1_body_text'] ) ) update_post_meta( $post_id, 'box_1_body_text', wp_kses( $_POST['box_1_body_text'], $allowed ) ); 
    if( isset( $_POST['box_1_img_url'] ) ) update_post_meta( $post_id, 'box_1_img_url', wp_kses( $_POST['box_1_img_url'], $allowed ) ); 
    if( isset( $_POST['box_2_title_text'] ) ) update_post_meta( $post_id, 'box_2_title_text', wp_kses( $_POST['box_2_title_text'], $allowed ) ); 
    if( isset( $_POST['box_2_body_text'] ) ) update_post_meta( $post_id, 'box_2_body_text', wp_kses( $_POST['box_2_body_text'], $allowed ) ); 
    if( isset( $_POST['box_2_img_url'] ) ) update_post_meta( $post_id, 'box_2_img_url', wp_kses( $_POST['box_2_img_url'], $allowed ) ); 
    }     
}  
?>