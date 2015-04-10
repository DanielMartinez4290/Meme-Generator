<?php get_header()?>

<div id="left">
	<div id="memessinglepost" style="width:300px; position:relative; top:10px;">
	<?php while(have_posts()): the_post()?>
		
		<?php
			$dm_mg_image = get_post_meta( $post->ID, '_dm_mg_image', true );
			$dm_mg_titletext = get_post_meta( $post->ID, '_dm_mg_titletext', true );
			$dm_mg_ptext = get_post_meta( $post->ID, '_dm_mg_ptext', true );
			//echo plugins_url( 'css/styles-memes.css' , __FILE__ );
		?>
		
		<div id="dm_mg_finishedimage" style="height:300px">
			<div id="dm_mg_titletext" style="color:gray;position: relative;top:10px;left:40px;font-size: 28pt; z-index:10;">
				<?php echo $dm_mg_titletext; ?>
			</div>
			<div id="dm_mg_ptext" style="color:white; position: relative;top:20px;left:15px;font-size: 18pt;z-index:10;width:260px;">
				<?php echo $dm_mg_ptext; ?>
			</div>
			<div id="dm_mg_image" style="position:absolute; top:0px;">
				<img src="<?php echo $dm_mg_image ?>">
			</div>
		</div>
	<?php 
	$dm_mg_memepermalink =  get_permalink();
	//echo $dm_mg_memepermalink;
	$dm_mg_memepermalinktrim = substr($dm_mg_memepermalink,-7,-1);

	?>
	<?php endwhile;?>
	<?php
	//error_reporting(-1);
	//ini_set('display_errors', 'On');
	include(plugin_dir_path(__FILE__).'lib/GrabzItClient.class.php');
	$grabzIt = new GrabzItClient("NjYxZGIyNzRlYzY2NDhjMzhkMWU3MDc1MjlmODEyNDc=", "PD9QNwUaP39NNldaAXE/ED8jPz8/Pz8/Pz9QLD8KPxg=");
	$memespath = home_url() . '/memes/'.$dm_mg_memepermalinktrim.'/';
	$grabzIt->SetImageOptions($memespath,null,null,null,300,300,"jpg",null,"dm_mg_finishedimage"); 
	$filepath = plugin_dir_path(__FILE__). 'memes/'.$dm_mg_memepermalinktrim.'.jpg';
	$grabzIt->SaveTo($filepath);

	$fileurlpath = content_url().'/plugins/meme-generator/memes/'.$dm_mg_memepermalinktrim.'.jpg';
	?>
	<br>
	<br>
	<a href="<?php echo $fileurlpath ?>" target="_blank">Click here for file<a/>
	</div>

</div>

<?php get_footer()?>