

export function validateUrl(domainName) {
    if (domainName!= null && domainName!= undefined) {
        var pattern = new RegExp(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|\/\/)?[A-Za-z0-9]+([\-\.]{1}[A-Za-z0-9]+)*\.[A-Za-z]{2,63}(:[0-9]{1,5})?(\/.*)?$/, 'i');
        return pattern.test(domainName);
    }
    else {
        return false;
    }
}


// https://stackoverflow.com/a/1547940
export function validateUrlPath(path) {
    if (path) {
        const regex = /^\/([A-Za-z0-9-._~:/?#\[\]@!$&'()*+,;=/]|%[0-9a-fA-F]{2})*$/
        return regex.test(path);
    }
    else {
        return false;
    }
}


export const notify = {
    success: (message, options = { heading: 'Success' } ) => lptoast.cogoToast.success(message, options),
    info   : (message, options = { heading: 'Info' } ) => lptoast.cogoToast.info(message, options),
    warn   : (message, options = { heading: 'Warning' } ) => lptoast.cogoToast.warn(message, options),
    error  : (message, options = { heading: 'Error' } ) => lptoast.cogoToast.error(message, options),
}


export function unserialize(serializedString){
    var str = decodeURI(serializedString);
    var pairs = str.split('&');
    var obj = {}, p, idx;
    for (var i=0, n=pairs.length; i < n; i++) {
        p = pairs[i].split('=');
        idx = p[0]; 
        if (obj[idx] === undefined) {
            obj[idx] = unescape(p[1]).replace ( /\+/g, ' ' );
        }else{
            if (typeof obj[idx] == "string") {
                obj[idx]=[obj[idx]];
            }
            obj[idx].push(unescape(p[1]).replace ( /\+/g, ' ' ));
        }
    }
    return obj;
}


// https://stackoverflow.com/a/1173319
export function selectText(containerid) {
    if (document.selection) { // IE
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select();
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
    }
}


// https://stackoverflow.com/a/2901298
export function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}