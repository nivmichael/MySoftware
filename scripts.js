const API_URL='https://jsonplaceholder.typicode.com/posts';

// Main function to display items with 'e' in the beginning of the title from api
async function displayItems () {
    const results = document.getElementById("id-results");
    if (results) {
        let response = await fetchData(); // Call to api
        response = filterLetter(response, 'e'); // Filter letters with 'e' in the beginning of title
        
        // Building the API view
        response.forEach(item => {
            const listItem = document.createElement("details");
            listItem.classList.add('c-list-item');
            
            const title = document.createElement("summary");
            title.classList.add('c-list-item-title');
            title.innerHTML = item.title;
            
            const body = document.createElement("div");
            body.classList.add('c-list-item-body');
            body.innerHTML = item.body;

            results.appendChild(listItem); 
            listItem.appendChild(title);
            listItem.appendChild(body);
        })
    }
}

// Call to api and returns array of objects from api
async function fetchData() {
    try {
        const response = await fetch(API_URL)
        return await response.json();
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// Gets array and letter, returns filtered array of objects with the letter in the beginning of title
function filterLetter(response, letter) {
    return response.filter(item => {
        if (item.title && item.title[0] == letter) {
            return item;
        }})
}

// First call to main function
//displayItems();

// Open login form popup
function openForm() {
    document.getElementById("id-login-popup").style.display = "block";
}

// Close login form popup
function closeForm() {
    document.getElementById("id-login-popup").style.display = "none";
}

// Event listener for login 
var loginForm = document.getElementById('id-login-form');
if (loginForm) {
    loginForm.addEventListener("submit", (event) => {
        event.preventDefault();
        userLogin();
      });
}

// Login the user using fetchLogin and shows if login success
async function userLogin() {
    const username = document.getElementById('id-username').value;
    const password = document.getElementById('id-password').value;

    const params = {
        action: 'login',
        username: username,
        password: password, 
    };
    loginStatus = await fetchLogin(params);

    // Shows if login success
    if (loginStatus) {
        if (!loginStatus.status) {
            document.getElementById("id-login-status").style.color="red";
            document.getElementById("id-login-status").innerHTML = loginStatus.data;
        }
        else {
            closeForm();
            // Call to function that loads (DOM) the post form and update user data in the DOM
            userDisplay(loginStatus.name, loginStatus.last_login);
            // Loads (DOM) to display only the logged user's posts
            filterPostsByNameFunc(loginStatus.name);
        }
    }
}

// Send user login data to user.rpc.php
async function fetchLogin(params) {
    try {
        const response = await fetch('rpc/user.rpc.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
            body: JSON.stringify(params),
        });
        const data = await response.json();
        return data;
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// User display mode, shows user data, post upload option and all posts
// If gets user params, display user params in user data
function userDisplay(name,lastLogin) {
    if (name) {
        document.getElementById("id-user-data-h2").innerHTML = 'Welcome '+name;
    }
    if (lastLogin) {
        document.getElementById("id-user-data-h5").innerHTML = 'Last Login: '+lastLogin;
    }
    document.getElementById("id-user-data").style.display = "block";
    document.getElementById("id-post-upload").style.display = "block";
    document.getElementById("id-all-posts").style.display = "block";
    document.getElementById("id-logout-button").style.display = "block";
    document.getElementById("id-login-button").style.display = "none";
    document.getElementById("id-filter-by-name").style.display = "none";
}

// Onload calls this function, if session exist change to user display
async function userLogged() {
    try {
        const response = await fetch('rpc/user.rpc.php/?action=check_if_logged', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        });
        const data = await response.json();
        if (data.status) {
            userDisplay(data.name,data.last_login);
            getPostsByUser();
        }
        else {
            getAllPosts();
        }
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// Event listener for upoading post 
var postForm = document.getElementById('id-upload-post-form');
if (postForm) {
    postForm.addEventListener("submit", (event) => {
        event.preventDefault();
        uploadPost();
      });
}

// Send upload post data to post.rpc.php using fetchUploadPost and uploads post
async function uploadPost() {
    const title = document.getElementById('id-post-title').value;
    const body = document.getElementById('id-post-body').value;
    const file = document.getElementById("id-post-file").files[0];

    const params = new FormData();
    params.append('action', 'upload-post');
    params.append('title', title);
    params.append('body', body);
    (file)? params.append('file',  file):null;
    uploadPostStatus = await fetchUploadPost(params);
    if (uploadPostStatus.status) {
        window.location.reload();
    } 
    else {
        document.getElementById("id-upload-post-status").style.color="red";
        document.getElementById("id-upload-post-status").innerHTML = uploadPostStatus.data;
    }
}

async function fetchUploadPost(params) {
    try {
        const response = await fetch('rpc/post.rpc.php', {
            method: 'POST',
            body: params,
        });
        const data = await response.json();
        return data;
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// Get all posts from db and display it using display posts
async function getAllPosts() {
    try {
        const response = await fetch('rpc/post.rpc.php?action=all', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        });
        const data = await response.json();
        displayPosts(data);
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// Get posts by user id from db and display it using display posts
async function getPostsByUser() {
    try {
        const response = await fetch('rpc/post.rpc.php?action=posts-by-userid', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        });
        const data = await response.json();
        displayPosts(data);
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
}

// Building the posts view
function displayPosts(data) {
    const element = document.getElementById("id-blog-container");
    if (element) {
        data.forEach(item => {
            const card = document.createElement("div");
            card.classList.add('c-blog-card');
            element.appendChild(card);
            
            if (item.file_path) {
                const img = document.createElement("img");
                img.classList.add('c-blog-img');
                img.src = "uploads/"+item.user_id+"/"+item.file_path;
                card.appendChild(img);     
            }
            
            const text = document.createElement("div");
            text.classList.add('c-blog-text');
            const h2 = document.createElement("h2");
            const h5 = document.createElement("h5");
            const p = document.createElement("p");
            h2.innerHTML = item.title;
            h5.innerHTML = "<span>"+item.name+"</span>"+"&emsp;"+ item.uploaded_on;
            p.innerHTML = item.body;
            text.appendChild(h2);
            text.appendChild(h5);
            text.appendChild(p);
            card.appendChild(text);
        })
    }
}

// Filter posts by users name
function filterPostsByNameFunc(input) {
    var filter, posts, cards, usersName, i, txtValue;
    if (!input) {
        input = document.getElementById('id-filter-by-name').value;
    }
    filter = input.toUpperCase();
    posts = document.getElementById("id-blog-container");
    cards = posts.getElementsByClassName('c-blog-card');

    // Loop through all posts cards, and hide those who don't match the search query
    for (i = 0; i < cards.length; i++) {
        usersName = cards[i].getElementsByTagName("span")[0];
        txtValue = usersName.textContent || usersName.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        cards[i].style.display = "";
        } else {
        cards[i].style.display = "none";
        }
    }
}

// Logout the user
/***doesnt work - i hide the session destroy in  user class*/
async function userLogout() {
    try {
        fetch('rpc/user.rpc.php/?action=logout', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        });
    }
    catch (error) {
        console.error(`Could not get it: ${error}`);
    }
    //window.location.reload();
}