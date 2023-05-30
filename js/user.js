var user = function () {

    function setLogin(loggedIn){
        let loginBtnElem = document.getElementById(ELEM_ID.logoutBtn);
        if (!loggedIn) {
            loginBtnElem.classList.add(HIDE_CLASS);
            localStorage.removeItem(LS_KEYS.login);
            return;
        }
        loginBtnElem.classList.remove(HIDE_CLASS);
        localStorage.setItem(LS_KEYS.login, loggedIn);
    }
 
    function isLoggedIn() {
        logged = localStorage.getItem(LS_KEYS.login);
        return logged !== null; 
    }

    function loginUser(ev) {
        ev.preventDefault();
        fn = () => {
            setLogin(true);
            app.displaySection(SECTIONS.BLOGS);
            blog.setBlogs();
        }
        const body = { username: ev.target.elements.uname.value, password: ev.target.elements.passw.value };
        util.sendAjax(userUrl + actions.loginUser,fn, 'POST' , body, (err,res)=>{
            document.getElementById(ELEM_ID.errLoginMsg).innerHTML = res;
        });
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
        loginUser,
        isLoggedIn,
        setLogin
    }

}();
