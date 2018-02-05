<?php
// Function to add text water mark over image
function addTextWatermark($src, $watermark, $save=NULL) { 
 list($width, $height) = getimagesize($src);
 $image_color = imagecreatetruecolor($width, $height);
 $image = imagecreatefromjpeg($src);
 imagecopyresampled($image_color, $image, 0, 0, 0, 0, $width, $height, $width, $height); 
 $txtcolor = imagecolorallocate($image_color, 255, 255, 255);
 $font = 'MONOFONT.TTF';
 $font_size = 50;
 imagettftext($image_color, $font_size, 0, 50, 150, $txtcolor, $font, $watermark);
 if ($save<>'') {
	imagejpeg ($image_color, $save, 100); 
 } else {
	 header('Content-Type: image/jpeg');
	 imagejpeg($image_color, null, 100);
 }
 imagedestroy($image); 
 imagedestroy($image_color); 
}

// Function to add image watermark over images
function addImageWatermark($SourceFile, $WaterMark, $DestinationFile=NULL, $opacity) {
 $main_img = $SourceFile; 
 $watermark_img = $WaterMark; 
 $padding = 5; 
 $opacity = $opacity;
 // create watermark
 $watermark = imagecreatefrompng($watermark_img); 
 $image = imagecreatefromjpeg($main_img); 
 if(!$image || !$watermark) die("Error: main image or watermark image could not be loaded!");
 $watermark_size = getimagesize($watermark_img);
 $watermark_width = $watermark_size[0]; 
 $watermark_height = $watermark_size[1]; 
 $image_size = getimagesize($main_img); 
 $dest_x = $image_size[0] - $watermark_width - $padding; 
 $dest_y = $image_size[1] - $watermark_height - $padding;
 imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $opacity);
 if ($DestinationFile<>'') {
	imagejpeg($image, $DestinationFile, 100); 
 } else {
	 header('Content-Type: image/jpeg');
	 imagejpeg($image);
 }
 imagedestroy($image); 
 imagedestroy($watermark); 
}

?>
  