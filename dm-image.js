jQuery(document).ready(function($) {
	var formfield = null;
	$('#upload_image_button').click(function() 
		{ $('html').addClass('Image');
		formfield = $('#dm_mg_image').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true'); 
		return false;
	});
window.original_send_to_editor = window.send_to_editor; 
window.send_to_editor = function(html){
	var fileurl;

	if (formfield != null) {
		fileurl = $('img',html).attr('src');
		$('#dm_mg_image').val(fileurl); 
		tb_remove();
		$('html').removeClass('Image');
		formfield = null; 
	} else {
		window.original_send_to_editor(html); 
	}
  }; 
});