;(function (){
  // An IIFE to prvent global variable polution
  
  /**
   * This module extends cogoToast to prevent exact same
   * message from showing multiple times.
   * As it over-rides the original cogoToast library, it should
   * be loaded after cogoToast library but before saving any 
   * references to original cogoToast
   */

  // return early if cogoToast library is not loaded
  if(!lptoast || typeof lptoast.cogoToast !== 'function'){
    return;
  }
  
  // backup original toaster to call within our extender
  var origToast = lptoast.cogoToast;
  // keeps a track of currently shown toast message
  var shownToasts = {};

  // normal reading speed in words per minute
  var wpm = 150;

  /**
   * This constructor extends original cogoToast to prevent
   * identical messages from showing multiple times
   * @param {string} text message text
   * @param {object} options options object passed to cogoToast
   */
  function cogoToast(text, options){
    
    // fallback to empty object if options are not given
    options = options ? options : {};

    // lets make a unique key to identify toast message
    // based on passed message content
    var key = options.type ? options.type : '';
    key += options.heading ? options.heading : '';
    key += text ? text : '';

    // if an empty message is given, just fallback to toast default behaviour
    if(!key){
      return origToast.apply(this, arguments);
    }

    // if toast message is currently showing, just reurn previous promise
    if(shownToasts.hasOwnProperty(key)){
      return shownToasts[key];
    }

    // if hide time is not specified, we would calulate it based on
    // number of words in message
    if(!options.hasOwnProperty('hideAfter')){
      // we calculate hide time by splitting message with spaces
      // then diving the number of words in message by normal reading
      // speed in words per second (wpm / 60) where wpm is words per minute
      // then we compare it with cogoToast default hide time of 3 seconds
      // and we take the greater of both values to be the resultant hdie time
      options.hideAfter = Math.max(key.split(/\s/).length / (wpm / 60), 3);
    }

    // calling original toast with passed arguments
    var promise = origToast.apply(this, arguments);
    
    // caching currently shown toast to detect on next call
    shownToasts[key] = promise

    // delete cached toast if it is hiding
    promise.then(function(){
      delete shownToasts[key]
    })

    // return original returned promise
    return promise;
  }

  // default cogoToast method names
  var methodNames = ['success','warn','info','error','loading'];

  methodNames.forEach(function(name) {
    // over-riding original cogoToast method calls with calls to
    // our extended cogoToast
    cogoToast[name] = function(text, options){
      // fallback to empty object if not given
      options = options ? options : {};
      // provide current message type
      options.type = name;
      // call our extended cogoToast with provided options
      return cogoToast.call(this, text, options);
    }
  })

  // override original cogoToast with our extended cogoToast
  window.lptoast = {cogoToast : cogoToast};
})();