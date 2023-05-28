var blog = function () {
    const blogsContainerId = 'id-blogs-container';

    function createBlog(ev) {
        ev.preventDefault();
        const body = JSON.stringify({ text: ev.target.elements.blogtext.value, title: ev.target.elements.blogtitle.value });
        nanoajax.ajax({ url: blogUrl + actions.addBlog, body, method: 'POST' }, function (code, res) {
            try {
                if (code != RES_CODE.OK) {
                    //TODO: Display Error Msg
                    return;
                }
                let htmlBlog = getBlogInnerHtml(JSON.parse(res));
                let element = document.getElementById(blogsContainerId);
                let html = htmlBlog + element.innerHTML;
                element.innerHTML = html;
            } catch (e) {
                console.error(`error in loginUser(): ${error}`);
            }
        })
    }

    function displayBtns() {
        app.toggleVisibility()
    }

    function getEditBlogHtml(blogText, blogTitle) {
        return `
        <h2>Edit</h2>
        <a class="close" onclick="app.closePopup('id-popup-overlay')" >&times;</a>
        <div class="content">

        <form class="c-form-container">
          <label for="blogtitle"><b>Blog Title</b></label>
          <input id="id-blog-text" class="c-login-input" type="text" placeholder="Enter Title" name="blogtitle" value="${blogText}" required>

          <label for="blogtext"><b>Blog Text</b></label>
          <input id="id-blog-title" class="c-login-input" type="text" placeholder="Enter Blog Text" name="blogtext" value="${blogTitle}" required>
        </form>

        <div class="c-popup-btns">
        <button onclick="app.closePopup('id-popup-overlay')" class="c-blog-btn c-blue">Cancel</button>
        <button onclick="app.submitPopup('id-popup-overlay')" class="c-blog-btn ">Submit</button>
      </div>

        </div>
     `;
    }

    function blabla(params) {
        ev.preventDefault();
        console.log("blabla");
        console.log(params);
    }

    function getDeleteBlogHtml() {
        return `
        <h2>Delete</h2>
        <a class="close" onclick="app.closePopup('id-popup-overlay')">&times;</a>
        <div class="content">
          Are you sure you want to delete it?
        </div>
        <div class="c-popup-btns">
          <button onclick="app.closePopup('id-popup-overlay')" class="c-blog-btn c-blue">Cancel</button>
          <button onclick="app.submitPopup('id-popup-overlay')" class="c-blog-btn c-delete">Delete</button>
        </div>`;
    }

    function editBlog(ev, blogId, blogText, blogTitle) {
        ev.preventDefault();
        document.getElementById('id-popup-conent').innerHTML = getEditBlogHtml(blogText, blogTitle);
        app.openPopup('id-popup-overlay',(blog) => {
            let fn = (code, res)=>{
                console.log(code, res);
                setBlogs();
            }
            const body = { blog_id: blogId, text: blog.text, title: blog.title };
            util.sendAjax(blogUrl + actions.editBlog, fn, 'POST', body);
        } , ()=>{
            let title = document.getElementById('id-blog-title').value;
            let text = document.getElementById('id-blog-text').value;
            return {title,text};
        } );
    }

    function deleteBlog(ev, blogId) {
        ev.preventDefault();
        document.getElementById('id-popup-conent').innerHTML = getDeleteBlogHtml();

        app.openPopup('id-popup-overlay', () => {
            let fn = (code, res) => {
                if (code != RES_CODE.OK || res !== "1") {
                    // id-msg-container
                    // TODO: Display Error Msg
                    return;
                }
                app.removeElement(`id-blog-${blogId}`);
            };
            const body = { blog_id: blogId };
            util.sendAjax(blogUrl + actions.deleteBlog, fn, 'POST', body);
        });
    }

    function getBlogInnerHtml(blog) {
        return `
        <div id="id-blog-${blog.id}" class="c-blog-card">
            <div class="c-blog-title">
                ${blog.title}
            </div>
            <div class="c-blog-text">
                ${blog.text}
            </div>
            <div class="c-blog-bottom c-flex-row-center">
                <div class="c-blog-btns ${user.isLoggedIn() ? '' : 'c-hidden'}">
                    <button onclick="blog.editBlog(event, ${blog.id}, '${blog.text}' , '${blog.title}' )" class="c-blog-btn c-edit">Edit</button>
                    <button onclick="blog.deleteBlog(event, ${blog.id})" class="c-blog-btn c-delete">Delete</button>
                </div>
                <div class="c-blog-creator">
                    Created By: ${blog.created_by}
                </div>
            </div>
        </div>`;
    }

    function setBlogs() {
        nanoajax.ajax({ url: blogUrl + actions.getBlogs }, function (code, res) {
            try {
                if (code != RES_CODE.OK || !res) {
                    return;
                }
                let blogs = JSON.parse(res);
                let blogsInnerHtml = '';
                for (const blog of blogs) {
                    blogsInnerHtml += getBlogInnerHtml(blog)
                }
                let element = document.getElementById(blogsContainerId);
                element.innerHTML = blogsInnerHtml;


            } catch (error) {
                console.error(`error in setBlogs(): ${error}`);
            }
        })
    }


    return {
        setBlogs,
        createBlog,
        deleteBlog,
        displayBtns,
        editBlog,
        blabla
    }

}();
