const RES_ERR_CODE = 400;
var user = function () {

    function loginUser(ev) {
        ev.preventDefault();

        const url = '/rpc/user.rpc.php?action=loginUser'
        const body = JSON.stringify({ username: ev.target.elements.uname.value, password: ev.target.elements.passw.value })

        nanoajax.ajax({ url, body, method: 'POST' }, function (code, responseText) {
            document.getElementById('id-err-login-msg').innerHTML = responseText;
            console.log(code);
            console.log(responseText);
        })
    }

    return {
        loginUser
    }

}();