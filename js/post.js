var post = function() {

    let currentEditPostId = "";

    function uploadPost() {
        // console.log("uploadPost clicked");
        
        let title       = document.getElementById("id-post-title").value;
        let body        = document.getElementById("id-post-body").value;
        let file        = document.getElementById("id-file-to-upload").files[0];
        const formData  = new FormData();
      
        formData.append('title', title);
        formData.append('body', body);
        (file)? formData.append('file', file): null;
      
        // console.log(file);
      
        try {
          nanoajax.ajax({
            url: 'rpc/post.rpc.php/?action=upload-post', 
            method: 'POST', 
            body: formData
          }, function (code, responseText, request) {
            
              if (code === 200) {
      
                // console.log(responseText);
                //display new layout with username at time since login
                var response = JSON.parse(responseText);
          
                document.getElementById("id-upload-post-form").style.display = "none";
      
                document.getElementById("id-success-message").innerHTML      = "Post Uploaded Successfully!"
                
                displayPostsOfUser();
          
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

    function cancelUploadPostClicked() {
        document.getElementById("id-upload-post-form").style.display = "none";
    }

    function deletePostClicked(postId) {
        console.log("Delete post clicked " + postId);
        let text = "Are you sure you want to delete the post?";
        if (confirm(text) == true) {
          deletePost(postId);
        } 
    }
      
      
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
      
                // console.log(responseText);
                //display new layout with username at time since login
                var response = JSON.parse(responseText);
      
                document.getElementById("id-success-message").innerHTML     = "Post Deleted Successfully!"
      
                displayPostsOfUser();
          
              } else {
                  console.error(responseText);
              }
          })
        }
        catch(e) {
          console.error(e);
        }
    }

    function editPostClicked(post_id, title) {
        // console.log("Edit post clicked");
        
        document.getElementById("id-edit-post-title").value = title;
        document.getElementById("id-edit-post-form").style.display = "block";
      
        currentEditPostId = post_id;
      
        //TODO: handle click on "Update Post"
      }
      
      
    function cancelEditPostClicked() {
        document.getElementById("id-edit-post-form").style.display = "none";
    }


    function updatePost() {
        // console.log("uploadPost clicked");
      
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
      
                // console.log(responseText);
                //display new layout with username at time since login
                var response = JSON.parse(responseText);
          
                document.getElementById("id-edit-post-form").style.display = "none";
      
                document.getElementById("id-success-message").innerHTML     = "Post Updated Successfully!"
          
                displayPostsOfUser();
          
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
    function displayAllPosts() {
        try {
          nanoajax.ajax({url:'rpc/post.rpc.php/?action=all'}, function (code, responseText) { 
        
            var response = JSON.parse(responseText);
            
            //TODO: add the function call we want
            
            var results = document.getElementById("id-results");
            var nHTML   = '';
    
            if (searchText !== "")
              response = response.filter(post => post['title'].startsWith(searchText))            
        
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
    
          })
        }
        catch (e) {
          console.error(e);
        }
    }

    function displayPostsOfUser() {
        try {
          nanoajax.ajax({url:'rpc/post.rpc.php/?action=current-user'}, function (code, responseText) { 
      
            document.getElementById("id-post-title").value          = "";
            document.getElementById("id-post-body").value           = "";
            document.getElementById("id-file-to-upload").value      = "";
            document.getElementById("id-search-text").style.display = "none";
          
            var response = JSON.parse(responseText);
            console.log(response);
        
            var results = document.getElementById("id-results");
            var nHTML   = '';
            
            for (var i = 0; i < response.length; i++) {
                nHTML += '<div class="c-post"> <details> <summary>' + response[i]['title'];
                nHTML += '<button id="id-edit-button" class="c-title-button" onClick="post.editPostClicked('
                          + response[i]['id'] + ',' + '\'' + response[i]['title'] + '\'' + ')">Edit</button>'
                nHTML += '<button id="id-delete-button" class="c-title-button" onClick="post.deletePostClicked(' 
                          + response[i]['id'] + ')">Delete</button>'
                if (response[i]['file_path'])
                {
                  nHTML += '<br><img src="' + response[i]['file_path'] + '" height=200 width=300 />'
                }
                nHTML += '</summary> <br>';
                nHTML += response[i]['body'];
                // nHTML += '<hr>';
                nHTML += '</details> </div>'
             }
          
             results.innerHTML = nHTML;
          })
        }
        catch (e) {
          console.error(e);
        }
    }
      

    return {
        uploadPost, cancelUploadPostClicked, deletePostClicked, deletePost, 
        editPostClicked, cancelEditPostClicked, updatePost, displayAllPosts, displayPostsOfUser
    }
}();