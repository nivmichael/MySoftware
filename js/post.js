var post = (function () {
  function createPost(event) {
    event.preventDefault();

    var messageElement = document.getElementById("id-message-create-blog");
    var titleElement = document.getElementById("id-title");
    var bodyElement = document.getElementById("id-post-body");

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
            getAllPosts();
          } else {
            messageElement.textContent = response.msg;
          }
        } catch (e) {
          console.log("createPost error:" + e);
        }
      }
    );
  }

  function getAllPosts() {
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
          const blogs =  response.data;

          if (!blogs) {
            // TODO: 
          }

          for (const post of blogs) {
             // Display all blogs
             createPostElement(post);
          }
        } catch (e) {
          console.log("isLogin error:" + e);
        }
      }
    );
  }

    // Creates a post element with a title and body
    function createPostElement(post) {
      var postElement = document.getElementById("id-posts");
      postElement.innerHTML +=`
       <div class="c-column">
           <h3 class="c-column">Title: ${post[2]}</h3>
           <span class="c-column">Body: ${post[3]}</span>
       </div>
       `;
      return postElement;
    }
  return {
    createPost,
    getAllPosts,
  };
})();
