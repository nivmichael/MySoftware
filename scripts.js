


//display the layout when a user is logged in
function userLoggedLayout(response) {
    document.getElementById("id-post-management").style.display      = "block";
    document.getElementById("id-blog").style.display                 = "none";

    var username  = response["username"];
    var lastLogin = response["prev_login"];

    let displayText = 'user ' + username + ' logged in! <br> ';

    displayText += lastLogin ? 'your last login was at ' + lastLogin : 'this is your first login!';

    document.getElementById("id-user-logged-in-text").innerHTML = displayText ;

    post.getPostsOfUser();
}


//display the layout when a user is not logged in
function userNotLoggedLayout() {

    document.getElementById("id-blog").style.display                = "block";
    document.getElementById("id-post-management").style.display     = "none";

    post.getAllPosts(post.displayAllPosts);
}

