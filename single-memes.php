<?php get_header()?>

<div id="left">
	<div id="memessinglepost" style="width:300px; position:relative; top:10px;">
	<?php while(have_posts()): the_post()?>
		
		<?php
			$dm_mg_btimage = get_post_meta( $post->ID, '_dm_mg_btimage', true );
			$dm_mg_bttitletext = get_post_meta( $post->ID, '_dm_mg_bttitletext', true );
			$dm_mg_btptext = get_post_meta( $post->ID, '_dm_mg_btptext', true );

			$dm_mg_memetype = get_post_meta($post->ID,'_dm_mg_memetype',true);

			$dm_mg_twbptext = get_post_meta( $post->ID, '_dm_mg_twbptext', true );
			$dm_mg_twbimage = get_post_meta( $post->ID, '_dm_mg_twbimage', true );
		?>
		
		<div id="dm_mg_finishedimage" style="height:300px">

			<?php 
			echo $dm_mg_memetype;
			  if ($dm_mg_memetype==brotips) {
			  	
			  ?>
			<div id="dm_mg_bttitletext" style="color:gray;position: relative;top:10px;left:40px;font-size: 28pt; z-index:10;">
				<?php echo $dm_mg_bttitletext; ?>
			</div>
			<div id="dm_mg_btptext" style="color:white; position: relative;top:20px;left:15px;font-size: 18pt;z-index:10;width:260px;">
				<?php echo $dm_mg_btptext; ?>
			</div>
			<div id="dm_mg_btimage" style="position:absolute; top:0px;">
				<img src="<?php echo $dm_mg_btimage ?>">
			</div>
			<?php
			}
			if ($dm_mg_memetype==textwithbackground) {
			?>
			<div id="dm_mg_twbptext" style="color:white; position: relative;top:20px;left:15px;font-size: 18pt;z-index:10;width:260px;">
				<?php echo $dm_mg_twbptext; ?>
			</div>
			<div id="dm_mg_twbimage" style="position:absolute; top:0px;">
				<img src="<?php echo $dm_mg_twbimage ?>">
			</div>
			<?php
			}
			?>
		</div>
	<?php 
	$dm_mg_memepermalink =  get_permalink();
	$dm_mg_memepermalinktrim = substr($dm_mg_memepermalink,-7,-1);

	?>
	<?php endwhile;?>
	<?php
	include(plugin_dir_path(__FILE__).'lib/GrabzItClient.class.php');
	$grabzIt = new GrabzItClient("NjYxZGIyNzRlYzY2NDhjMzhkMWU3MDc1MjlmODEyNDc=", "PD9QNwUaP39NNldaAXE/ED8jPz8/Pz8/Pz9QLD8KPxg=");
	$memespath = home_url() . '/memes/'.$dm_mg_memepermalinktrim.'/';
	
	$grabzIt->SetImageOptions($memespath,$dm_mg_memepermalinktrim,null,-1,-1,-1,"jpg",null,"dm_mg_finishedimage"); 
	
	$handlerurl = content_url().'/plugins/meme-generator/lib/handler.php';
	$grabzIt->Save($handlerurl);
		

	$fileurlpath = content_url().'/plugins/meme-generator/memes/'.$dm_mg_memepermalinktrim;
	?>
	<br>
	<br>
	<a href="<?php echo $fileurlpath ?>" target="_blank">Click here for file<a/>
	</div>

</div>

<?php get_footer()?>