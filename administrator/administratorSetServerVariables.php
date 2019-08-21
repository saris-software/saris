
 <?php
//Author: Juma Lungo
//Date: Septermber 18, 2004
//Rationale: We are in a crisis where ZALONGWA Database System is not Working
//To intrude the MySQL Server in Dar es Salaam so that ZALONGWA Database System will run appropriately
require_once('../Connections/zalongwa.php'); 

//This is my mysql monitor where i can run different commands to set server variables
			$setCacheSize = "SET GLOBAL thread_cache_size=40";
			$setWaitTimeOut = "SET GLOBAL wait_timeout=60";
			$setMaxConnections = "SET GLOBAL max_connections=180";
			$setMaxUserConnections = "SET GLOBAL max_user_connections=150";
			//To execute the above commands, take out the comments(un-comments the respective query below
					$query = @mysqli_query($zalongwa,$setCacheSize);
					$query = @mysqli_query($zalongwa,$setWaitTimeOut);
					$query = @mysqli_query($zalongwa,$setMaxConnections);
					$query = @mysqli_query($zalongwa,$setMaxUserConnections);
//End of my MySQL Monitor          
 mysqli_close($zalongwa);
			
			echo '<meta http-equiv = "refresh" content ="0; 
			url = administratorcheckconnections.php">'; 
?>
