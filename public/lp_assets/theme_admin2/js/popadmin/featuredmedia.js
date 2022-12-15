
$(document).ready(function(){

    // function disabledelbtn(){
    //     $('#delfeamed').addClass('hide');
    // }
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

    // $(".btn-file #logo").change(function () {
		// if($(this).val()!=''){
    //         $('#currentdropimagelogo').removeClass('hide');
		// }
    // });

    $(".btn-file #logo").on("change",function(e){
        var filesize=e.target.files[0].size/1024/1024;
        if(filesize > 3) {
        	alert('The size of image is too large, please try a smaller image.');
            $('#currentdropimagelogo').attr('src', ''); // Clear the src
            $('#currentdropimagelogo').addClass('hide');
            return;
        }else {
            $('#currentdropimagelogo').removeClass('hide');
		}
        // if($(this).val()!=''){
        //
        // }
    });

	$( "body" ).on( "click","#delfeamed" , function(e) {
		e.preventDefault();
		$(this).prop('disabled', false);
		$('#logo').val("");
		$("#reset_defaultimg").val("no");
		$('#currentdropimagelogo').attr('src', ''); // Clear the src
		$('#currentdropimagelogo').addClass('hide');
		return;
		/*if("" !=$('#currentdropimagelogo').attr('src')){
			$(this).attr("disabled", true);
			$('#currentdropimagelogo').attr('src', ''); // Clear the src
			var form_data=$('#fuploadload').serialize();
			$.ajax( {
				type : "POST", 
				dataType: 'json',
				url: site.baseUrl+site.lpPath+'/popadmin/deletefeaturedmedia',
				data:form_data,
				success : function(d) {
					console.log(d.response);
					if(d.response=="1"){
						$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media has been deleted successfully.</span></div>').
						fadeTo(3000, 500).slideUp("slow", function(){
		                    $("#success-alert").slideUp("slow");
		                });
					}else{
						$("#delresmess").html('<div class="alert alert-danger" id="danger-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! Deleted Featured media. </strong><span></span></div>').
						fadeTo(3000, 500).slideUp("slow", function(){
		                    $("#danger-alert").slideUp("slow");
		                });
					}
				},
			  });
		}*/
	});	

	$( "body" ).on( "change","input:file" , function(e) {
	//$("input:file").change(function (){
		e.preventDefault();
		readURL(this);
		return;
     });	

	function readURL(input) {
		if (input.files && input.files[0]) {
	    	$('#delfeamed').prop('disabled', false);
	        var reader = new FileReader();
            var filesize=input.files[0].size/1024/1024;
            if(filesize < 3){
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
	/*var client_id=$("#client_id").val();
    var imagestatus = $("#imagestatus").val();
    var funneldata=JSON.stringify($("#funneldata").val());*/
    /*console.log(funneldata);
    return;*/
	$.ajax( {
		type : "POST", 
		dataType: 'json',
		url: site.baseUrl+site.lpPath+'/popadmin/changeimage',
		data:form_data,
		//data:{client_id:client_id,funneldata:funneldata,imagestatus:imagestatus},
		success : function(d) {
			$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media has been activated.</span></div>').
			fadeTo(3000, 500).slideUp("slow", function(){
                $("#success-alert").slideUp("slow");
            });
			//window.location.href = site.baseUrl+site.lpPath+'/popadmin/featuredmedia/'+cur_hash;
		}
	  });
}

function changetodefaultimage() {
	var form_data=$('#fuploadload').serialize();
	var cur_hash=$("#current_hash").val();
	/*var client_id=$("#client_id").val();
	var funneldata=JSON.stringify($("#funneldata").val());*/
	/*console.log(funneldata);
    return;*/
	$.ajax( {
		type : "POST",
		dataType: 'json',
		url: site.baseUrl+site.lpPath+'/popadmin/changetodefaultimage',
		//data:{client_id:client_id,funneldata:funneldata},
		data:form_data,
		success : function(d) {
			$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media has been deactivated.</span></div>').
			fadeTo(3000, 500).slideUp("slow", function(){
                $("#success-alert").slideUp("slow");
            });
			//window.location.href = site.baseUrl+site.lpPath+'/popadmin/featuredmedia/'+cur_hash;
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
    	   //e.preventDefault();
			var form_data=$('#fuploadload').serialize();
			var cur_hash=$("#current_hash").val();
			$("#reset_defaultimg").val("y");
			$.ajax( {
			    type : "POST",
			    dataType: 'json',
			    url: site.baseUrl+site.lpPath+'/popadmin/activetodefaultimage',
			    data:form_data,
			    //data:{client_id:client_id,funneldata:funneldata},	
			    success : function(dat) {
			    	//console.log(JSON.parse(dat.tarr));
			    	$('#delfeamed').prop('disabled', false);
                    $('#activedeactivebtn').bootstrapToggle('on')
		            $('#resetfeaturedimg').modal("hide");
			    	$("#currentdropimagelogo").removeClass('hide');
			    	$('#currentdropimagelogo').attr('src', dat.imgsrc); 
					$("#delresmess").html('<div class="alert alert-success" id="success-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>Featured media default image has been reset .</span></div>').
					fadeTo(3000, 500).slideUp("slow", function(){
		                $("#success-alert").slideUp("slow");
		            });
			        //window.location.href = site.baseUrl+site.lpPath+'/popadmin/featuredmedia/'+cur_hash;
			    }
		  	});
    	});
}
