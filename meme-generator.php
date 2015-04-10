<?php
/*
Plugin Name: Meme Generator	
Description: This plugin creates a Custom Post Type called Memes and allows a user to create memes
Version: 1.0
Author: Daniel Martinez
License: GPLv2
*/


add_action( 'init', 'dm_mg_register_meme_generator' );


function dm_mg_register_meme_generator() {
  register_post_type( 'memes',
    array(
      'labels' => array('name' => __( 'Memes' ),'singular_name' => __( 'Meme' )),
      'public' => true,
      'has_archive' => true,
      'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail'),
      'taxonomies' => array('category'),
    )
  );
}



add_action( 'add_meta_boxes', 'dm_mg_create' );
function dm_mg_create() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    add_meta_box( 'dm-meta', 'Meme Fields', 'dm_mg_function', 'memes','normal', 'high' ); 
}

function dm_mg_function( $post ) {
$dm_mg_image = get_post_meta( $post->ID, '_dm_mg_image', true );
$dm_mg_titletext = get_post_meta( $post->ID, '_dm_mg_titletext', true );
$dm_mg_ptext = get_post_meta( $post->ID, '_dm_mg_ptext', true );

?>
<p>Title Text: <input type="text" name="dm_mg_titletext" value="<?php echo esc_attr( $dm_mg_titletext ); ?>" /></p> 
<p>Paragraph Text: <input type="text" name="dm_mg_ptext" value="<?php echo esc_attr( $dm_mg_ptext ); ?>" /></p> 
Background<input id="dm_mg_image" type="text" size="45" name="dm_mg_image" value="<?php echo esc_url( $dm_mg_image ); ?>" /> <input id="upload_image_button" type="button" value="Media Library Image" class="button-secondary" />
<br/> Enter an image URL or use an image from the Media Library 
<?php
}



add_action('admin_print_scripts-post.php', 'dm_mg_image_admin_scripts'); 
add_action('admin_print_scripts-post-new.php', 'dm_mg_image_admin_scripts');

function dm_mg_image_admin_scripts() { 
	wp_enqueue_script( 'dm-image-upload',
	plugins_url( '/meme-generator/dm-image.js' ), 
	array( 'jquery','media-upload','thickbox' ) );
}

add_action('admin_print_styles-post.php', 'dm_mg_image_admin_styles'); 
add_action('admin_print_styles-post-new.php', 'dm_mg_image_admin_styles');
function dm_mg_image_admin_styles() { 
	wp_enqueue_style( 'thickbox' );
}


add_action( 'save_post', 'dm_mg_save_meta' );

function dm_mg_save_meta( $post_id ) {

if ( isset( $_POST['dm_mg_titletext'] ) ) {
update_post_meta( $post_id, '_dm_mg_titletext',
strip_tags( $_POST['dm_mg_titletext'] ) ); 
}
if ( isset( $_POST['dm_mg_ptext'] ) ) {
update_post_meta( $post_id, '_dm_mg_ptext',
strip_tags( $_POST['dm_mg_ptext'] ) ); 
}

if ( isset( $_POST['dm_mg_image'] ) ) {
//save the metadata
update_post_meta( $post_id, '_dm_mg_image',
	esc_url_raw( $_POST['dm_mg_image'] ) );
}


}

function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'memes') {
          $single_template = dirname( __FILE__ ) . '/single-memes.php';
          
	function memes_scripts(){
		wp_enqueue_style('style-name',plugins_url( 'css/styles-memes.css' , __FILE__ ));
	}
	add_action('wp_enqueue_style','memes_scripts');
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );