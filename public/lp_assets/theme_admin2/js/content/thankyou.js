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

    $( "body" ).on( "blur","#thirldpurl" , function(e) {
        var text = $(this).val();
        var replace = text.replace(/(^\w+:|^)\/\//, '');
        $(this).val(replace);
    });
    $.validator.addMethod("cus_url", function(value, element) {

        if(value.substr(0,7) != 'http://' && value.substr(0,8) != 'https://'){
            value = 'http://' + value;
        }
        if(value.substr(value.length-1, 1) != '/'){
            value = value + '/';
        }
        return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,7}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Not valid url.");
    $('#thankyou-page-from').validate({
        rules: {
            footereditor: {
                cus_url: true,
                required: true
            }
        },
        messages: {
            footereditor: {
                cus_url: "Please enter a valid URL.",
                required: "Please enter URL."
            }
        },
        submitHandler: function() {
            $('#thankyou-page-from').submit();
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

    $( ".thankyou-save" ).submit(function( event ) {
        $( "#thirldpurl").trigger("blur");
        event.preventDefault();
    });


});
