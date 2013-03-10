<?php

/**
* Ajax Upload and Crop - resize.php
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


/*
 * $file - src_file, $width - output image width, $output_directory - file output directory (if null, file is overwrited)
 */
function resize_image($file, $width, $output_directory = null) {
	// Set the path to the image to resize
	$input_image = $file;
	// Get the size of the original image into an array
	$size = getimagesize( $input_image );
	// Set the new width of the image
	$thumb_width = $width;
	// Calculate the height of the new image to keep the aspect ratio
	$thumb_height = ( int )(( $thumb_width/$size[0] )*$size[1] );
	// Create a new true color image in the memory
	$thumbnail = ImageCreateTrueColor( $thumb_width, $thumb_height );
	// Create a new image from file 
	$src_img = ImageCreateFromJPEG( $input_image );
	// Create the resized image
	ImageCopyResampled( $thumbnail, $src_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $size[0], $size[1] );
	if(is_null($output_directory)) {
		// Overwrite changed image
		ImageJPEG( $thumbnail, $file , 100);
	} else {
		// Save the image as new file
		ImageJPEG( $thumbnail, $output_directory . basename($file) , 100);
	}
	// Clear the memory of the tempory image 
	ImageDestroy( $thumbnail );
}
?>