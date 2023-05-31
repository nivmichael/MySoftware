var app = function () {
    let currFn = null;
    let currParamsFn = null

    //CR: Move to util.ajax -- V
    function onInit() {
        const successFn = (code, res)=>{
            loggedIn = false;
            let currSection = SECTIONS.LOGIN;

            if (res && res.logged_in) {
                loggedIn = true;
                currSection = SECTIONS.BLOGS;
            }

            user.setLogin(loggedIn);
            displaySection(currSection);
            blog.setBlogs();
        }

        const errorFn = (code,err)=>{
            let elem = document.getElementById(ELEM_ID.errLoginMsg);
            if(elem){
                elem.innerHTML = err;
            }
        }

        util.sendAjax(userUrl + actions.isLoggedIn, successFn , null, null , errorFn);

        // nanoajax.ajax({ url: userUrl + actions.isLoggedIn }, function (code, res) {
        //     res = JSON.parse(res);

        //     loggedIn = false;
        //     let currSection = SECTIONS.LOGIN;

        //     if (res && res.logged_in) {
        //         loggedIn = true;
        //         currSection = SECTIONS.BLOGS;
        //     }

        //     user.setLogin(loggedIn);
        //     displaySection(currSection);
        //     blog.setBlogs();
        // })
    }

    
    function displaySection(sectionId) {
        // Hide all sections
        for (const key in SECTIONS) {
            hideSection(SECTIONS[key]);
        }
        // Show my section
        showSection(sectionId);
    }

    function openPopup(elemId, fn, paramsFn = null) {
        currFn = fn;
        currParamsFn = paramsFn;
        let popElem = document.getElementById(elemId);
        popElem.classList.add('c-visible');
    }

    function submitPopup(elemId) {
        let params = null;
        if (currParamsFn) {
            params = currParamsFn();
        }
        currFn(params);
        closePopup(elemId);
    }

    function closePopup(elemId) {
        let popElem = document.getElementById(elemId);
        popElem.classList.remove('c-visible');

    }

    function removeElement(elemId) {
        let element = document.getElementById(elemId);
        if (!element) {
            console.error(`element with id: ${elemId} is not found`);
            return;
        }
        element.remove();
    }

    function toggleVisibility(elemId) {
        const className = 'c-hidden';
        let element = document.getElementById(elemId);
        if (!element.classList.contains(className)) {
            element.classList.add(className);
            return;
        }
        element.classList.remove(className);
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
        displaySection,
        removeElement,
        toggleVisibility,
        openPopup,
        closePopup,
        submitPopup
    }

}();