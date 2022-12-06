const API_URL='https://jsonplaceholder.typicode.com/posts';

// Main function to display items with 'e' in the beginning of the title from api
async function displayItems () {
    const results = document.getElementById("id-results");
    
    let response = await fetchData(); // Call to api
    response = filterLetter(response, 'e'); // Filter letters with 'e' in the beginning of title
    
    // Building the view
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
    const response = await fetch(API_URL)
    return await response.json();
}

// Gets array and letter, returns filtered array of objects with the letter in the beginning of title
function filterLetter(response, letter) {
    return response.filter(item => {
        if (item.title && item.title[0] == letter) {
            return item;
        }})
}

// First call to main function
displayItems()