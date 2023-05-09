var post = function() {

    let currentEditPostId       = "";
    let searchText              = "";
    let getAllPostsResponse     = [];


    //update the search text
    function searchTextChanged() {
        searchText = document.getElementById("id-search-text").value;
        displayAllPosts();
    }

    //make POS request to upload new post
    function uploadPost() {
        // console.log("uploadPost clicked");
        
        let title       = document.getElementById("id-post-title").value;
        let body        = document.getElementById("id-post-body").value;
        let file        = document.getElementById("id-file-to-upload").files[0];
        const formData  = new FormData();
      
        formData.append('title', title);
        formData.append('body', body);
        (file)? formData.append('file', file): null;

        try {
          nanoajax.ajax({
            url: 'rpc/post.rpc.php/?action=upload-post', 
            method: 'POST', 
            body: formData
          }, function (code, responseText, request) {
            
              if (code === 200) {
      
                var response = JSON.parse(responseText);
          
                document.getElementById("id-upload-post-form").style.display = "none";
      
                document.getElementById("id-success-message").innerHTML      = "Post Uploaded Successfully!";
                
                getPostsOfUser();
          
              } else {
                  console.error('Request failed with status ' + code);
                  document.getElementById("id-file-error-msg").innerHTML     =  responseText;
                  document.getElementById("id-file-error-msg").style.display =  "block";
              }
          })
        }
        catch(e) {
          console.error(e);
        }
      
    }

    //hide the upload post popup window
    function cancelUploadPostClicked() {
        document.getElementById("id-upload-post-form").style.display = "none";
    }

    //show popup alert to confirm the deletion of the post
    function deletePostClicked(postId) {
        let text = "Are you sure you want to delete the post?";
        if (confirm(text) == true) {
          deletePost(postId);
        } 
    }
      
    
    //send POST request to delete the post
    function deletePost(postId) {
        const formData  = new FormData();
      
        formData.append('post_id', postId);
      
        try {
          nanoajax.ajax({
            url: 'rpc/post.rpc.php/?action=delete-post', 
            method: 'POST', 
            body: formData
          }, function (code, responseText, request) {
            
              if (code === 200) {
      
                var response = JSON.parse(responseText);
      
                document.getElementById("id-success-message").innerHTML     = "Post Deleted Successfully!";
      
                getPostsOfUser();
          
              } else {
                  console.error(responseText);
              }
          })
        }
        catch(e) {
          console.error(e);
        }
    }

    //display popup window to edit the post title
    function editPostClicked(post_id, title) {
        
        document.getElementById("id-edit-post-title").value = title;
        document.getElementById("id-edit-post-form").style.display = "block";
      
        currentEditPostId = post_id;
    }
      
    //hide the edit post popup window
    function cancelEditPostClicked() {
        document.getElementById("id-edit-post-form").style.display = "none";
    }

    //send POST request to update the post with the new title
    function updatePost() {
        let post_id     = currentEditPostId;
        let title       = document.getElementById("id-edit-post-title").value;
      
        // console.log(post_id);
      
        const formData  = new FormData();
      
        formData.append('post_id', post_id);
        formData.append('title', title);
      
        try {
          nanoajax.ajax({
            url: 'rpc/post.rpc.php/?action=update-post', 
            method: 'POST', 
            body: formData
          }, function (code, responseText, request) {
            
              if (code === 200) {
      
                var response = JSON.parse(responseText);
          
                document.getElementById("id-edit-post-form").style.display = "none";
      
                document.getElementById("id-success-message").innerHTML     = "Post Updated Successfully!";
          
                getPostsOfUser();
          
              } else {
                  console.error('Request failed with status ' + code);
              }
          })
        }
        catch(e) {
          console.error(e);
        }
      
    }

    // Get all a posts and display 
    // How do we make this function use the result from server in different ways:
    // 1. display in DOM (like it's doing now)
    // 2. Print JSON in a dialog
    // Hint - displayAllPosts should recive a variable/something
    function getAllPosts(callbackFunc) {
        try {
          nanoajax.ajax({url:'rpc/post.rpc.php/?action=all'}, function (code, responseText) { 
        
            getAllPostsResponse = JSON.parse(responseText);
            
            //TODO: add the function call we want
            
            
            callbackFunc();
    
          })
        }
        catch (e) {
          console.error(e);
        }
    }


    function displayAllPosts() {

        var results = document.getElementById("id-results");

        var nHTML   = '';

        response = getAllPostsResponse;
    
        if (searchText !== "")
            response = getAllPostsResponse.filter(post => post['title'].startsWith(searchText))            
    
        for (var i = 0; i < response.length; i++) {
            nHTML += '<div class="c-post"> <details> <summary>' + response[i]['title'];
            nHTML += '<p id="id-username-post-text">' + response[i]['username'] + '</p>';
            if (response[i]['file_path'])  
              nHTML += '<br><img src="' + response[i]['file_path'] + '" height=200 width=300 />';
            
            nHTML += '</summary> <br>';
            nHTML += response[i]['body'];
            // nHTML += '<hr>';
            nHTML += '</details> </div> <br>';
        }
    
        results.innerHTML = nHTML;
    }

    //Get posts of current logged in user and display them
    function getPostsOfUser() {
        try {
          nanoajax.ajax({url:'rpc/post.rpc.php/?action=current-user'}, function (code, responseText) { 
      
            document.getElementById("id-post-title").value          = "";
            document.getElementById("id-post-body").value           = "";
            document.getElementById("id-file-to-upload").value      = "";
            document.getElementById("id-search-text").style.display = "none";
          
            var response = JSON.parse(responseText);
            displayPostsOfUser(response);
               
            
          })
        }
        catch (e) {
          console.error(e);
        }
    }

    function displayPostsOfUser(response) {
        var results = document.getElementById("id-results");
        var nHTML   = '';
        
        for (var i = 0; i < response.length; i++) {
            nHTML += '<div class="c-post"> <details> <summary>' + response[i]['title'];
            nHTML += '<button id="id-edit-button" class="c-title-button" onClick="post.editPostClicked('
                        + response[i]['id'] + ',' + '\'' + response[i]['title'] + '\'' + ')">Edit</button>';
            nHTML += '<button id="id-delete-button" class="c-title-button" onClick="post.deletePostClicked(' 
                        + response[i]['id'] + ')">Delete</button>';
            if (response[i]['file_path'])
            {
                nHTML += '<br><img src="' + response[i]['file_path'] + '" height=200 width=300 />';
            }
            nHTML += '</summary> <br>';
            nHTML += response[i]['body'];
            // nHTML += '<hr>';
            nHTML += '</details> </div>';
        }
        
        results.innerHTML = nHTML;
    }

    return {
        searchTextChanged, uploadPost, cancelUploadPostClicked, deletePostClicked, deletePost, 
        editPostClicked, cancelEditPostClicked, updatePost, getAllPosts, displayAllPosts, getPostsOfUser
    }
}();