<?php
#resize logo
		$logo = 'images/logot.jpg';
		$logofile = '../'.$logo;
		#resize photo
		$full_url = $logo;			
		$imageInfo = @getimagesize($logofile);
		$src_width = $imageInfo[0];
		$src_height = $imageInfo[1];
		
		//$dest_width = 100;//$src_width / $divide;
		$dest_width = 117;//$src_width / $divide;
		$dest_height = 90;//$src_height / $divide;
		
		$src_img = @imagecreatefromjpeg($logofile);
		$dst_img = imagecreatetruecolor($dest_width,$dest_height);
		@imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
		@imagejpeg($dst_img,$full_url);
		@imagedestroy($src_img);
	#new resized image file
	$logofile = $full_url;
	#NB: ili hii ifanye kazi lazima images folder kwenye academic liwe writable!!!
?>
