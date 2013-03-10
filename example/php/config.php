<?php
/**
* Ajax Upload and Crop - config.php
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


// FILE INPUT NAME
$file_input_name = 'image';

// ALLOWED FILE EXTENSIONS
$extensions = array(".png",".jpg",".jpeg",".bmp");

// MAX ALLOWED FILE SIZE
$max_file_size = 5000000;

// ORIGINAL IMAGES UPLOAD DIRECTORY
$upload_directory = '../uploads/original/';

// BIG IMAGES UPLOAD DIRECTORY
$big_directory = '../uploads/big/';

// THUMBS UPLOAD DIRECTORY
$crop_directory = '../uploads/thumb/';

// BIG IMAGES WIDTH
$big_width = 600;

// BIG IMAGES HEIGHT
$big_height = 400;

// THUMBS WIDTH
$thumb_width = 200;
?>