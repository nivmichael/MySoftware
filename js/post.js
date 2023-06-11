var post = (function () {
  function createPost(event) {
    event.preventDefault();

    var messageElement = document.getElementById("id-message-create-blog");
    var titleElement = document.getElementById("id-post-title-form");
    var bodyElement = document.getElementById("id-post-body-form");

    const req = {
      title: event.target.title.value,
      body: event.target.body.value,
    };
    const json = JSON.stringify(req);

    nanoajax.ajax(
      {
        url: `/rpc/post.rpc.php?action=${BLOG_ACTIONS.CREATE_POST}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        body: json,
      },
      function (code, responseText, request) {
        try {
          var response = JSON.parse(responseText);
          // Hide error
          messageElement.textContent = "";

          if (response.status) {
            alert(response.msg);
            titleElement.value = "";
            bodyElement.value = "";
            getAllPosts(true);
          } else {
            messageElement.textContent = response.msg;
          }
        } catch (e) {
          console.log("createPost error:" + e);
        }
      }
    );
  }

  function getAllPosts(loggedIn) {
    nanoajax.ajax(
      {
        url: `/rpc/post.rpc.php?action=${BLOG_ACTIONS.GET_POSTS_BY_USER_ID}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "GET",
      },
      function (code, responseText, request) {
        try {
          const response = JSON.parse(responseText);
          const blogs = response.data;

          if (!blogs) {
            // TODO
          }

          let allPostsElement = document.getElementById("id-posts");
            
          allPostsElement.innerHTML = ``;
          for (const post of blogs) {
            // Display all blogs
            allPostsElement.innerHTML += createPostElement(post, loggedIn);
          }
        } catch (e) {
          console.log("isLogin error:" + e);
        }
      }
    );
  }

  function updatePost(event, postId) {
    event.preventDefault();
    const postElement = document.getElementById(`id-post-${postId}`);

    const titleInputElement = postElement.querySelector("#id-post-title-input");
    const bodyInputElement = postElement.querySelector("#id-post-body-input");
    const updateMessageElement = postElement.querySelector("#id-message-update-post");

    const req = {
      id: postId,
      title: titleInputElement.value,
      body: bodyInputElement.value,
    };

    const json = JSON.stringify(req);

    nanoajax.ajax(
      {
        url: `/rpc/post.rpc.php?action=${BLOG_ACTIONS.UPDATE_POST}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        body: json,
      },
      function (code, responseText, request) {
        try {
          var response = JSON.parse(responseText);
          // Hide error
          updateMessageElement.textContent = "";

          if (response.status) {
            getAllPosts(true);
            alert(response.msg);
          } else {
            updateMessageElement.textContent = response.msg;
          }
        } catch (e) {
          console.log("updatePost error:" + e);
        }
      }
    );
  }

  function deletePost(event, postId) {
    event.preventDefault();

    const postElement = document.getElementById(`id-post-${postId}`);

    const req = {
      id: postId,
    };

    const json = JSON.stringify(req);

    nanoajax.ajax(
      {
        url: `/rpc/post.rpc.php?action=${BLOG_ACTIONS.DELETE_POST}`,
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        body: json,
      },
      function (code, responseText, request) {
        try {
          var response = JSON.parse(responseText);

          if (response.status) {
            getAllPosts(true);
            alert(response.msg);
          } else {
            alert(response.msg);
          }
        } catch (e) {
          console.log("deletePost error:" + e);
        }
      }
    );
  }

  // Creates a post element with a title and body
  function createPostElement(post, loggedIn) {
    return `
       <div id="id-post-${post.post_id}" class="c-column">
            ${userSignedInElements(post, loggedIn)}
            <div class="c-post">
              <h3 >Title: ${post.title}</h3>
              <p>Body: ${post.body}</p>
            </div>
       </div>
       `;
  }

  function userSignedInElements(post, loggedIn) {
    return loggedIn
      ? `<div class="c-icons">
            <button class="c-icon-button" onclick="post.setElementsEditable(event,'${post.post_id}','${post.title}', '${post.body}')">
              <img src="./assets/icons/editIcon.svg" alt="view icon">
            </button>
            <button class="c-icon-button" onclick="post.showConfirmMessage(event, '${post.post_id}')">
              <img src="./assets/icons/deleteIcon.svg" alt="view icon">
            </button>
        </div>
        `
      : ``;
  }

  function showConfirmMessage(event, post_id) {
    var result = confirm("Want to delete?");
    if (result) {
      //Logic to delete the item
      deletePost(event,  post_id);
    }
  }

  function setElementsEditable(event, id, title, body) {
    // Convert the post elements to editable inputs
    console.log(`id-post-${id}`);
    let elem = document.getElementById(`id-post-${id}`);
    if (elem) {
      // elem.innerHTML = 'asdasdas'
      elem.innerHTML = `
      
            <input id="id-post-title-input" class="c-post-form-input" name="updated-title" type="text" value="${title}">        
            <textarea id="id-post-body-input" class="c-post-form-input" name="updated-body" type="text">${body}</textarea>
    
            <div id="id-message-update-post" class="c-message"></div>
            <button id="id-done-button" class="c-icon-button" onclick="post.updatePost(event, ${id})">
              <img src="./assets/icons/doneIcon.svg" alt="view icon">
          </button>
        `;
    } else {
      console.log("NO element");
    }
  }

  return {
    setElementsEditable,
    createPostElement,
    showConfirmMessage,
    createPost,
    updatePost,
    deletePost,
    getAllPosts
  };
})();
