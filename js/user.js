var user = (function () {

  let currSection = SECTION.login;

  function userLogin(event) {
    event.preventDefault();

    var messageLogin = document.getElementById("id-message-login");

    const req = {
      username: event.target.username.value,
      password: event.target.pwd.value
    };

    const json = JSON.stringify(req);

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
        try {
          var response = JSON.parse(responseText);
          // Hide error
          messageLogin.textContent = "";
          if (response.status) {
            // Id login successful - show new section of create blog

            // display create Blog section and hide currSection => SECTION.login;
            app.displaySection(SECTION.createBlog, currSection);
            currSection = SECTION.createBlog;
            alert(response.msg);
          } else {
            messageLogin.textContent = response.msg;
          }
        } catch (e) {
          console.log("userLogin error:" + e);
        }
      }
    );
  }

  function userLogout(event) {
    event.preventDefault();

    var messageLogout = document.getElementById("id-message-create-blog");

    nanoajax.ajax(
      {
        url: `/rpc/user.rpc.php?action=${USER_ACTIONS.LOG_OUT}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "GET",
      },
      function (code, responseText, request) {
        try {
          var response = JSON.parse(responseText);
          // Hide error
          messageLogout.textContent = "";
          if (response.status) {
            alert(response.msg);
            // display login section and hide currSection => SECTION.createBlog;
            app.displaySection(SECTION.login, currSection);
            currSection = SECTION.login;
          } else {
            // error message to client
            messageLogout.textContent=response.msg;
          }
        } catch (e) {
          console.log("userLogout error:" + e);
        }
      }
    );
  }

  function isLogin(event) {
    
  }

  return {
    userLogin,
    userLogout,
  };
})();

