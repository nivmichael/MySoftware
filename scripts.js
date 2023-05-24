function userLogin(event) {
  event.preventDefault();
  //console.dir(event.target.username.value)
  console.log(event);
  console.dir(event);
  const req = { 
    username:event.target.username.value,
    password:event.target.pwd.value
  };
  const json=JSON.stringify(req);

  console.log(JSON.stringify(req))
  nanoajax.ajax(
    {
      url: "/rpc/user.rpc.php",
      headers: {
        "Content-Type": "application/json",
      },
      method: "POST",
      body: json,
    },
    function (code, responseText, request) {
      console.log(code);
      console.log(request);      
    }
  );






}
