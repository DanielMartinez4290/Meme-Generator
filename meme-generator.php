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
      'supports' => array( 'title'),
      'taxonomies' => array('category'),
    )
  );
}



add_action( 'add_meta_boxes', 'dm_mg_create' );
function dm_mg_create() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    add_meta_box( 'dm-meta', 'Meme Generator', 'dm_mg_function', 'memes','normal', 'high' ); 
}

function dm_mg_function( $post ) {
$dm_mg_btimage = get_post_meta( $post->ID, '_dm_mg_btimage', true );
$dm_mg_bttitletext = get_post_meta( $post->ID, '_dm_mg_bttitletext', true );
$dm_mg_btptext = get_post_meta( $post->ID, '_dm_mg_btptext', true );

$dm_mg_memetype = get_post_meta($post->ID,'_dm_mg_memetype',true);

$dm_mg_twbptext = get_post_meta( $post->ID, '_dm_mg_twbptext', true );
$dm_mg_twbimage = get_post_meta( $post->ID, '_dm_mg_twbimage', true );

?>


<h2>Bro Tips  <input id="brotips" type="checkbox" name="dm_mg_memetype" value="brotips"></h2>
<p>Title Text: <input size="25" type="text" name="dm_mg_bttitletext" value="<?php echo esc_attr( $dm_mg_bttitletext ); ?>" /></p> 
<p>Paragraph Text: <input size="55" type="text" name="dm_mg_btptext" value="<?php echo esc_attr( $dm_mg_btptext ); ?>" /></p> 
Background<input id="dm_mg_btimage" type="text" size="45" name="dm_mg_btimage" value="<?php echo esc_url( $dm_mg_btimage ); ?>" /> <input id="upload_image_button" type="button" value="Media Library Image" class="button-secondary" />
<br> Enter an image URL or use an image from the Media Library
<br>
<h2>Text With Background  <input id="textwithbackground" type="checkbox" name="dm_mg_memetype" value="textwithbackground"></h2>
<p>Text: <input size="55" type="text" name="dm_mg_twbptext" value="<?php echo esc_attr( $dm_mg_twbptext ); ?>" /></p> 

Background<input id="dm_mg_twbimage" type="text" size="45" name="dm_mg_twbimage" value="<?php echo esc_url( $dm_mg_twbimage ); ?>" /> <input id="upload_image_buttontwb" type="button" value="Media Library Image" class="button-secondary" />
<br/> Enter an image URL or use an image from the Media Library

<script>
window.onload=function checkboxes(){
if(<?php echo $dm_mg_memetype ?>== brotips){
document.getElementById("brotips").checked = true;
}
if(<?php echo $dm_mg_memetype ?>==textwithbackground){
document.getElementById("textwithbackground").checked = true;
}
}
</script>
<?php
}



add_action('admin_print_scripts-post.php', 'dm_mg_btimage_admin_scripts'); 
add_action('admin_print_scripts-post-new.php', 'dm_mg_btimage_admin_scripts');

function dm_mg_btimage_admin_scripts() { 
	wp_enqueue_script( 'dm-image-upload',
	plugins_url( '/meme-generator/dm-image.js' ), 
	array( 'jquery','media-upload','thickbox' ) );
}

add_action('admin_print_styles-post.php', 'dm_mg_btimage_admin_styles'); 
add_action('admin_print_styles-post-new.php', 'dm_mg_btimage_admin_styles');
function dm_mg_btimage_admin_styles() { 
	wp_enqueue_style( 'thickbox' );
}


add_action( 'save_post', 'dm_mg_save_meta' );

function dm_mg_save_meta( $post_id ) {

if ( isset( $_POST['dm_mg_memetype'] ) ) {
update_post_meta( $post_id, '_dm_mg_memetype',
strip_tags( $_POST['dm_mg_memetype'] ) ); 
}

if ( isset( $_POST['dm_mg_bttitletext'] ) ) {
update_post_meta( $post_id, '_dm_mg_bttitletext',
strip_tags( $_POST['dm_mg_bttitletext'] ) ); 
}
if ( isset( $_POST['dm_mg_btptext'] ) ) {
update_post_meta( $post_id, '_dm_mg_btptext',
strip_tags( $_POST['dm_mg_btptext'] ) ); 
}

if ( isset( $_POST['dm_mg_btimage'] ) ) {
update_post_meta( $post_id, '_dm_mg_btimage',
	esc_url_raw( $_POST['dm_mg_btimage'] ) );
}

if ( isset( $_POST['dm_mg_twbptext'] ) ) {
update_post_meta( $post_id, '_dm_mg_twbptext',
strip_tags( $_POST['dm_mg_twbptext'] ) ); 
}

if ( isset( $_POST['dm_mg_twbimage'] ) ) {
update_post_meta( $post_id, '_dm_mg_twbimage',
  esc_url_raw( $_POST['dm_mg_twbimage'] ) );
}


}

function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'memes') {
          $single_template = dirname( __FILE__ ) . '/single-memes.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );