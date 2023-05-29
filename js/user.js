var user = (function () {
  function userLogin(event) {
    var responseMessage=document.getElementById('id-message');

    event.preventDefault();
    //console.dir(event);
    // console.log(event);
    // console.dir(event);
    const req = {
      username: event.target.username.value,
      password: event.target.pwd.value,
    };
    const json = JSON.stringify(req);


    // console.log(JSON.stringify(req))
    nanoajax.ajax(
      {
        url: `/rpc/user.rpc.php?action=${USER_ACTIONS.LOGIN}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        body: json,
      },
      function (code, responseText, request) {
        
        // CR: add try-catch for each response from server, handle the response and error in this function only
        var response = JSON.parse(responseText);
        // Hide error
        responseMessage.textContent='';

        if (code === 200) {
          // Handle successful login response from user.rpc.php
          try {
            console.log(response);
          if (response.success) {
            // Id login successfull - show new section of blog post form
            alert(response.success);

          } else if (response.error) {
            responseMessage.textContent = response.error;
          }
          } catch (e) {
              console.log('userLogin error:' + e);
          }
        } else {
          // Handle error
          try {
            console.log('Error: ' + code);
            responseMessage.textContent = response.error;
          } catch (e) {
              console.log('userLogin error:' + e);
          }
  
        }
      }
    );
  }

  return {
    userLogin,
  };
})();


