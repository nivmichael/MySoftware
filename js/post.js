var post = (function () {
  function createPost(event) {
    event.preventDefault();

    let titleElement = document.getElementById("id-post-title-form");
    let bodyElement = document.getElementById("id-post-body-form");
    let messageElement = document.getElementById("id-message-create-blog");

    const input = document.getElementById("id-image-file");
    const formData = new FormData();

    if (input.files.length > 0) {
      formData.append("file", input.files[0]);
    }

    formData.append("title", event.target.title.value);
    formData.append("body", event.target.body.value);

    nanoajax.ajax(
      {
        url: `/rpc/post.rpc.php?action=${BLOG_ACTIONS.CREATE_POST}`,
        method: "POST",
        body: formData,
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

          let filePath = "";
          for (const post of blogs) {
            // Display all blogs
            // Check if post.file_name is not null or not undefined
            if (post.file_name != null) {
              // Split the file_name by '_' char
              const strArr = post.file_name.split("_");
              // File path example: ../uploads/posts/31/31_editLogo.jpeg
              filePath = `${filePostPath}${post.post_id}/${post.post_id}_${strArr[2]}`;
            }
            // Create Post Element and add it to all posts
            allPostsElement.innerHTML += createPostElement(
              filePath,
              post,
              loggedIn
            );
          }
        } catch (e) {
          console.log("getAllPosts error:" + e);
        }
      }
    );
  }

  function updatePost(event, postId) {
    event.preventDefault();
    const postElement = document.getElementById(`id-post-${postId}`);

    const titleInputElement = postElement.querySelector("#id-post-title-input");
    const bodyInputElement = postElement.querySelector("#id-post-body-input");
    const updateMessageElement = postElement.querySelector(
      "#id-message-update-post"
    );

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
  function createPostElement(filePath, post, loggedIn) {
    return `
       <div id="id-post-${post.post_id}" class="c-column">
            ${userSignedInElements(post, loggedIn)}
            <div class="c-post">
              <h3 >Title: ${post.title}</h3>
              <p>Body: ${post.body}</p>
              <div>
                ${postImageElement(filePath)}
              </div>
            </div>
       </div>
       `;
  }

  function userSignedInElements(post, loggedIn) {
    return loggedIn
      ? `<div class="c-icons">
            <button class="c-icon-button" onclick="post.setElementsEditable('${post.post_id}','${post.title}', '${post.body}')">
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
      deletePost(event, post_id);
    }
  }

  function setElementsEditable(id, title, body) {
    // Convert the post elements to editable inputs
    let postElement = document.getElementById(`id-post-${id}`);
    if (postElement) {
      postElement.innerHTML = `
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

  function postImageElement(filePath) {
    return filePath
      ? `<div>
            <img src=${filePath} alt="Post Image" width="200" height="145">
          </div>
        `
      : ``;
  }

  return {
    setElementsEditable,
    postImageElement,
    createPostElement,
    showConfirmMessage,
    createPost,
    updatePost,
    deletePost,
    getAllPosts,
  };
})();
