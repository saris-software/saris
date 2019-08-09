<?php

	$imgfile = '../admission/'.$photo;
	#resize photo
	 	$full_url = $photo;
		$imageInfo = @getimagesize($imgfile);
		$src_width = $imageInfo[0];
		$src_height = $imageInfo[1];
		
		$dest_width = 80;//$src_width / $divide;
		$dest_height = 80;//$src_height / $divide;
		
		$src_img = @imagecreatefromjpeg($imgfile);
		$dst_img = imagecreatetruecolor($dest_width,$dest_height);
		@imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
		@imagejpeg($dst_img,$full_url);
		@imagedestroy($src_img);
	#new resized image file
	   $imgfile = $full_url;
	#NB: ili hii ifanye kazi lazima images folder kwenye academic liwe writable!!!
?>
