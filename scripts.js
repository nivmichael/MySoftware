nanoajax.ajax({url:'https://jsonplaceholder.typicode.com/posts'}, function (code, responseText) { 
    ans = JSON.parse(responseText)
    ans = ans.filter(startWithE);
    
    // console.log(ans)

    var results = document.getElementById("results");
    var nHTML = '';

    for (var i = 0; i < ans.length; i++) {
        nHTML += '<div class="item">' + ans[i]['title'];
        nHTML += '<br>';
        nHTML += '<p id="' + i + '" style="display: none;">' + ans[i]['body'] + '</p>';
        nHTML += '<button onclick="showBody(' + i + ')">Show Body</button>';
        // nHTML += '<hr>';
        nHTML += '</div>'
     }

     results.innerHTML = nHTML;
})


function startWithE(post) {
    return post['title'][0] === 'e' || post['body'][0] === 'E';
  }


function showBody(i) {
    document.getElementById(i).style.display = 'block';
    
}


// Show login popup when button is clicked
document.getElementById("loginBtn").addEventListener("click", function() {
    document.getElementById("loginPopup").style.display = "block";
  });
  
  // Hide login popup when user clicks outside of it
  window.addEventListener("click", function(event) {
    if (event.target == document.getElementById("loginPopup")) {
      document.getElementById("loginPopup").style.display = "none";
    }
  });