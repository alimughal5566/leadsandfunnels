
/*
 *
 *  Validation Documentation url
 *
 https://jqueryvalidation.org/validate/
 *
 *
 */

// Custom validation
$.validator.addMethod("phone", function(value, element) {
    return this.optional(element) || value == value.match(/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/);
});

// Login form validation

var $form = $("#go"),
    $successMsg = $(".alert");

$form.validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 5
        }
    },
    messages: {
        email: {
            required: "Please enter the email address",
            email:"Please specify a valid email address"
        },
        password: {
            required: "Please enter the password"
        }
    },
    submitHandler: function() {
        alert('ssss');
        $form.submit();
    }

});


// Account Form Validation


var $form = $("#account-form"),
    $successMsg = $(".alert");

$form.validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        notify_mail: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 5
        },
        first_name: {
            required: true,
            letters:true
        },
        last_name:{
            required: true
        },
        company_name: {
            required: true
        },
        office_name: {
            required: true
        },
        cell_phone: {
            required: true,
            phone: true
        },
        address1: {
            required: true
        },
        city: {
            required: true
        },
        state: {
            required: true
        },
        postal_code: {
            required: true
        }
    },
    messages: {
        email: {
            required: "Please enter the email address",
            email:"Please specify a valid email address"
        },
        notify_mail: {
            required: "Please enter the email address",
            email:"Please specify a valid email address"
        },
        password: {
            required: "Please enter the password"
        },
        first_name: "Please enter the first name",
        last_name:"Please enter the last name",
        company_name:"Please enter the company name",
        office_name:"Please enter the office name",
        cell_phone: {
            required: "Please enter the cell phone",
            phone: "Please enter the correct phone"
        },
        address1:"Please enter the address 1",
        city:"Please enter the city",
        state:"Please Select the state",
        postal_code:"Please enter the postal code"

    },
    submitHandler: function(form) {
        form.submit();
    }

});
/*
 *
 // Pixels POPUP validation
 *
 */
var $form = $("#add-code-popup"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        code_name: {
            required: true
        },
        code_placement: {
            required: true
        },
        code: {
            required: true
        }
    },
    messages: {
        code_name: "Please enter the code name",
        code_placement: "Please enter the code placement",
        code: "Please enter the code"
    },
    submitHandler: function(form) {
        form.submit();
    }

});

/*
 *
 // Leads alert POPUP ADD RECIPIENT validation
 *
 */
var $form = $("#recipient_popup"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        re_email: {
            required: true,
            email: true
        },
        re_phone: {
            required: true,
            phone:true
        }
    },
    messages: {
        re_email: "Please specify a valid email address",
        re_phone: {
            required: "Please enter the cell phone",
            phone: "Please enter the correct phone "
        }

    },
    submitHandler: function() {
           

            $('.del').click(function(e){
                e.preventDefault();
                var _self = $(this).parents().eq(3);
                _self.slideUp(200, function() {
                    _self.remove();
                });
            });

    }

});




// Support comment POPUP validation


var $form = $("#add-comment"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        subject: {
            required: true
        },
        comment: {
            required: true
        }
    },
    messages: {
        subject: "Please select the subject.",
        comment:"Please enter the comment."

    },
    submitHandler: function(form) {
        form.submit();
    }

});

// CTA POPUP validation

var $form = $("#ctaform"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        mmainheadingval: {
            required: true,
            minlength: 30
        },
        dmainheadingval: {
            required: true,
            minlength: 50
        }
    },
    messages: {
        mmainheadingval: {
            required:"Please enter the message."
        },
        dmainheadingval: {
            required:"Please enter the description."
        }
    },
    submitHandler: function(form) {
        form.submit();
    }

});

/*
 *
 // contact info form validation
 *
 */
var $form = $("#contact-info"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        company_name: {
            required: true
        },
        phone_number: {
            required: true
        },
        email_address: {
            required: true,
            email:true
        }
    },
    messages: {
        company_name:"please specify the company name",
        phone_number:"Please enter the phone number",
        email_address: "Please specify a valid email address"

    },
    submitHandler: function(form) {
        form.submit();
    }

});

/*
 *
 // SEO form validation
 *
 */
var $form = $("#add-seo"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        seo_title_tag: {
            required: true
        },
        seo_description: {
            required: true,
            minlength:100
        },
        seo_keywords: {
            required: true,
            minlength:50
        }
    },
    messages: {
        seo_title_tag:"please specify the title tag",
        seo_description: {
            required:"Please enter your description",
            minlength:"Write more than 100 letters"
        },
        seo_keywords: {
            required:"Please specify your success keywords",
            minlength:"Enter minimum 50 letter."
        }
    },
    submitHandler: function(form) {
        form.submit();
    }

});

/*
 *
 // Auto responder form validation
 *
 */
var $form = $("#add_autoresponder"),
    $successMsg = $(".alert");
$form.validate({
    rules: {
        msg_subject: {
            required: true
        }
    },
    messages: {
        msg_subject:"please specify the message subject"
    },
    submitHandler: function(form) {
        form.submit();
    }

});
