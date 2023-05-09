
let searchText = "";

// Show login popup when button is clicked
document.getElementById("id-login-btn").addEventListener("click", function() {
    document.getElementById("id-login-error-msg").style.display      = "none";
    document.getElementById("id-login-popup").style.display          = "block";
  });
  
// Show upload post pupop window when button is clicked
document.getElementById("id-upload-post-btn").addEventListener("click", function() {
  document.getElementById("id-file-error-msg").style.display        = "none";
  document.getElementById("id-upload-post-form").style.display      = "block";
});


//update the search text
function searchTextChanged() {
  searchText = document.getElementById("id-search-text").value;
  post.displayAllPosts();
}


//display the layout when a user is logged in
function userLoggedLayout(response) {
  document.getElementById("id-login-popup").style.display         = "none";
  document.getElementById("id-login-btn").style.display           = "none";
  document.getElementById("id-user-logged-in").style.display      = "block";

  var username  = response["username"];
  var lastLogin = response["prev_login"];

  let displayText = 'user ' + username + ' logged in! <br> ';
  
  displayText += lastLogin ? 'your last login was at ' + lastLogin : 'this is your first login!';
  
  document.getElementById("id-user-logged-in-text").innerHTML = displayText ;

  post.displayPostsOfUser();
}


//display the layout when a user is not logged in
function userNotLoggedLayout(response) {
  document.getElementById("id-login-popup").style.display         = "none";
  document.getElementById("id-login-btn").style.display           = "block";
  document.getElementById("id-user-logged-in").style.display      = "none";
  document.getElementById("id-upload-post-form").style.display    = "none";
  document.getElementById("id-edit-post-form").style.display      = "none";
  document.getElementById("id-search-text").style.display         = "block";
  post.displayAllPosts();
}

