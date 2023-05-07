
// Show login popup when button is clicked
document.getElementById("id-login-btn").addEventListener("click", function() {
    document.getElementById("id-login-popup").style.display = "block";
  });
  

document.getElementById("id-upload-post-btn").addEventListener("click", function() {
  document.getElementById("id-upload-post-form").style.display = "block";
});


document.getElementById("id-logout-btn").addEventListener("click", function() {
  nanoajax.ajax({
    url:'rpc/user.rpc.php/?action=logout'
  }, function (code, responseText) { 
    try{
      console.log(responseText);
      userNotLoggedLayout();
    }
    catch (e) {
      console.error(e);
    }

   })
});


function checkUserLogged() {
  nanoajax.ajax({
    url:'rpc/user.rpc.php/?action=check-logged-in'
  }, function (code, responseText) { 
    try {
      console.log(responseText);
      var response = JSON.parse(responseText);
      var status = response["status"];

      if (status === true) {
        userLoggedLayout(response);
      }
      else {
        userNotLoggedLayout();
      }
    }
    catch (e) {
      console.error(e);
    } 

   })
}


function loginClicked() {
    // event.preventDefault();
    var username = document.getElementById("username").value
    var password = document.getElementById("password").value

    // var data = {
    //   username: username,
    //   password: password
    // }

    // var headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };

    var data = 'username=' + username + '&password=' + password

    //TODO: try sending request with json!!! (and not raw string)
    nanoajax.ajax({
      url: 'rpc/user.rpc.php/?action=user-login', 
      method: 'POST', 
      body: data
    }, function (code, responseText, request) {
      try{
        if (code === 200) {
          console.log(responseText);
          //display new layout with username at time since login
          var response = JSON.parse(responseText);
          userLoggedLayout(response);
  
  
        } else {
            console.error('Request failed with status ' + code);
        }
      }
      catch (e) {
        console.error(e);
      }

    })
}


function cancelLoginClicked() {
  document.getElementById("id-login-popup").style.display = "none";
}


//TODO: CONTINUE TO IMPLEMENT THIS
function uploadPost() {
  console.log("uploadFile clicked");
  
  let title = document.getElementById("id-post-title").value;
  let body = document.getElementById("id-post-body").value;
  let file = document.getElementById("id-file-to-upload").files[0];

  console.log(title);
  console.log(body);
  console.log(file);

  let file_name = file ? file["name"] : ""

  var data = 'action=upload&title=' + title + '&body=' + body + '&file_name=' + file_name

  //TODO: try sending request with json!!! (and not raw string)
  nanoajax.ajax({
    url: 'rpc/post.rpc.php', 
    method: 'POST', 
    body: data
  }, function (code, responseText, request) {
    try {
      if (code === 200) {

        console.log(responseText);
        //display new layout with username at time since login
        var response = JSON.parse(responseText);
  
        document.getElementById("id-upload-post-form").style.display = "none";
  
        displayPostsOfUser();
  
      } else {
          console.error('Request failed with status ' + code);
      }
    }
    catch(e) {
      console.error(e);
    }

  })

}


function cancelUploadPostClicked() {
  document.getElementById("id-upload-post-form").style.display = "none";
}

function userLoggedLayout(response) {
  document.getElementById("id-login-popup").style.display = "none";
  document.getElementById("id-login-btn").style.display = "none";
  document.getElementById("id-user-logged-in").style.display = "block";

  // console.log(responseText["prev_login"]);

  var username = response["username"];
  var lastLogin = response["prev_login"];

  let displayText = 'user ' + username + ' logged in! <br> '
  
  displayText += lastLogin ? 'your last login was at ' + lastLogin : 'this is your first login!'
  
  document.getElementById("id-user-logged-in-text").innerHTML = displayText ;

  displayPostsOfUser();
}


function userNotLoggedLayout(response) {
  document.getElementById("id-login-popup").style.display = "none";
  document.getElementById("id-login-btn").style.display = "block";
  document.getElementById("id-user-logged-in").style.display = "none";
  document.getElementById("id-upload-post-form").style.display = "none";
  displayAllPosts();
}


function displayAllPosts() {
  nanoajax.ajax({url:'rpc/post.rpc.php/?action=all'}, function (code, responseText) { 
    try {
      var response = JSON.parse(responseText);
      console.log(response);
  
      var results = document.getElementById("id-results");
      var nHTML = '';
    
      for (var i = 0; i < response.length; i++) {
          nHTML += '<div class="c-post"> <details> <summary>' + response[i]['title'];
          nHTML += '</summary> <br>';
          nHTML += response[i]['body'];
          // nHTML += '<hr>';
          nHTML += '</details> </div>'
       }
    
       results.innerHTML = nHTML;
    }
    catch (e) {
      console.error(e);
    }
   


  })
}


function displayPostsOfUser() {
  nanoajax.ajax({url:'rpc/post.rpc.php/?action=current_user'}, function (code, responseText) { 
    try {
      console.log(responseText);
      var response = JSON.parse(responseText);
      // console.log(response);
  
      var results = document.getElementById("id-results");
      var nHTML = '';
  
       //TODO: NEED TO ADD ALSO BUTTONS TO EDIT AND DELETE THE POST
    
      for (var i = 0; i < response.length; i++) {
          nHTML += '<div class="c-post"> <details> <summary>' + response[i]['title'];
          nHTML += '<button id="id-edit-button" class="c-title-button">Edit</button>'
          nHTML += '<button id="id-delete-button" class="c-title-button">Delete</button>'
          nHTML += '</summary> <br>';
          nHTML += response[i]['body'];
          // nHTML += '<hr>';
          nHTML += '</details> </div>'
       }
    
       results.innerHTML = nHTML;
    }
    catch (e) {
      console.error(e);
    }
   

  })
}
