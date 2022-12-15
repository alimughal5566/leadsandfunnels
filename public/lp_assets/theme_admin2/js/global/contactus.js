var msg;
$(document).ready(function() {
    $('.close').click(function() {
        $("#alert-danger").find('span').text("");
        $('.alert').hide();
    });
    /*if($('#footereditor').length > 0){
        // CK editor
        CKEDITOR.replace( 'footereditor' );
    }*/

    window.footereditor =  $('.footereditor').froalaEditor({

        key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
        fontFamily: font_object,
        // Set the image upload URL.
        imageUploadURL: site.baseUrl+'/lp/popadmin/footerimageupload',

        // Additional upload params.
        imageUploadParams: {
            id: 'footer_image',
            uploadtype: jQuery("#uploadtype").val(),
            current_hash: jQuery("#current_hash").val(),
            client_id: jQuery("#client_id").val(),
            _token: ajax_token
        },

        // Set request type.
        imageUploadMethod: 'POST',

        // Set request type.
        /* 4 MB */
        imageMaxSize: 1024 * 1024 * 4,

        // Allow to upload PNG and JPG.
        imageAllowedTypes: ['gif', 'jpeg', 'jpg', 'png']
    });
    window.footereditor.on('froalaEditor.image.beforeUpload', function(e, editor, images) {
        // Return false if you want to stop the image upload.
        console.log(images);
    });
    window.footereditor.on('froalaEditor.image.uploaded', function(e, editor, response) {
        // Image was uploaded to the server.
        console.info("test");
        console.log(response);
    });
    window.footereditor.on('froalaEditor.image.inserted', function(e, editor, $img, response) {
        // Image was inserted in the editor.
        console.log($img);
        console.log(response);
    });
    window.footereditor.on('froalaEditor.image.replaced', function(e, editor, $img, response) {
        // Image was replaced in the editor.
        console.log($img);
        console.log(response);
    });
    window.footereditor.on('froalaEditor.image.error', function(e, editor, error, response) {
        // Bad link
        console.log("error code is "+error.code +" and error message is "+error.message);
    });
    window.footereditor.on('froalaEditor.image.removed', function(e, editor, $img) {
        $.ajax({
            // Request method.
            method: "POST",

            // Request URL.
            url: site.baseUrl+'/lp/popadmin/footerimageremove',

            // Request params.
            data: {
                src: $img.attr('src'),
                current_hash: jQuery("#current_hash").val(),
                _token: ajax_token
            }
        })
            .done(function(data) {
                console.log('image was deleted');
            })
            .fail(function() {
                console.log('image delete problem');
            })
    });

    $('.gfooter-toggle').change(function() {
        if ($(this).prop('checked') == true) {
            $('#'+$(this).data('field')).val('y');
        }else {
            $('#'+$(this).data('field')).val('n');
        }
        $("#gfot-ai-flg").val('1');
        
    });

    mytoggledestination();
});
function mytoggledestination() {
    var thelink = $('#linktype').val();
    if(thelink == 'u') {
        $('#theselection').val('u');
        $('#webmodal').hide();
        $('#webaddress').show();
    }
    else if (thelink == 'm') {
        $('#theselection').val('m');
        $('#webaddress').hide();
        $('#webmodal').show();
    }
    else {
        $(".lp-auto-responder .lp-pp-box").css("padding-bottom","10px");
        $('#webaddress').hide();
        $('#webmodal').hide();
    }
}

function saveglobalcontactus() {
    msg = '';
    var error=false;
    if ($("#lpkey_contactus").val() == '') {
        msg  = "Please Select Funnel From List.<br>";
        error=true;
    }
    // var html = CKEDITOR.instances["footereditor"].getData();
    var html = footereditor.froalaEditor('html.get');
    theurl = $('#theurl').val();
    if($('#linktype').val() == '-1') {
        msg  += "Choose your option and enter the appropriate data before saving.<br>";
        error=true;
    }
    if($('#linktype').val() == 'u' && ($('#theurl').val() == "" || $('#theurltext').val() == "")) {
        msg  += "Choose your option and enter the appropriate data before saving.<br>";
        error=true;
    }
    if(html == "" && $('#linktype').val() == 'm') {
        msg  += "Choose your option and enter the appropriate data before saving.<br>";
        error=true;
    }
    if ($('#linktype').val() == 'u' && ((theurl.toLowerCase().indexOf("http://") < 0) && (theurl.toLowerCase().indexOf("https://") < 0))){
        msg  += "Please enter the correct url including http.";
        error=true;
    }
    if(error===false){
        $('#gffooter').submit();
    }else {
        errormessage();
    }
}
function errormessage(){
    $("#alert-danger").find('p').html(msg);
    $("#alert-danger").fadeIn("slow");
    return false;
}

