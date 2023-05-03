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
        document.getElementById("id-login-popup").style.display = "none";
        document.getElementById("id-login-btn").style.display = "none";
        document.getElementById("id-user-logged-in").style.display = "block";

        // console.log(responseText["time_since_last_login"]);

        var obj = JSON.parse(responseText)
        
        var timeSinceLastLogin = obj["time_since_last_login"];
        
        document.getElementById("user-logged-in-text").innerHTML = 'user logged in! <br> his last login was ' + timeSinceLastLogin + ' seconds ago';


      } else {
          console.error('Request failed with status ' + code);
      }
    })
}


function cancelClicked() {
  document.getElementById("id-login-popup").style.display = "none";
}