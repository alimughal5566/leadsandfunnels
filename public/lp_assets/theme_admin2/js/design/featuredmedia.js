
$(document).ready(function(){

	var   globalTimeout;
	$( "body" ).on( "change","#activedeactivebtn" , function() {
        if($(this).is(":checked")) {
        	$("#imagestatus").val("mine");
        	changeimage();
        } else {
        	$("#imagestatus").val("default");
        	changetodefaultimage();
        }
	});


    $("body").on( "change","#logo" , function(e) {
        var filetype = e.target.files[0].type;
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            $('#currentdropimagelogo').attr('src', ''); // Clear the src
            $('#currentdropimagelogo').addClass('hide');
            $("#logo").val("");
            return false;
        }
        var filesize=e.target.files[0].size/1024/1024;
        if(filesize > 2) {
        	alert('The size of image is too large, please try a smaller image.');
            $('#currentdropimagelogo').attr('src', ''); // Clear the src
            $('#currentdropimagelogo').addClass('hide');
            $("#logo").val("");
            return;
        }else {
            $('#currentdropimagelogo').removeClass('hide');
		}
        $('.save_row').show();
    });

	$( "body" ).on( "click","#delfeamed" , function(e) {
		e.preventDefault();
		$(this).prop('disabled', false);
		$('#logo').val("");
		$("#reset_defaultimg").val("no");
		$('#currentdropimagelogo').attr('src', ''); // Clear the src
		$('#currentdropimagelogo').addClass('hide');
		return;

	});

	$( "body" ).on( "change","input:file" , function(e) {
		e.preventDefault();
		readURL(this);
		return;
     });

	function readURL(input) {
		if (input.files && input.files[0]) {
	    	$('#delfeamed').prop('disabled', false);
	        var reader = new FileReader();
            var filesize=input.files[0].size/1024/1024;
            if(filesize < 2){
                reader.onload = function (e) {
                    $('#currentdropimagelogo').attr('src', e.target.result);
                }
			}else {
                reader.onload = function (e) {
                    $('#currentdropimagelogo').attr('src', '');
                    $('#logo').val('');
                }
			}

	        reader.readAsDataURL(input.files[0]);
	    }
	}
    if($('#globalfeaturedimage').attr("src") != ""){
        $('.save_row').hide();
    }

});
function uploadimage() {

    if ($('#logo').val() == "" && $("#reset_defaultimg").val()=="no" ) {
    	errormessage("Please select the Featured Image.");
    } else {
        $('#fuploadload').submit();
    }
}
function changeimage() {
	var form_data=$('#fuploadload').serialize();
	var cur_hash=$("#current_hash").val();
	$.ajax( {
		type : "POST",
		dataType: 'json',
		url: site.baseUrl+site.lpPath+'/popadmin/changeimage',
		data:form_data,
		success : function(d) {
			$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media has been activated.</span></div>').
			fadeTo(3000, 500).slideUp("slow", function(){
                $("#success-alert").slideUp("slow");
            });
		}
	  });
}

function changetodefaultimage() {
	var form_data=$('#fuploadload').serialize();
	var cur_hash=$("#current_hash").val();
	$.ajax( {
		type : "POST",
		dataType: 'json',
		url: site.baseUrl+site.lpPath+'/popadmin/changetodefaultimage',
		data:form_data,
		success : function(d) {
			$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media has been deactivated.</span></div>').
			fadeTo(3000, 500).slideUp("slow", function(){
                $("#success-alert").slideUp("slow");
            });
		},
		cache : false,
		async : false
	});
}
function errormessage(textval){
    $("#alert-danger").find('span').html(textval);
    $("#alert-danger").fadeIn("slow");
    goToByScroll("alert-danger");
    return false;
}

function activetodefaultimage() {

        $('#resetfeaturedimg').modal({
	 		show: true,
	        backdrop: 'static',
	        keyboard: true
        }).one('click', '#cancelfimgbtn', function(e) {
			var form_data=$('#fuploadload').serialize();
			var cur_hash=$("#current_hash").val();
			$("#reset_defaultimg").val("y");
			$.ajax( {
			    type : "POST",
			    dataType: 'json',
			    url: site.baseUrl+site.lpPath+'/popadmin/activetodefaultimage',
			    data:form_data,
			    success : function(dat) {
			    	$('#delfeamed').prop('disabled', false);
                    $('#activedeactivebtn').bootstrapToggle('on')
		            $('#resetfeaturedimg').modal("hide");
			    	$("#currentdropimagelogo").removeClass('hide');
			    	$('#currentdropimagelogo').attr('src', dat.imgsrc);
					$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media default image has been reset .</span></div>').
					fadeTo(3000, 500).slideUp("slow", function(){
		                $("#success-alert").slideUp("slow");
		            });
			    }
		  	});
    	});
}
function disabledelbtn(){
    $('#delfeamed').prop('disabled', true);
}
