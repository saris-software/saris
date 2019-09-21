<?php 
require_once('../Connections/sessioncontrol.php');
# include the header
include('policy.php');
	global $szSection, $szSubSection, $szTitle, $additionalStyleSheet;
	$szSection = 'Policy Setup';
	$szTitle = 'Policy Setup';
	$szSubSection = 'Policy Setup';
	//include("lecturerheader.php");
	
?>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Welcome Exam Officer</h2>
  <p>Verify Your Information</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Login ID</th>
        <th>Status</th>
       <th>E-Post</th>
        <th>Registered</th>
      
      </tr>
    </thead>
    
<?php /*require_once('../Connections/zalongwa.php');

$sql = "SELECT FullName, Email, Position, UserName, Registered FROM security WHERE UserName = '$username'";
$query = @mysqli_query($zalongwa, $sql) or die("Cannot query the database.<br>" . mysqli_error($zalongwa));

while($result = mysqli_fetch_array($query)) {
		$Name = stripslashes($result["FullName"]);
		$username = stripslashes($result["UserName"]);
		$position = stripslashes($result["Position"]);
		$email = stripslashes($result["Email"]);
		$registered = stripslashes($result["Registered"]);
	<tbody>
    
                       echo "<tr><td>$Name</td>";
			echo "<td>$username</td>";
			echo "<td>$position</td>";
			echo "<td>$email</td>";
			echo "<td>$registered</td></tr>";
			
			

    </tbody>
    
 */
 ?>
  </table>
</div>

</body>
</html>

