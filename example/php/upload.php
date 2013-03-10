<?php

/**
* Ajax Upload and Crop - upload.php
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

$file = $_FILES[$file_input_name];

// validate file
$validate_file = validate_file($file, $extensions, $max_file_size);

// if file extension and file size are ok
if($validate_file == 0) {

	$filename = md5(uniqid() . time()) .  '.' . pathinfo(basename( $file['name']), PATHINFO_EXTENSION);
	
	if(move_uploaded_file($file['tmp_name'], $upload_directory . $filename)) {
		@chmod($upload_directory . $filename, 0777);
		
		// resize image to: $big_width - You can set it in config.php
		resize_image($upload_directory . $filename, $big_width, $big_directory);
		@chmod($big_directory . $filename, 0777);
		
		echo json_encode(array('status' => 0, 'path' => str_replace('../', '', $big_directory) . $filename, 'width' => $big_width, 'height' => $big_height));
	}
} 
// if file extension or file size are invalid
else {
	echo json_encode(array('status' => $validate_file));
}


/*
 * Validate file extension and max size
 */
function validate_file($file, $extensions, $max_file_size) {

	$validate_extension = validate_extension($file['name'], $extensions);
	$validate_size = validate_size($file['size'], $max_file_size);
	
	if(!$validate_extension && !$validate_size) {
		return 3;
	} elseif(!$validate_extension && $validate_size) {
		return 1;
	} elseif($validate_extension && !$validate_size) {
		return 2;
	} else {
		return 0;
	}
}


/*
 * Validate uploaded file extension
 */
function validate_extension($filename, $extensions) {
	
    $ext_array = $extensions;
    $extension = strtolower(strrchr($filename,"."));
    $ext_count = count($ext_array);

	foreach ($ext_array as $value) {
		$first_char = substr($value,0,1);
			if ($first_char <> ".") {
				$extensions[] = ".".strtolower($value);
			} else {
				$extensions[] = strtolower($value);
			}
	}

	foreach ($extensions as $value) {
		if ($value == $extension) {
			$valid_extension = true;
		}
	}

	if ($valid_extension) {
		return true;
	} else {
		return false;
	}
}


/*
 * Validate uploaded file max size
 */
function validate_size($size, $max_file_size) {
	if($size <= $max_file_size) {
		return true;
	} else {
		return false;
	}
}
?>