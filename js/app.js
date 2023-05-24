// TODO: Save UserID In global Var

var app = function () {

    function onInit() {
        // check if user-is-logged-in => {yes-go to blogs | no- stay} 
        nanoajax.ajax({ url: url + actions.isLoggedIn }, function (code, res) {
            let currSection = SECTIONS.LOGIN;
            if (code != RES_CODE.OK || !res) {
                displaySection(currSection);
                return;
            }

            res = JSON.parse(res);

            if (res.logged_in) {
                currSection = SECTIONS.BLOGS;
            }

            displaySection(currSection);

        })
        blog.setBlogs();
    }

    function displaySection(sectionId) {
        // Hide all sections
        for (const key in SECTIONS) {
            hideSection(SECTIONS[key]);
        }
        // show my section
        showSection(sectionId);
    }

    function showSection(sectionId) {
        let element = document.getElementById(sectionId);
        element.classList.add(DISPLAY_CLASS);
        element.classList.remove(HIDE_CLASS);
    }

    function hideSection(sectionId) {
        let element = document.getElementById(sectionId);
        element.classList.add(HIDE_CLASS);
        element.classList.remove(DISPLAY_CLASS);
    }

    return {
        onInit,
        displaySection
    }

}();