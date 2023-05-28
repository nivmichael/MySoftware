var util = function () {

    function sendAjax(url, callBackFN, method = 'GET', body = null, errHandling = (err)=> console.error(err), errHandlingMsg = 'Response Code is not OK!' ) {
        body = JSON.stringify(body);

        wrapFn = (code, res) => {
            try {
                if (code != RES_CODE.OK ) {
                    let err = new Error(errHandlingMsg);
                    errHandling(err);
                    return;                                        
                }
                callBackFN(code, res);

            } catch (e) {
                if (!errHandling) {
                    console.error(e);
                    return;
                }
                errHandling(e);
            };
        };

        nanoajax.ajax({ url, body, method }, wrapFn);
    }

    return {
        sendAjax
    }

}();