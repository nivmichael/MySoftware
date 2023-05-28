var user = (function () {
  function userLogin(event) {
    event.preventDefault();
    console.dir(event);
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
        var response = JSON.parse(responseText);

        handleResponse(response, code);
      }
    );
  }

  return {
    userLogin,
  };
})();

function handleResponse(response, code) {
  hideError();
  if (code === 200) {
    // Handle successful login response from user.rpc.php
    console.log(response);
    if (response.success) {
      alert(response.success);
    } else if (response.error) {
      showError(response.error);
    }
  } else {
    // Handle error
    console.log('Error: ' + code);
    showError(response.error);
  }
}

function showError(message){
  var errorMessage=document.getElementById('id-error-message');
  errorMessage.textContent=message;
}

function hideError(){
  var errorMessage=document.getElementById('id-error-message');
  errorMessage.textContent='';
}


