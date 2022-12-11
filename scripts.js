const API_URL='https://jsonplaceholder.typicode.com/posts';

// Main function to display items with 'e' in the beginning of the title from api
async function displayItems () {
    const results = document.getElementById("id-results");
    
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
displayItems();

// Open login form popup
function openForm() {
    document.getElementById("id-loginForm").style.display = "block";
}

// Close login form popup
function closeForm() {
    document.getElementById("id-loginForm").style.display = "none";
}

// Event listener for login 
var loginForm = document.getElementById('id-form');
loginForm.addEventListener("submit", (event) => {
    event.preventDefault();
    userLogin();
  });

// Send user login data to user.rpc.php using fetchLogin and shows if login success
async function userLogin() {
    const username = document.getElementById('id-username').value;
    const password = document.getElementById('id-password').value;

    const params = {
        username: username,
        password: password, 
    };
    loginStatus = await fetchLogin(params);

    // Shows if login success
    if (!loginStatus.status) {
        document.getElementById("id-login-status").style.color="red";
    }
    else {
        document.getElementById("id-login-status").style.color="green";
        closeForm();
    }
    document.getElementById("id-login-status").innerHTML = loginStatus.data;
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
