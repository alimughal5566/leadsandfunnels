

$(document).ready(function() {

    var $form = $("#reset-password-form"),
        $successMsg = $(".alert");
    $form.validate({
        rules: {
            password: {
                required: true,
            },
            password2: {
                required: true,
            }
        },
        messages: {
            password: {
                required: "Please enter new password"
            },
            password2: {
                required: "Please re-type new password"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).on('click' , '#reset-password-btn' ,function(e){
        e.preventDefault();
        $("#reset-password-form").submit();
    });



    
    if ( getUrlParameter("ok") == "no" ) {
        incorrectLoginNotice();
    }

    // Submit the form with enter key
    $("form input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            var target_ele="";
            if("" != $("#pw").val()){
                target_ele="#lb1";
            }else if("" != $("#password").val()){
                target_ele="#emmaLoginBtn";
            }
            //$( this ).parent().find("a:first-of-type").click();
            $(target_ele).click();
            return false;
        } else {
            return true;
        }
    }); 
});

function validEmail(str){
    var patt= /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;
    var check = patt.test(str);
    if(check){
        return true;
    }else{
        return false;
    }
}

function incorrectLoginNotice(){
    console.log("incorrectLoginNotice calll");
    return;
    var incorrectLoginNoticeHtml = 
        "<div id='incorrectLoginDiv' >" + 
            "<p>Incorrect username/password</p>" + 
            "<img src='images/x_sign_icon_red.png' style='display:inline-block;' height='100' width='100' alt='Success'>" +
            "<a href='#' onclick='showLoginBox(event)' class='loginButton' style='display:block; width:90%;'>OK</a>" +
        "</div>";
    $("#login1 > *").css("display","none");
    $("#login1").append(incorrectLoginNoticeHtml);
}

function showLoginBox(event){
    $("#login1 > div#incorrectLoginDiv").detach();
    $("#login1 > *").css("display","inline");
    event.preventDefault();
}


function validateEmail(fld) {
    var error = false;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(fld)) {
        error = true;
    }
    return error;
}


function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}
