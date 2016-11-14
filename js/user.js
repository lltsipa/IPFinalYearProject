/*Responsible for handling AJAX user login and logout requests. Calls user.php*/

function login()
{
	//get data
	var username = document.getElementById('usernameInput').value;
	var password = document.getElementById('passwordInput').value;

  if(!username || username == "")
  {
      alert("Invalid username");
      return;
  }
  if(!password || password == "")
  {
      alert("Invalid password");
      return;
  }


	var request = new XMLHttpRequest();
    request.open('POST', 'user.php', true);

	request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send('action=login&username=' + username + '&password=' + password);

    request.onload = function (e) 
    {
       if (request.status === 200) 
      {
        //modify site user bar
        document.getElementById("loginDiv").innerHTML =
        "<div id = 'innerLoginDiv'>"+
          "Welcome " + username + "! " +
          "<button id = 'buttonMyBooks' onClick=\"document.location.href='mybooks.php'\"> My Books </button>" +
          "<button id = 'buttonLogout'> Logout </button>" +
        "</div>";
        document.getElementById("buttonLogout").addEventListener("click", logout);
      }
      else
      {
        alert("Login failed");
      }
  };

   
}

function logout()
{
	var request = new XMLHttpRequest();
  request.open('POST', 'user.php', true);

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send('action=logout');

  request.onload = function (e) 
  {
    if (request.status === 200) 
    {
        document.getElementById("loginDiv").innerHTML = 
        "<div id = 'innerLoginDiv'>"+
          "Username:"+
          "<input id = 'usernameInput' type='text' maxlength='30' value=''/>"+
          "Password:"+
          "<input id = 'passwordInput' type='password' maxlength='30' value=''/>"+
          "<button id = 'buttonLogin'>  Login </button>"+
          "<form id = 'signUpForm' action='signup.php'>"+
              "<input type='submit' value='Sign Up'>"+
          "</form>"+
        "</div>";

        document.getElementById("buttonLogin").addEventListener("click", login);
    }
    else
    {
        alert("Logout failed");
    }
  };
}

function loggedIn()
{
   //cheat by getting looking to see if the login button exists... is this open to exploit? 
    var button = document.getElementById("buttonLogout") ;
    if(button === null) return false;
    else return true;
}
