<?php
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
		session_start();
	require 'header.php';

	if(isset($_POST['username']))
	{
		signup();
		servePage();
	}
    else
    {
    	servePage();
    }

?>
<?php


function servePage()
{
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Category</title>
		<link rel="stylesheet" type="text/css" href="css/category.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
		<link rel="stylesheet" type="text/css" href="css/navBar.css">
		<link rel="stylesheet" type="text/css" href="css/loginBar.css">
		<link rel="stylesheet" type="text/css" href="css/myBooks.css">
			<link rel="stylesheet" type="text/css" href="css/uploadForm.css">
	</head>
	<body>

	<?php 
		genHeader('signup'); 
		genBody();
	?>
	</body>
	</html>
	<?php
}


function genBody()
{
	?>
	<div id= "uploadFormDiv">
	<form id = "uploadForm" method = 'post' enctype="multipart/form-data", action="signup.php">

		<label for="username">Username</label> <br>
		<input class = "uploadFormItem" type = "text" name = "username"><br><br>

		<label for="password">Password</label> <br>
		<input class = "uploadFormItem" type = "text" name = "password"><br><br>

		<label for="name">Name</label> <br>
		<input class = "uploadFormItem" type = "text" name = "name"><br><br>

		<label for="lastNae">Last Name</label> <br>
		<input class = "uploadFormItem" type = "text" name = "lastName"><br><br>

		<label for="title">Email</label> <br>
		<input class = "uploadFormItem" type = "text" name = "email"><br><br>

		<label for="title">Phone</label> <br>
		<input class = "uploadFormItem" type = "text" name = "phone"><br><br>

		<label for="title">Address</label> <br>
		<input class = "uploadFormItem" type = "text" name = "address"><br><br>
			
		<br>
		<input type="submit" value="Sign Up">
	</form>

	</div>
	<?php
}


function signUp()
{
	$username = $_POST['username'];

	$password = $_POST['password'];
	$name = $_POST['name'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address =$_POST['address'];

	if($username == '' || $password == '' || $name == '' ||
	 $lastName == '' || $email == '' || $phone == '' || $address == '')
	{
		?>
			Please complete all fields and try again  
		<?php
		return;
	}


	require 'connector.php';


		$sql = 'INSERT INTO client VALUES("'.$username.'","'.$password.'","'.$name.'","'.$lastName.'","'.$email.'","'.$phone.'","'.$address.'");';
		$ret = mysqli_query($con, $sql);
		if(!$ret){error_log('ERROR signup insert failed with: '.$sql, 0);} 
}