const userUrl = '/rpc/user.rpc.php?action=';
const blogUrl = '/rpc/blog.rpc.php?action=';

const actions = {
    logout: "logout",
    loginUser: "loginUser",
    isLoggedIn: "isLoggedIn",
    addBlog: "addBlog",
    getBlogs: "getBlogs",
    editBlog: "editBlog",
    deleteBlog: "deleteBlog",
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

const LS_KEYS = {
    login: "login"
}

const ELEM_ID = {
    popupOverlay: 'id-popup-overlay',
    popupContent: 'id-popup-conent',
    blogsContainer: 'id-blogs-container',
    blogTitle: 'id-blog-title',
    blogText: 'id-blog-text',
    filenameInput: 'id-filename',
    errLoginMsg: 'id-err-login-msg',
    logoutBtn: 'id-logout-li',
    errBlogMsg: 'id-err-blog-msg',

}