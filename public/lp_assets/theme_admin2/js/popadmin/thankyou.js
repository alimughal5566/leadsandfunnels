$(document).ready(function(){
	/*$( "body" ).on( "change","#thankyou" , function(event) {
		var the_link=$(this).data('thelink');
		var target_ele="#thirldparty";
		if ($(this).is(':checked')) {
			$(target_ele).bootstrapToggle("off")
	  	} else {
	  		$(target_ele).bootstrapToggle("on")
		}
		return;
    });
    $( "body" ).on( "change","#thirldparty" , function(event) {
		var the_link=$(this).data('thelink');
		var target_ele="#thankyou";
		if ($(this).is(':checked')) {
		    $(target_ele).bootstrapToggle("off")
	  	} else {
		    $(target_ele).bootstrapToggle("on")
		}
		return;
    });*/
	$( "body" ).on( "change",".thktogbtn" , function(e) {
		$("#changebtn").val("1");
		if ($(this).is(':checked')) {
			$('.thktogbtn').not(this).each(function(){
	        	 $(this).bootstrapToggle("off");
	     	});
		}else{
			$('.thktogbtn').not(this).each(function(){
	        	 $(this).bootstrapToggle("on");
	     	});
		}
    });
    /*$("#eurllink").click(function(e){
    	e.preventDefault();
    	$("#lp-thankyou-url-edit").toggle();
    });*/

	//Url-edit-thankyou
    $('.lp_thankyou_toggle').click(function (e) {
        e.preventDefault();
        if($('#lp-thankyou-url-edit').hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#lp-thankyou-url-edit').removeClass('hide');
        }else{
            $('#lp-thankyou-url-edit').addClass('hide');
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT URL');
        }
    });


});