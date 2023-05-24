var user = function () {

    function loginUser(ev) {
        ev.preventDefault();
        const body = JSON.stringify({ username: ev.target.elements.uname.value, password: ev.target.elements.passw.value })
        nanoajax.ajax({ url: url + actions.loginUser, body, method: 'POST' }, function (code, responseText) {
            try {
                if (code != RES_CODE.OK) {
                    // Display Error Msg
                    return;
                }
                app.displaySection(SECTIONS.BLOGS)
            } catch (e) {
                console.error(`error in loginUser(): ${error}`);
            }
        })
    }

    function logout() {
        nanoajax.ajax({ url: url + actions.logout }, function (code, responseText) {
            app.displaySection(SECTIONS.LOGIN)
        })
    }

    return {
        loginUser,
        logout
    }

}();
