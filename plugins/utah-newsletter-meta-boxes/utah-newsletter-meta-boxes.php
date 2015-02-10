<?php
/*

Plugin Name: Utah - Newsletter Meta Boxes
Plugin UI: http://umc.utah.edu
Description: Enable this plugin to add custom meta boxes to U of U newsletter sites
Version: 0.1
Author: Brian Thurber
Author URI: http://umc.utah.edu
License: 

*/

/*---------------------------------
* Add a meta box to the UMC email generating custom post type. Reference http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
----------------------------------*/
add_action( 'init', 'create_newsletter_post_type' );
function create_newsletter_post_type() {
    register_post_type( 'newsletter',
        array(
            'labels' => array(
                'name' => __( 'Newsletter' ),
                'singular_name' => __( 'newsletter' )
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
add_action('init', 'init_newsletter_remove_support',100);
function init_newsletter_remove_support(){
    $post_type = 'newsletter';
    remove_post_type_support( $post_type, 'editor');
    remove_post_type_support( $post_type, 'comments');
    remove_post_type_support( $post_type, 'trackbacks');
    remove_post_type_support( $post_type, 'page-attributes');
    remove_post_type_support( $post_type, 'custom-fields');
    remove_post_type_support( $post_type, 'author');
    remove_post_type_support( $post_type, 'revisions');
}

add_action( 'add_meta_boxes', 'newsletter_meta_box_add' );
function newsletter_meta_box_add(){
    add_meta_box( 'primary', 'Primary Category', 'newsletter_meta_box_callback', 'newsletter', 'normal', 'high', array( 'box_id' => 'primary'));
    add_meta_box( 'happening', 'Happening Now', 'newsletter_meta_box_callback', 'newsletter', 'normal', 'high', array( 'box_id' => 'happening'));
    add_meta_box( 'subtitle', 'Subtitle', 'newsletter_meta_box_callback', 'newsletter', 'normal', 'high', array( 'box_id' => 'subtitle'));
    add_meta_box( 'student', 'Student Excerpt', 'newsletter_meta_box_callback', 'new sletter', 'normal', 'high', array( 'box_id' => 'student'));
}

function newsletter_meta_box_callback( $post, $metabox )
{
        $values = get_post_custom( $post->ID );
        $this_box = $metabox['args']['box_id'];
        $text = isset( $values[$this_box . '_text'] ) ? $values[$this_box . '_text'][0] : '';
        $selected = isset( $values[$this_box . '_select'] ) ? esc_attr( $values[$this_box . '_select'][0] ) : '';
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
        
        ?>  
            <p>
                <label for="<?php echo $this_box . '_text'; ?>">Text Label</label>
                <input type="textarea" name="<?php echo $this_box . '_text'; ?>" id="<?php echo $this_box . '_text'; ?>" value="<?php echo $text; ?>" />
            </p>
            <p> 
                <label for="<?php echo $this_box . '_select'; ?>">Category</label>
                 <select name="<?php echo $this_box . '_select'; ?>" id="<?php echo $this_box . '_select'; ?>">
                    <?php
                        $categories = get_categories();

                        foreach ($categories as $category) {
                        $name = $category->cat_name; 
                        $id = $category->cat_ID;
                        $niceName = $category->category_nicename;
                        $option = '<option name="'.$name.'" value="'.$name.'" '.selected( $selected,  $name ).' >';
                        $option .= $name;
                        $option .= '</option>';
                        echo $option;
                      }
                      ?>
                </select>  
                <pre><?php// var_dump($categories)?> </pre>           
            </p> 
    <?php      
}


add_action( 'save_post', 'newsletter_meta_box_save' );
function newsletter_meta_box_save( $post_id )
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

    if( isset( $_POST['primary_text'] ) ) update_post_meta( $post_id, 'primary_text', wp_kses( $_POST['primary_text'], $allowed ) ); 
    if( isset( $_POST['primary_select']) ) update_post_meta( $post_id, 'primary_select', esc_attr( $_POST['primary_select'] ) );
    if( isset( $_POST['happening_text'] ) ) update_post_meta( $post_id, 'happening_text', wp_kses( $_POST['happening_text'], $allowed ) ); 
    if( isset( $_POST['happening_select']) ) update_post_meta( $post_id, 'happening_select', esc_attr( $_POST['happening_select'] ) );
    if( isset( $_POST['subtitle_text'] ) ) update_post_meta( $post_id, 'subtitle_text', wp_kses( $_POST['subtitle_text'], $allowed ) ); 
    if( isset( $_POST['subtitle_select']) ) update_post_meta( $post_id, 'subtitle_select', esc_attr( $_POST['subtitle_select'] ) );
    if( isset( $_POST['student_text'] ) ) update_post_meta( $post_id, 'student_text', wp_kses( $_POST['student_text'], $allowed ) ); 
    if( isset( $_POST['student_select']) ) update_post_meta( $post_id, 'student_select', esc_attr( $_POST['student_select'] ) );
    }     
}  
?>