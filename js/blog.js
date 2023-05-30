var blog = function () {

    function fileChanged(event) {
        event.preventDefault();
        const filename = event.target?.files?.item(0)?.name
        if (filename) {
            document.getElementById(ELEM_ID.filenameInput).innerHTML =  filename;
        }
    }

    function createBlog(ev) {
        ev.preventDefault();
        const body = JSON.stringify({ text: ev.target.elements.blogtext.value, title: ev.target.elements.blogtitle.value });
        const file = document.getElementById("id-upload-image").files[0];
    
        const formData = new FormData();
        formData.append('body', body);
        formData.append('file', file);

        nanoajax.ajax({ url: blogUrl + actions.addBlog, body: formData, method: 'POST' }, function (code, res) {
            try {
                if (code != RES_CODE.OK) {
                    document.getElementById(ELEM_ID.errBlogMsg).innerHTML = res;
                    return;
                }
                
                ev.target.elements.blogtext.value = '';
                ev.target.elements.blogtitle.value = '';
                document.getElementById(ELEM_ID.filenameInput).innerHTML =  '';
                let htmlBlog = getBlogInnerHtml(JSON.parse(res));
                let element = document.getElementById(ELEM_ID.blogsContainer);
                let html = htmlBlog + element.innerHTML;
                element.innerHTML = html;
            } catch (e) {
                console.error(`error in loginUser(): ${e}`);
            }
        })
    }

    function displayBtns() {
        app.toggleVisibility()
    }

    function getEditBlogHtml(blogText, blogTitle) {
        return `
        <h2>Edit</h2>
        <a class="close" onclick="app.closePopup('${ELEM_ID.popupOverlay}')" >&times;</a>
        <div class="content">
            <form class="c-form-container">
              <label for="blogtitle"><b>Blog Title</b></label>
              <input id="id-blog-text" class="c-login-input" type="text" placeholder="Enter Title" name="blogtitle" value="${blogText}" required>
              <label for="blogtext"><b>Blog Text</b></label>
              <input id="id-blog-title" class="c-login-input" type="text" placeholder="Enter Blog Text" name="blogtext" value="${blogTitle}" required>
            </form>
            <div class="c-popup-btns">
                <button onclick="app.closePopup('${ELEM_ID.popupOverlay}')" class="c-blog-btn c-blue">Cancel</button>
                <button onclick="app.submitPopup('${ELEM_ID.popupOverlay}')" class="c-blog-btn ">Submit</button>
            </div>
        </div>
     `;
    }

    function getDeleteBlogHtml() {
        return `
        <h2>Delete</h2>
        <a class="close" onclick="app.closePopup('${ELEM_ID.popupOverlay}')">&times;</a>
        <div class="content">
          Are you sure you want to delete it?
        </div>
        <div class="c-popup-btns">
          <button onclick="app.closePopup('${ELEM_ID.popupOverlay}')" class="c-blog-btn c-blue">Cancel</button>
          <button onclick="app.submitPopup('${ELEM_ID.popupOverlay}')" class="c-blog-btn c-delete">Delete</button>
        </div>`;
    }

    function editBlog(ev, blogId, blogText, blogTitle) {
        ev.preventDefault();
        document.getElementById(ELEM_ID.popupContent).innerHTML = getEditBlogHtml(blogText, blogTitle);
        app.openPopup(ELEM_ID.popupOverlay, (blog) => {
            let fn = (code, res) => {
                setBlogs();
            }
            const body = { blog_id: blogId, text: blog.text, title: blog.title };
            util.sendAjax(blogUrl + actions.editBlog, fn, 'POST', body);
        }, () => {
            let title = document.getElementById(ELEM_ID.blogTitle).value;
            let text = document.getElementById(ELEM_ID.blogText).value;
            return { title, text };
        });
    }

    function deleteBlog(ev, blogId) {
        ev.preventDefault();
        document.getElementById(ELEM_ID.popupContent).innerHTML = getDeleteBlogHtml();

        app.openPopup(ELEM_ID.popupOverlay, () => {
            let fn = (code, res) => {

                if (code != RES_CODE.OK || !res) {
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
            <div class="c-blog-img-container">
              <img class="c-blog-img" src="/images/${blog.id}.${blog.file_ext}" alt="no image exists">
            </div>  
            <div class="c-blog-bottom c-flex-row-center">
                <div class="c-blog-btns ${user.isLoggedIn() ? '' : 'c-hidden'}">
                    <button onclick="blog.editBlog(event, ${blog.id}, '${blog.text}' , '${blog.title}' )" class="c-blog-btn c-edit">Edit</button>
                    <button onclick="blog.deleteBlog(event, ${blog.id})" class="c-blog-btn c-delete">Delete</button>
                </div>
                <div class="c-blog-creator">
                    Created By: ${blog.username}
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
                let element = document.getElementById(ELEM_ID.blogsContainer);
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
        fileChanged
    }

}();
