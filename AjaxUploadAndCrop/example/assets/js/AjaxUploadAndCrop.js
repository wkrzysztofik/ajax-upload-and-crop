/**
* Ajax Upload and Crop - AjaxUploadAndCrop.js
*
* 
*
* Copyright (C) 2012  Starfield Studio (www.starfieldstudio.pl)
*
*
* @package     AjaxUploadAndCrop
* @author      Starfield Studio
* @copyright   2012 Starfield Studio
* @link        http://www.starfieldstudio.pl
* @version     1.0
*/

$(document).ready(function() {

	// submit upload form
	$('.btn_upload').click(function() { 
	
		if($('#image').val()) {
			$(this).hide();
			$('.loader').show();

			$('#upload').ajaxSubmit({'success' : showUploadResponse, 'dataType' : 'json'}); 
		}

		return false; 
	});
	
	
	// submit crop form
	$('.btn_crop').click(function() { 		
		
		$(this).hide();
		$('#crop').ajaxSubmit({'success' : showCropResponse, 'dataType' : 'json'}); 
 
		return false; 
	});
	
	
	// submit result data form (only example)
	$('.btn_save').click(function() { 		
		
		$(this).hide();
		$('#save').ajaxSubmit({'success' : showSaveResponse, 'dataType' : 'json'}); 
 
		return false; 
	});
	
	
	// actiate submit button after choose file to upload
	$('#image').change(function() {
		$('.btn_upload').removeClass('disabled');
	});

});


/*
 * Get coords to crop (jCrop Plugin)
 */
function getCoords(c) {
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#width').val(c.w);
	$('#height').val(c.h);
};


/*
 * Clear coords (jCrop Plugin)
 */
function clearCoords() {
	$('#coords input').val('');
};


/*
 * Response after upload file
 */
function showUploadResponse(response) {
	if(response.status == 0) {
		$('#upload').fadeOut();
		
		$('.image_wrapper').html('<img src="' + response.path + '" alt="" />');
		
		$('.filename').val(response.path);
		
		$('.image_wrapper img').Jcrop({
			onChange:   getCoords,
			onSelect:   getCoords,
			onRelease:  clearCoords,
			setSelect:   [ 10, 10, 50, 100 ],
			aspectRatio: response.width / response.height
		});
		
		$('.loader').fadeOut();
		$('#crop').fadeIn();
	} else {
		$('.loader').hide();
		$('.btn_upload').show();
		
		// file extension is invalid
		if(response.status == 1) {
			alert('extension error');
		} 
		// file size is too large
		else if(response.status == 2) {
			alert('size error');
		} 
		// file extension and file size are invalid
		else if(response.status == 3) {
			alert('extension and size error');
		}
	}
};


/*
 * Response after crop image
 */
function showCropResponse(response) {
	// if file exists
	if(response.status != 1) {
		$('#crop').hide();
		
		$('#filename').val(response.filename);
	
		$('#big_preview').html('<img src="' + response.original + '" alt="" />');
		$('#big_path').val(response.original);
		
		$('#thumb_preview').html('<img src="' + response.thumb + '" alt="" />');
		$('#thumb_path').val(response.thumb);
		
		$('#save').fadeIn();
	} else {
		alert('file dooesn\'t exist');
	}
};


/*
 * Response after send data (last step) - this is only example
 */
function showSaveResponse(response) {
	console.log(response);
}