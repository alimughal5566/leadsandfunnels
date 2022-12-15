$(document).ready(function() {

    //*
    // ** Validation Js Account Page
    // *

    $('#add-seo').validate({
        rules: {
            title__tag: {
                required: true

            },
            seo__desc: {
                required: true,
                minlength:100
            }
        },
        messages: {
            title__tag: {
                required: "Please enter your title tag."
            },
            seo__desc: {
                required: "Please enter your description.",
                minlength:"Please enter more than 100 letters."
            }
        },
        debug: true,
        submitHandler: function () {
            console.info('submitted');
        }
    });

});

