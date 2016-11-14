

function validateUpload()
{

	form = document.forms[0];

	var title = form.elements["title"];

	var category = form.elements["category"];
	var description = form.elements["description"];
	var isbn = form.elements["isbn"];
	var conditionRadio = form.elements["condition"];

	var price = form.elements["price"];
	if(isNaN(price.value) || price.value == "")
	{
		alert('Price is not a number');
		return false;
	}

//serverside validation catches this
	//var file = getElementById('datafile');

	//alert(file.value);
//
	//i/f(file.length == 0)
	//{
    //	alert('Please upload a file');
	//	return false;
	//}

	//if (!file.name.match(/\.(jpg|jpeg|png|gif)$/))
	//{
	//	alert('Please upload an image');
	//	return false
	//}
    

	if(!loggedIn())
	{
		alert('please log in before uploading your books details.');
		return false;
	}
	else
	{
		document.getElementById("uploadForm").action = "upload.php";
		document.getElementById("uploadForm").submit();
		return true;
	}

	
}

