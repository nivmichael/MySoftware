var blog = function () {
    const blogsContainerId = 'id-blogs-container';


    function createBlog(ev) {
        ev.preventDefault();
        const body = JSON.stringify({ text: ev.target.elements.blogtext.value, title: ev.target.elements.blogtitle.value });
        nanoajax.ajax({ url: url + actions.addBlog, body, method: 'POST' }, function (code, res) {
            try {
                if (code != RES_CODE.OK) {
                    // Display Error Msg
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

    function getBlogInnerHtml(blog) {
        return `
        <div class="c-blog-card">
            <div class="c-blog-title">
                ${blog.title}
            </div>
            <div class="c-blog-text">
                ${blog.text}
            </div>
            <div class="c-blog-bottom c-flex-row-center">
                <div class="c-blog-btns">
                    <button class="c-blog-btn c-edit">Edit</button>
                    <button class="c-blog-btn c-delete">Delete</button>
                </div>
                <div class="c-blog-creator">
                    Created By: ${blog.created_by}
                </div>
            </div>
        </div>`;
    }

    function setBlogs() {
        nanoajax.ajax({ url: url + actions.getBlogs }, function (code, res) {
            try {
                if (code != RES_CODE.OK || !res) {
                    return;
                }
                let blogs = JSON.parse(res);
                console.log(blogs);
                let blogsInnerHtml = '';
                for (const blog of blogs) {
                    blogsInnerHtml += getBlogInnerHtml(blog)
                }
                let element = document.getElementById(blogsContainerId);
                element.innerHTML = blogsInnerHtml;


            } catch (error) {
                console.error(`error in getBlogs(): ${error}`);
            }
        })
    }


    return {
        setBlogs,
        createBlog
    }

}();
