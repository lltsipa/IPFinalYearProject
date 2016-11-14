<?php
/*Created by : Lonwabo Tsipa, Asavela Mzilikazi, Zalisekile Coto*/
   session_start(); 
   require 'header.php';
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Upload a book</title>
    <link rel="stylesheet" type="text/css" href="css/navBar.css">
    <link rel="stylesheet" type="text/css" href="css/loginBar.css">
    <link rel="stylesheet" type="text/css" href="css/uploadForm.css">

    <script src="js/user.js"></script>
    <script src="js/upload.js"></script>

</head>
<body>

<?php 
	genHeader('upload'); 

	if(isset($_POST['isbn'])) //do submit logic
	{
		if(insertNewBook())
		{
			$_POST = array();
			?>
			<div id = 'thanksDiv'>
				Thanks! Book added to "My Books".
			</div>
			<?php
		}
		else
		{
			?>
			<div id = 'thanksDiv'>
				Woops! Adding Book failed... Please try again.
			</div>	
			<?php
		}
	}
		
	//serve form
?>

<div id = 'uploadFormDiv'>
	<form id = "uploadForm" method = 'post' enctype="multipart/form-data">
		<label for="title">Title</label> <br>
		<input class = "uploadFormItem" type = "text" name = "title"><br><br>

		<label for="category">Category</label> <br>
		<select class = "uploadFormItem" name = "category">
  			<option value="Business">Business</option>
  			<option value="Sport Management">Sport Management</option>
  			<option value="Tourism">Tourism</option>
  			<option value="Informatics And Design">Informatics And Design</option>

  			<option value="Accounting">Accounting</option>
  			<option value="Applied Science">Applied Science</option>
  			<option value="Radiography">Radiography</option>
  			<option value="Health and Wellness">Health and Wellness</option>

  			 <option value="Architecture">Architecture</option>
  			<option value="Hospitality">Hospitality</option>
		</select><br><br>

		<label for="description">Description</label> <br>
		<textarea class = "uploadFormItem" name="description" cols="40" rows="5" ></textarea><br>

		<label for="isbn">ISBN Code</label> <br>
		<input class = "uploadFormItem" type = "text" name = "isbn"><br><br>

		<label for="condition">Condition</label> <br>
		<input class = "uploadFormRadio" type="radio" name="condition" value="undamaged" checked>Undamaged
  		<br>
  		<input class = "uploadFormRadio" type="radio" name="condition" value="scruffy">Scruffy
  		<br>
  		<input class = "uploadFormRadioBottom" type="radio" name="condition" value="damaged">Damaged
  		<br><br>

		<label for="price">Price</label> <br>
		<input class = "uploadFormItem" type = "text" name = "price"><br><br>

		<label for="datafile">Image</label> <br>
		<input class = "uploadFormItem" type="file" id = 'datafile' name="datafile" size="40"><br><br>

		<br>
		<button class = "uploadFormButton" id = "uploadButton" onclick = "return validateUpload(this)">Upload</button>
	</form>
</div>

</body>
</html>

<?php

	function insertNewBook()
	{
		 require 'connector.php';
		//TODO: no serverside validation.
		
			$generalWithISBN = mysqli_query($con,'SELECT isbn FROM bookgeneral WHERE isbn="'.$_POST['isbn'].'"');
			if($generalWithISBN->num_rows < 1)
			{
				error_log('GENERAL INSERT RUNNING. VALUES:', 0);
				error_log('====================================', 0);
				error_log('isbn: '.$_POST['isbn'], 0);
				error_log('title: '.$_POST['title'], 0);
				error_log('description: '.$_POST['description'], 0);
				error_log('category: '.$_POST['category'], 0);

				$generalSQL ='INSERT INTO bookgeneral VALUES("'.$_POST['isbn'].'","'.$_POST['title'].'","'.$_POST['description'].'","'.$_POST['category'].'");';

				error_log('GENERAL SQL: '.$generalSQL, 0);

			 	//isbn imageName description
			    if (!mysqli_query($con, $generalSQL))
			    {
			    	error_log('Error: Insert into bookgeneral failed.', 0);
			    	return false;
			    }
			}
			 
	 		$username = getLoggedInUsername();

	 		error_log('SPECIFIC INSERT RUNNING. VALUES:', 0);
			error_log('------------------------------------', 0);
			error_log('isbn: '.$_POST['isbn'], 0);
			error_log('price: '.$_POST['title'], 0);
			error_log('condition: '.$_POST['description'], 0);
			error_log('username: '.$username, 0);

			if($_FILES['datafile']['error'] === UPLOAD_ERR_OK)
			{

				$specificSQL = 'INSERT INTO bookspecific (isbn, price, bookCondition, status, ownerUsername, imageName) '.'VALUES("'.$_POST['isbn'].'",'.$_POST['price'].',"'.$_POST['condition'].'","available","'.$username.'","'.'tempValue'.'");';

			 	error_log('SPECIFIC SQL: '.$specificSQL, 0);

			 		//save specific image details
			 	if(!mysqli_query($con, $specificSQL))
			 	{
			 		error_log('Error: Insert into bookspecific failed.', 0);
			 		return false;
			 	}
			 	else // load final image with specific ID as name
			 	{

			 		//get id for specific
					$id = $con->insert_id;
					if(!$id)
					{
						error_log('Error: Previous insert id is undefined!', 0);
						return false;
					}

			 		//copy image to directory
					$info = pathinfo($_FILES['datafile']['name']);
	 				$ext = $info['extension']; // get the extension of the file
	 				$newname = strval($id).".".$ext; 

	 				//update temp value
	 				$updateSQL = 'UPDATE bookspecific SET imageName= "'.$newname.'" WHERE id = '.strval($id).';';
					if(!mysqli_query($con, $updateSQL))
			 		{
			 			error_log('Error: Update imagename of bookspecific failed.', 0);
			 			return false;
			 		}


	 				$target = 'images/'.$newname;
	 				move_uploaded_file( $_FILES['datafile']['tmp_name'], $target);
			 	}
			}
			else
			{
			 	error_log('Error: Image Upload Failed', 0);
			 	return false;
			}
			return true;
	}

?>