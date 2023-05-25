var user = function() {
    function userLogin(event) {
        event.preventDefault();
        //console.dir(event.target.username.value)
        // console.log(event);
        // console.dir(event);
        const req = { 
          username:event.target.username.value,
          password:event.target.pwd.value
        };
        const json=JSON.stringify(req);
      
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
            console.log(`repsonse text ${responseText}`);

          }
        );
      }
      

	return {
		userLogin,
	}
}();