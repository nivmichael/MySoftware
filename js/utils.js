var util = function () {

    function sendAjax(url, callBackFN, method = 'GET', body = null,
     errHandling = (err,res)=> {console.error(err); console.error(res);}, errHandlingMsg = 'Response Code is not OK!' ) {
        body = JSON.stringify(body);

        wrapFn = (code, res) => {
            try {
                if (code != RES_CODE.OK ) {
                    let err = new Error(errHandlingMsg);
                    errHandling(err,res);
                    return;                                        
                }
                callBackFN(code, res);

            } catch (e) {
                errHandling(e,res);
            };
        };

        nanoajax.ajax({ url, body, method }, wrapFn);
    }

    return {
        sendAjax
    }

}();