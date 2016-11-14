
function unreserveBook(bookId, rowId)
{
	var request = new XMLHttpRequest();
  request.open('POST', 'mybooks.php', true);

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  var postStr ='unreserve=true&bookId=' + bookId;
  request.send(postStr);

  request.onload = function (e) 
  {
    if (request.status === 200) 
    {
        document.getElementById("bookTable").rows[rowId+1].cells[6].innerHTML = "available";
        document.getElementById("bookTable").rows[rowId+1].cells[7].innerHTML = '<td class = "tableElement"><button onclick = "deleteBook('+bookId+','+rowId+')">Delete</button></td>';
    }
    else
    {
        alert("Unreserve failed");
    }
  };
}

function deleteBook(bookId, rowId)
{
	var request = new XMLHttpRequest();
  	request.open('POST', 'mybooks.php', true);

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send('delete=true&bookId=' + bookId);

  	request.onload = function (e) 
  	{
   	 	if (request.status === 200) 
    	{
    	    document.getElementById("bookTable").deleteRow(rowId+1);
  		}
    	else
    	{
      	 	alert("Delete failed");
    	}
  	};
}