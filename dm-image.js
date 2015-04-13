jQuery(document).ready(function($) {
	var formfield = null;
	var formfieldtwb = null;

	$('#upload_image_button').click(function() 
		{ $('html').addClass('Image');
		formfield = $('#dm_mg_btimage').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true'); 
		return false;
	});

	$('#upload_image_buttontwb').click(function() 
		{ $('html').addClass('Image');
		formfieldtwb = $('#dm_mg_twbimage').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true'); 
		return false;
	});


window.original_send_to_editor = window.send_to_editor; 
window.send_to_editor = function(html){
	var fileurl;

	if (formfield != null) {
		fileurl = $('img',html).attr('src');
		$('#dm_mg_btimage').val(fileurl); 
		tb_remove();
		$('html').removeClass('Image');
		formfield = null; 
	} else {
		window.original_send_to_editor(html); 
	}

	if (formfieldtwb != null) {
		fileurl = $('img',html).attr('src');
		$('#dm_mg_twbimage').val(fileurl); 
		tb_remove();
		$('html').removeClass('Image');
		formfieldtwb = null; 
	} else {
		window.original_send_to_editor(html); 
	}

  }; 
});