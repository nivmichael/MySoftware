nanoajax.ajax({url:'https://jsonplaceholder.typicode.com/posts'}, function (code, responseText) { 
    ans = JSON.parse(responseText)
    ans = ans.filter(startWithE);
    
    // console.log(ans)
    var results = document.getElementById("id-results");
    var nHTML = '';

    for (var i = 0; i < ans.length; i++) {
        nHTML += '<div class="c-post"> <details> <summary>' + ans[i]['title'];
        nHTML += '</summary> <br>';
        nHTML += ans[i]['body'];
        // nHTML += '<hr>';
        nHTML += '</details> </div>'
     }

     results.innerHTML = nHTML;
})


function startWithE(post) {
    return post['title'][0] === 'e' || post['body'][0] === 'E';
  }


// Show login popup when button is clicked
document.getElementById("id-login-btn").addEventListener("click", function() {
    document.getElementById("id-login-popup").style.display = "block";
  });
  
// Hide login popup when user clicks outside of it --- not working!!!!
// window.addEventListener("click", function(event) {
//   if (event.target == document.getElementById("id-login-popup")) {
//     document.getElementById("id-login-popup").style.display = "none";
//   }
// });

document.getElementById("id-upload-post-btn").addEventListener("click", function() {
  document.getElementById("id-upload-post-form").style.display = "block";
});


document.getElementById("id-logout-btn").addEventListener("click", function() {
  nanoajax.ajax({
    url:'rpc/user.rpc.php/?action=logout'
  }, function (code, responseText) { 
      console.log(responseText);
      userNotLoggedLayout();
   })
});


function checkUserLogged() {
  nanoajax.ajax({
    url:'rpc/user.rpc.php/?action=check-logged-in'
  }, function (code, responseText) { 
      console.log(responseText);
      var response = JSON.parse(responseText);
      var status = response["status"];

      if (status === true) {
        userLoggedLayout(response);
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

    var data = 'username=' + username + '&password=' + password

    //try sending request with json!!! (and not raw string)
    nanoajax.ajax({
      url: 'rpc/user.rpc.php', 
      method: 'POST', 
      body: data
    }, function (code, responseText, request) {
      if (code === 200) {
        console.log(responseText);
        //display new layout with username at time since login
        var response = JSON.parse(responseText);
        userLoggedLayout(response);


      } else {
          console.error('Request failed with status ' + code);
      }
    })
}


function cancelLoginClicked() {
  document.getElementById("id-login-popup").style.display = "none";
}


//WAIT FOR MICHAEL ON THIS!!!
function uploadPost() {
  console.log("uploadeFile clicked");
  console.log(document.getElementById("id-file-to-upload"));
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
  
  document.getElementById("id-user-logged-in-text").innerHTML = 'user ' + username + ' logged in! <br> his last login was at ' + lastLogin ;
}


function userNotLoggedLayout(response) {
  document.getElementById("id-login-popup").style.display = "none";
  document.getElementById("id-login-btn").style.display = "block";
  document.getElementById("id-user-logged-in").style.display = "none";
  document.getElementById("id-upload-post-form").style.display = "none";
}

