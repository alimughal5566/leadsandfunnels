$(document).ready(function(){
	var   globalTimeout;
	$( "body" ).on( "change","#gf_image_active" , function() {
        if($(this).is(":checked")) {
        	$("#imagestatus").val("mine");
        	$("#use_me").val("y");
        	$("#use_default").val("n");
        } else {
        	$("#use_me").val("n");
        	$("#use_default").val("n");
        	$("#imagestatus").val("default");
        }
	});
	$( "body" ).on( "click","#delfeamed" , function(e) {
		e.preventDefault();
		$('#globalfeaturedlogo').val("") ;
		$("#reset_defaultimg").val("no");
		$('#globalfeaturedimage').attr('src', ''); // Clear the src
        $('#globalfeaturedimage').addClass('hide');
        $(this).addClass('hide');
		return;
	});

	$( "body" ).on( "change","#globalfeaturedlogo" , function(e) {
	//$("input:file").change(function (){
		e.preventDefault();
        var filetype = e.target.files[0].type;
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            $('#globalfeaturedimage').attr('src', ''); // Clear the src
            $('#globalfeaturedimage').addClass('hide');
            $('#globalfeaturedlogo').val("") ;
            $("#reset_defaultimg").val("no");            return false;
        }
        var filesize=e.target.files[0].size/1024/1024;
        if(filesize > 2) {
            alert('The size of image is too large, please try a smaller image.');
            $('#globalfeaturedimage').attr('src', ''); // Clear the src
            $('#globalfeaturedimage').addClass('hide');
            $('#globalfeaturedlogo').val("") ;
            $("#reset_defaultimg").val("no");
        }else {
            readURL(this);
		}
        $('.save_row').show();
		return;
     });
	function readURL(input) {
		console.log(input.files[0]);
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
            var filesize=input.files[0].size/1024/1024;
            if(filesize < 2){
                reader.onload = function (e) {
                    $('#globalfeaturedimage').attr('src', e.target.result);
                }
            }else {
                reader.onload = function (e) {
                    $('#globalfeaturedimage').attr('src', '');
                    $('#globalfeaturedimage').addClass('hide');
                    $('#globalfeaturedlogo').val("") ;
                    $("#reset_defaultimg").val("no");
                    return;
                }
            }

	        reader.readAsDataURL(input.files[0]);
            $('#delfeamed, #globalfeaturedimage').removeClass('hide');
	    }
	}
	if($('#globalfeaturedimage').attr("src") != ""){
		$('.save_row').hide();
	}
});
function uploadimageglobalfeatured() {
    if ($('#globalfeaturedimage').attr("src") == "" && $("#reset_defaultimg").val()=="no" ) {
        errormessage("Please select the Featured Image.");
        $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        return;
    }
    if ($("#lpkey_image").val() == '') {
        errormessage("Please Select Funnel From List.");
        $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        return;
    };
    $('#uploadglobalimage').submit();

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

function activetodefaultimage() {

    if ($("#lpkey_image").val() == '') {
        errormessage("Please Select Funnel From List.");
        return;
    };
		$('#gresetfeaturedimg').modal({
	 		show: true,
	        backdrop: 'static',
	        keyboard: true
        }).one('click', '#gcancelfimgbtn', function(e) {
    		$("#mask").show();
    		//$("#use_default").val("y");
			$("#reset_defaultimg").val("y");
			var form_data=$('#uploadglobalimage').serialize();
			$.ajax( {
			    type : "POST",
			    dataType: 'json',
			    url: site.baseUrl+site.lpPath+'/global/activetodefaultimageglobal',
			    data:form_data,
			    success : function(dat) {
			    	console.log(dat);
			    	//$("#leadpopovery").hide();
			    	$('#delfeamed, #globalfeaturedimage').removeClass("show").addClass("hide");
			    	$('#gresetfeaturedimg').modal("hide");
			    	$("#mask").hide();
			    	if(dat.imgsrc!=""){
				    	$('#globalfeaturedimage').attr('src', dat.imgsrc);
	                    //if($('#gf_image_active').length > 0) $('#gf_image_active').bootstrapToggle('on');
			            $("#success-alert").find('span').text("Featured media default image has been reset.");
						goToByScroll("success-alert");
			            $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
			                $(this).slideUp(500);
			            });
			    	}else{
				    	$('#globalfeaturedimage').attr('src', "");
			            $("#alert-danger").find('span').text("Error! Featured media default image has not been reset.");
						goToByScroll("alert-danger");
			            $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
			                $(this).slideUp(500);
			            });
			    	}
			        //window.location.href = site.baseUrl+site.lpPath+'/popadmin/featuredmedia/'+cur_hash;
			    }
		  	});
    	});
}
