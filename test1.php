<?php
include("injprev.php");
static $con;
$mysql_username = "mysql";
$mysql_password = "password";
$l = "localhost";
$db = "cse545";

$con = mysqli_connect('localhost', $mysql_username, $mysql_password) or die("Unable to connect to mysql.");
mysqli_select_db($con,'cse545') or die("Unable to select database cse545");

if (isset($_POST['submitfile']))
{
   $tmp_file = $_FILES['file']['tmp_name'];
   $h = fopen($tmp_file, "r") or die("unable to read tmp file");
   $uploaded = fread($h, filesize($tmp_file));

   $query = sprintf("insert into files (name, password, content) values ('%s', '%s', '%s')", mysqli_real_escape_string($con,$_POST['name']), mysqli_real_escape_string($con,$_POST['password']), mysqli_real_escape_string($con,$uploaded));
  // echo $query;
   mysqli_query($con,$query) or die("unable to submit the query");

   header('Location: '.$_SERVER['PHP_SELF']);
   exit;
}
else if (isset($_POST['submitaccess']))
{
	$conn= array("localhost","cse545","root","");
	$_POST['name'] = sanitize_input($conn,$_POST['name'],"string");
	$_POST['password'] = sanitize_input($conn,$_POST['password'],"string");
   $res = mysqli_query($con,"select content from files where name = '${_POST['name']}' and password = '${_POST['password']}'") or die(mysqli_error());
   if ($row = mysqli_fetch_array($res))
   {
	  $contents = $row['content'];
	  header('Content-Type: text/plain');
	  echo $contents;
	  exit;
   }
   else
   { ?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>File Storage</title>
</head>

<body>
	 <h1>Error</h1>
		 <p>Did not find file with username/password <?php echo htmlentities($_POST['name']) . "/" . htmlentities($_POST['password']); ?></p>
</body>
</html>
<?php
     exit;																												  
   }
   
}
else {

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>File Storage</title>
</head>

<body>
	 <h1>Welcome to our file storage system</h1>
	  <p>Access your uploaded file:</p>
	  <form method="POST">
		Name: <input name="name" type="text"><br>
		Password: <input name="password" type="text"><br>	  
		<input name="submitaccess" type="submit">
	  </form>
	  
	 <p>Upload your file:</p>
	 <form enctype="multipart/form-data" method="POST">
	   Name: <input name="name" type="text"><br>
	   Password: <input name="password" type="text"><br>	  
	   File: <input name="file" type="file"><br>
	   <input name="submitfile" type="submit">
	 </form>
	  
</body>
</html>

<?php } ?>
