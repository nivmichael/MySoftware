const url = '/rpc/user.rpc.php?action=';

const actions = {
    loginUser: "loginUser",
    isLoggedIn: "isLoggedIn",
    getBlogs: "getBlogs", 
    logout: "logout",
    addBlog: "addBlog"
}

const RES_CODE = {
    OK: 200,
    ERR: 400
}

const SECTIONS = {
    LOGIN: "id-login-section",
    BLOGS: "id-blogs-section"
}

const HIDE_CLASS = "c-hide";
const DISPLAY_CLASS = "c-display";