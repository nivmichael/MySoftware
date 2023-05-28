var user = function () {
    // function loginUser(ev) {
    //     ev.preventDefault();
    //     const body = JSON.stringify({ username: ev.target.elements.uname.value, password: ev.target.elements.passw.value })
    //     nanoajax.ajax({ url: userUrl + actions.loginUser, body, method: 'POST' }, function (code, res) {
    //         try {
    //             if (code != RES_CODE.OK) {
    //                 // Display Error Msg
    //                 return;
    //             }
    //             app.displaySection(SECTIONS.BLOGS);
    //             setLogin(true);
    //             blog.setBlogs();
    //         } catch (e) {
    //             console.error(`error in loginUser(): ${error}`);
    //         }
    //     })
    // }

    function setLogin(loggedIn){
        if (!loggedIn) {
            localStorage.removeItem(LS_KEYS.login);
            return;
        }

        localStorage.setItem(LS_KEYS.login, loggedIn);
    }
 
    function isLoggedIn() {
        logged = localStorage.getItem(LS_KEYS.login);
        return logged !== null; 
    }

    function loginUser2(ev) {
        ev.preventDefault();
        fn = () => {
            app.displaySection(SECTIONS.BLOGS);
            setLogin(true);
            blog.setBlogs();
        }
        const body = { username: ev.target.elements.uname.value, password: ev.target.elements.passw.value };
        util.sendAjax(userUrl + actions.loginUser,fn, 'POST' , body);
    }

    function logout() {
        nanoajax.ajax({ url: userUrl + actions.logout }, function (code, responseText) {
            setLogin(false);
            app.displaySection(SECTIONS.LOGIN)
            blog.setBlogs();
        })
    }

    return {
        logout,
        loginUser2,
        isLoggedIn
    }

}();
