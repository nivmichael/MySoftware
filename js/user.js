var user = function() {

    //check if user is logged in and display the rellevant layout
    function checkUserLogged() {
        try{
            nanoajax.ajax({
                url:'rpc/user.rpc.php/?action=check-logged-in'
            }, function (code, responseText) { 
                
                // console.log(responseText);
                var response = JSON.parse(responseText);
                var status = response["status"];
        
                if (status === true) {
                    userLoggedLayout(response);
                }
                else {
                    userNotLoggedLayout();
                }
            })
        }
        catch (e) {
            console.error(e);
        } 
    }


    //make POST request to log the user in
    function loginClicked() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
    
        const formData = new FormData();
    
        formData.append('username', username);
        formData.append('password', password);
    
        try{
          nanoajax.ajax({
            url: 'rpc/user.rpc.php/?action=user-login', 
            method: 'POST', 
            body: formData
          }, function (code, responseText, request) {
            
              if (code === 200) {

                //display new layout with username at time since login
                var response = JSON.parse(responseText);
                userLoggedLayout(response);
        
        
              } else {
                  console.error('Request failed with status ' + code);
                  document.getElementById("id-login-error-msg").innerHTML     =  responseText;
                  document.getElementById("id-login-error-msg").style.display =  "block";
              }
          })
        }
        catch (e) {
          console.error(e);
        }
    
    }

    
    //hide the login popup window
    function cancelLoginClicked() {
        document.getElementById("id-login-popup").style.display = "none";
    }


    //log the user out and go back to initial login page
    function logoutClicked() {
        try{
            nanoajax.ajax({
                url:'rpc/user.rpc.php/?action=logout'
            }, function (code, responseText) { 
                
                // console.log(responseText);
                userNotLoggedLayout();
            })
        }
        catch (e) {
            console.error(e);
        }
    }


    return {
        checkUserLogged, loginClicked, cancelLoginClicked, logoutClicked
    }
}();