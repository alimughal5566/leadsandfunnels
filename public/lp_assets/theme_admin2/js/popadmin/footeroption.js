$(document).ready(function(){
	/*$('.lp-footer-collapse').click(function () {
		if($(this).hasClass('footer-expand')){
			$(this).html('<i class="fa fa-times" aria-hidden="true"></i>Collapse');
			// $(this).removeClass('footer-expand');
		}else{
			$(this).html('<i class="fa fa-arrows-alt" aria-hidden="true"></i>Expand');
			// $(this).addClass('footer-expand');
		}
	});*/



    $('.sticky-tooltip').tooltip();


  $(".bombbomb-wrapper img").mouseout(function() { $(".bombomb_desc").css('display','none'); });

	$("#success-alert").hide();
	$("#advanced-success-alert").hide();
	$( "body" ).on( "change",".pfobtn,.sfobtn" , function() {
		var con_key = $(this).data('lpkeys');
		includepage(con_key);
	});
	//Url-edit-footer ,liences edit 
    $('.lp_footer_toggle').click(function (e) {
        e.preventDefault();
        var tar_ele=$(this).data('togele');
        if($('#'+tar_ele).hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#'+tar_ele).removeClass('hide');
        }else{
            $('#'+tar_ele).addClass('hide');
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
        }
    });
    $('.lp_footer_toggle_compliance').click(function (e) {
        e.preventDefault();
        var tar_ele=$(this).data('togele');
        if($('#'+tar_ele).hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');

            $('#compliance_text').prop("disabled", false);
            $('#'+tar_ele).removeClass('hide');

        }else{
            $('#'+tar_ele).addClass('hide');
            $('#compliance_text').prop("disabled", true);
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
        }
    });
    $('.lp_footer_toggle_licence').click(function (e) {
        e.preventDefault();
        var tar_ele=$(this).data('togele');
        if($('#'+tar_ele).hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#license_number_text').prop("disabled", false);
            $('#'+tar_ele).removeClass('hide');
        }else{
            $('#'+tar_ele).addClass('hide');
            $('#license_number_text').prop("disabled", true);
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
        }
    });
  	$('#compliance_is_linked,#license_number_is_linked').change(function(){
  		var tar_ele= $(this).data('tarele');
  		if($(this).is(':checked')){
  			$('#'+tar_ele).prop('disabled' , false);
  		}else{
  			$('#'+tar_ele).prop('disabled' , true);
  		}
  	});

    $("#_reset_default_btn").click(function(e){ resetdefaultfooter();});
    
    $("#_update_template_cta_btn").click(function(e){
      var radioValue = $("input[name='property_cta']:checked"). val();
      if(radioValue == 'y'){
        updatetemplatecta($('.pfobtn').data('lpkeys'));
      } else {
        $('#modal_proerty_template').modal('toggle');
      }
      advancefooter_update($('.pfobtn').data('lpkeys'), false);  
      return;
    });
});

function compliance_update (lpkeys) {
      var client_id = $('#client_id').val();
      var akeys = lpkeys.split("~");
      var vertical_id = akeys[0];
      var subvertical_id = akeys[1];
      var leadpop_id = akeys[2];
      var version_seq = akeys[3];
      
		var compliance_text = $('#compliance_text').val();
		var compliance_is_linked = 'n';
		var compliance_link = $('#compliance_link').val();
		var license_number_text = $('#license_number_text').val();

		if($('#compliance_is_linked:checkbox:checked').length){
			if(compliance_link=="")
				compliance_link = "#";
			label_compliance_text = "<a target='_blank' href='"+compliance_link+"'>"+compliance_text+"</a>";

			compliance_is_linked = 'y';
		}else{
			label_compliance_text = compliance_text;
		}

		var license_number_is_linked = 'n';
		if($('#license_number_is_linked:checkbox:checked').length){
			license_number_is_linked = 'y';
		}
		var license_number_link = $('#license_number_link').val();

		$('#label_compliance_text').html(label_compliance_text);
		$('#label_license_number_text').html(license_number_text);

      // var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&compliance_text="+compliance_text+"&compliance_is_linked="+compliance_is_linked+"&compliance_link="+compliance_link+"&license_number_text="+encodeURIComponent(license_number_text)+"&license_number_link="+license_number_link+"&license_number_is_linked="+license_number_is_linked;
      var post =  {client_id : client_id , vertical_id : vertical_id , subvertical_id : subvertical_id , leadpop_id : leadpop_id , version_seq : version_seq , compliance_text : compliance_text , compliance_is_linked : compliance_is_linked , compliance_link : compliance_link , license_number_text : license_number_text , license_number_link : license_number_link , license_number_is_linked : license_number_is_linked};
      
      $.ajax( {
            type : "POST",
            url : "/updatecompliance.php",
            data : post,
            success : function(d) {
                    if ( $('#compliance_text').prop( "disabled" ) )
            	{
                    hidetoggel(".lp_footer_toggle_licence","#license_number_text");
				} else{
                        hidetoggel(".lp_footer_toggle_compliance","#compliance_text");
				}
				goToByScroll("success-alert");
            	$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
               		$(this).slideUp(500);
                });   
            },
            cache : false,
            async : false
		});
      return false;
}

function advancefooter_update(lpkeys,cta_update = true) {
      var client_id = $('#client_id').val();
      var akeys = lpkeys.split("~");
      var vertical_id = akeys[0];
      var subvertical_id = akeys[1];
      var leadpop_id = akeys[2];
      var version_seq = akeys[3];
      var advancehtml = $('.lp-froala-textbox').froalaEditor('html.get');
      // advancehtml = advancehtml.replace("<p><br></p><p><br></p>", "");
      var templatetype = $('#templatetype').val();

      if ((templatetype == 'property_template' || templatetype == 'property_template2') && cta_update) {
        // $("#modal_proerty_template").find(".modal-msg").html('<p>Would you like to use our default CTA Message that goes with Property Template?</p>');
        $("#modal_proerty_template").modal();
        return;
      }

      var hideofooter  = '';

      if($('#hideofooter:checkbox:checked').length){
		    hideofooter = 'y';
      } else {
      	hideofooter  = 'n';	
      }

      var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&hideofooter=" + hideofooter + "&version_seq=" + version_seq + "&advancehtml="+escape(advancehtml);
      
      $.ajax( {
            type : "POST",
            url : "/updateadvancefooter.php",
            data : post,
            success : function(d) {
    //             if ( $('#compliance_text').prop( "disabled" ) )
    //         	{
    //                 hidetoggel(".lp_footer_toggle_licence","#license_number_text");
				// } else{
    //                 hidetoggel(".lp_footer_toggle_compliance","#compliance_text");
				// }
				goToByScroll("advanced-success-alert");
            	$("#advanced-success-alert").fadeTo(2000, 500).slideUp(500, function(){
               		$(this).slideUp(500);
                });
            },
            cache : false,
            async : false
		});
      return false;
}

function activetodefaultadvancedfooter(){
    // console.info($('#default-html').html());
    //$('.lp-froala-textbox').html($('#default-html').html());
    $("#modal_reset_default").find(".modal-msg").html('<p>Are you sure you want to reset back to the default advanced footer content?</p>');
    $("#modal_reset_default").modal();
}


function updatetemplatecta(lpkeys){

    var client_id = $('#client_id').val();
    var akeys = lpkeys.split("~");
    var vertical_id = akeys[0];
    var subvertical_id = akeys[1];
    var leadpop_id = akeys[2];
    var version_seq = akeys[3];
    var thelink =  akeys[4];
    var logocolor = $('#logocolor').val();
    var templatetype = $('#templatetype').val();
    var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&logocolor=" + logocolor + "&thelink=" + thelink + "&templatetype=" + templatetype;
    console.info(post);
    $.ajax( {
        type : "POST",
        url : "/updatetemplatecta.php",
        data : post,
        success : function(d) {
            if (d == 'y') {
              $('#modal_proerty_template').modal('toggle');
            }
        },
        cache : false,
        async : false
    });
}
function resetdefaultfooter(){
    $('.lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
    $('.lp-froala-textbox').froalaEditor('events.focus', false);
    $('#modal_reset_default').modal('toggle');
    goToByScroll("advanced-success-alert");
	$("#advanced-success-alert").fadeTo(2000, 500).slideUp(500, function(){
   		$(this).slideUp(500);
    });
}

function hidetoggel(toggle,text){

    var tar_ele=$(toggle).data('togele');
    if($('#'+tar_ele).hasClass('hide')){
        $(toggle).html('<i class="fa fa-remove"></i> CANCEL');
        $(text).prop("disabled", false);
        $('#'+tar_ele).removeClass('hide');
    }else{
        $('#'+tar_ele).addClass('hide');
        $(text).prop("disabled", true);
        $(toggle).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
    }
}

function includepage (lpkeys) {
	var client_id = $('#client_id').val();
	var akeys = lpkeys.split("~");
	var vertical_id = akeys[0];
	var subvertical_id = akeys[1];
	var leadpop_id = akeys[2];
	var version_seq = akeys[3];
	var thelink =  akeys[4];
	var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink;
	$.ajax( {
	    type : "POST",
	    url : "/updatebottomlinks.php",
	    data : post,
	    success : function(d) {
	        /*var change = d.split("~");
	        var imgId = change[0];
	        var toggle = change[1];
	        var linkchange = change[2];
	        if(toggle == 'y') {
	            $('#'+imgId).attr('src','/images/active.png');
	            $('#'+imgId + 'link').attr('href',linkchange);
	        }
	        else   if(toggle == 'n') {
	            $('#'+imgId).attr('src','/images/inactive.png');
	            $('#'+imgId + 'link').attr('href','#');
	        }*/
	    },
	    cache : false,
	    async : false
	});
}
function includepage_update (lpkeys) {
	var client_id = $('#client_id').val();
	var akeys = lpkeys.split("~");
	var vertical_id = akeys[0];
	var subvertical_id = akeys[1];
	var leadpop_id = akeys[2];
	var version_seq = akeys[3];
	var thelink =  akeys[4];
	var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink;

	$.ajax( {
	    type : "POST",
	    url : "/updatebottomlinks.php",
	    data : post,
	    success : function(d) {
	        var change = d.split("~");
	        var imgId = change[0];
	        var toggle = change[1];
	        var linkchange = change[2];
	        if(toggle == 'y') {
	            $('.'+imgId).attr('src','/images/active.png');
	        }
	        else   if(toggle == 'n') {
	            $('.'+imgId).attr('src','/images/inactive.png');
	        }
	    },
	    cache : false,
	    async : false
	});
	return false;
}


