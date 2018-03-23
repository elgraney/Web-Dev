
//Javascript to validate if our form fields are populated
function validateForm()
{
  var userField = document.forms["loginForm"]["username"].value;
  var passField = document.forms["loginForm"]["password"].value;
  if (userField == "" || passField == "")
  {
      alert("You must enter a username and password");
      return false;
  }
}
