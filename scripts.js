//import NanoAjax from './js/nanoajax-master';

window.addEventListener("load", (event)=>{
    var username  = document.getElementById("username");
    var password = document.getElementById("pwd");
    var submitButtom = document.getElementById("submitButton")
    
    submitButtom.addEventListener("click", userLogin(username,password))
});


function userLogin(username,password) {
    console.log('userLogin function')
}