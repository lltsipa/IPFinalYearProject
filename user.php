<?php
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
	session_start();

	require 'userFunctions.php';

	/*Responsible for updating user login session*/
	error_log('checking action', 0);
	if(isset($_POST['action']))
	{
		error_log('Action set', 0);
		if($_POST['action'] == 'login')
		{
			error_log('Action is login', 0);
			error_log('username: '.$_POST['username'], 0);
			error_log('password: '.$_POST['password'], 0);

			if(login($_POST['username'], $_POST['password']))
			{
				http_response_code(200);
			}
			else
			{
				http_response_code(400);
			}
			
		}
		else if($_POST['action'] == 'logout')
		{
			error_log('Action  is logout', 0);
			logout();
			http_response_code(200);
		}
		else http_response_code(400);
	}


?>

