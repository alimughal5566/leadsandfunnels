/**
 * Created by muhammad on 13/07/2017.
 */

(function ($) {


    $('#toggle-status').change(function() {
        // alert( $(this).prop('checked') );
    })
	
var url = window.location.search;

    if (url == "?libpopup=show") {
console.log(url)
        $("#lp-ol-13").addClass("show");
    }

})(jQuery);
