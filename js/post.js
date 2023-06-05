var post = (function() {
  
    function createPost(event) {
        event.preventDefault();

        var messageElement = document.getElementById("id-message-create-blog");
        var titleElement = document.getElementById("id-title");
        var bodyElement = document.getElementById("id-post-body");


        const req = {
            title: event.target.title.value,
            body: event.target.body.value
        }
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

                } else {
                  messageElement.textContent = response.msg;
                }
              } catch (e) {
                console.log("createPost error:" + e);
              }
            }
          );
    }
    return {
        createPost
    };

})();