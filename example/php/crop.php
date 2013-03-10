<?php

/**
* Ajax Upload and Crop - crop.php
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

// configuration file
require_once 'config.php';

// resize function
require_once 'resize.php';

// Original image
$filename = basename($_POST['filename']);

// if file exists
if(file_exists($big_directory . $filename)) {
	// Get dimensions of the original image
	list($current_width, $current_height) = getimagesize($big_directory . $filename);

	$width = $big_width;
	$ratio = $current_width / $width;

	$left = round(intval($_POST['x']) * $ratio);
	$top = round(intval($_POST['y']) * $ratio);

	$crop_width = round($_POST['width'] * $ratio);
	$crop_height = round($_POST['height'] * $ratio);
	
	// Resample the image
	$canvas = imagecreatetruecolor($crop_width, $crop_height);
	$current_image = imagecreatefromjpeg($big_directory . $filename);
	imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
	imagejpeg($canvas, $crop_directory . $filename, 100);

	$original_image_path = str_replace('../', '', $big_directory) . $filename;
	$thumb_image_path = str_replace('../', '', $crop_directory) . $filename;
	
	
	// create thumb
	resize_image($crop_directory . $filename, $thumb_width);
	
	echo json_encode(array('status' => 0, 'filename' => $filename, 'original' => $original_image_path, 'thumb' => $thumb_image_path));
} 
// if file doesn't exists
else {
	echo json_encode(array('status' => 1));
}
?>