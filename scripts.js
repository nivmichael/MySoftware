function userLogin(event) {
  event.preventDefault();
  //console.dir(event.target.username.value)
  console.log(event);
  console.dir(event);
  var req = { username: event.target.value };

  console.log( JSON.stringify(event.target.username.value))
  nanoajax.ajax(
    {
      url: "/rpc/user.rpc.php",
      headers: {
        "Content-Type": "application/json",
      },
      method: "POST",
      body: req,
    },
    function (code, responseText, request) {
      console.log(code);
      console.log(request);      
    }
  );






}
