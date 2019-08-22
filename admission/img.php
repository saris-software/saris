<?php
	require_once('../Connections/zalongwa.php');
	
	if(isset($_GET['id'])){
		$ID = $_GET['id'];
		$det = explode("[",$ID);
		
		$num = $det[0];
		$per = $det[1];
		
		$download_file = mysqli_query("SELECT Photo, Size FROM electioncandidate WHERE RegNo='$num' AND Period='$per'", $zalongwa);
		list($content, $size, ) = mysqli_fetch_array($download_file);
			
		@header("Content-length:$size");
		//@header("Content-type:$type");
		//@header("Content-Disposition: Attachment; filename=$name");
			
		echo $content;
		}


	if(isset($_POST['Upload'])){
		#format student credentials
		$ID = $_POST['regno'];
		$det = explode("[",$ID);
		$num = $det[0];
		$per = $det[1];

		#known file extensions array
		$known_extensions = array('png','jpg','jpeg','gif');

		$max_size = $_POST['MAX_FILE_SIZE'];
				
		$fileName = $_FILES['fileUp']['name'];
		$tmpName  = $_FILES['fileUp']['tmp_name'];
		$fileSize = $_FILES['fileUp']['size'];
		$fileType = $_FILES['fileUp']['type'];
		
		
		#check if the file size has zero bytes
		if($fileSize <= 0){
			$error = urlencode("Please select photo to upload first");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#check if the file size has exceeded the maximum upload limit size
		if($fileSize > $max_size){
			$error = urlencode("The uploaded file has exceeded the maximum upload size limit");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#get file information
		$file_info = pathinfo($_FILES['fileUp']['name']); 
		$ext = strtolower($file_info['extension']);
		
		#check if the file extension is among the predefined file extensions
		if(!in_array($ext, $known_extensions, true)){
			$error = urlencode("File selected ($fileName) is not of a valid file type");
			$location = "admissionSetcandidate.php?upload=$ID&error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		
		#read contents of the file
		$fp = fopen($tmpName, r);
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		if(!get_magic_quotes_gpc()){
			$fileName = addslashes($fileName);
			}
			
		mysqli_query("UPDATE electioncandidate SET Photo='$content', Size='$fileSize' WHERE RegNo='$num' AND Period='$per'", $zalongwa);
		
		if(mysqli_error($zalongwa)){
			$error = urlencode("The file $fileName failed to upload");
			$location = "index.php?error=$error";
			
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		else{
			$location = "admissionSetcandidate.php";
			echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
			exit;
			}
		}

?>
