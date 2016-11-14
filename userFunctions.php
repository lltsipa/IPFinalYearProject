<?php
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
	function login($username, $password)
	{	
		require 'connector.php';

		$result = mysqli_query($con,'SELECT * FROM client WHERE username="'.$username.'"');

		if($result->num_rows > 0)
		{
			$_SESSION["username"] = $username;
			error_log('Username session var added. Logged in.', 0);
			return true;
		}
		else
		{
			error_log('Username not registered.', 0);
			return false;
		}
		//create session
		
	}

	function logout()
	{
		// remove session variables
		session_unset(); 

		// destroy the session 
		session_destroy(); 

		error_log('Logged out.', 0);
	}

	function loggedIn()
	{
		return isset($_SESSION['username']);
	}

	function getLoggedInUsername()
	{
		if (isset($_SESSION['username']))
		{
			return $_SESSION['username'];
		}
		else return false;
	}

	function getBooks()
	{
		//get books based on session data
	}
	
?>