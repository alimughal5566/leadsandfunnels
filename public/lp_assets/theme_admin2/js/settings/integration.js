(function ($) {
    $(document).ready(function() {

        function goOuath2() {
			console.log($("#teactivate").attr("href"));
			$("#teactivate").get(0).click(); 
		}

        function goHomebotOuath2() {
            console.log($("#homebotactivate").attr("href"));
            $("#homebotactivate").get(0).click();
        }

        $('#homebotactivedeactivebtn').on("change", function() {
            var homebot_activated = $("#homebot_activated").val();
            var homebot_status = $("#homebot_status").val();
            var client_id = $("#client_id").val();
            var newStatus = "";

            if ($(this).is(":checked") && homebot_activated == "no") {
                goHomebotOuath2();
                this.checked = !this.checked;
                console.log("checked");
            } else {
                $.ajax( {
                    type : "POST",
                    url: site.baseUrl+site.lpPath+'/popadmin/homebotdelete',
                    data: "client_id=" + client_id + "&_token=" + ajax_token,
                    success : function(d) {
                        window.location.reload(true);
                    }
                });
            }
        });

		$('#activedeactivebtn').on("change", function() {
//			console.log(site.baseUrl+site.lpPath+'/popadmin/totalexpert');
//			return false;
		  var te_activated = $("#te_activated").val();	
		  var te_status = $("#te_status").val();	
		  var client_id = $("#client_id").val();	
		  var newStatus = "";
		  if ($(this).is(":checked") && te_activated == "no") {
		      goOuath2();	
  			  this.checked = !this.checked;
			  console.log("checked");
		  } else {
			  $.ajax( {
				type : "POST", 
				url: site.baseUrl+site.lpPath+'/popadmin/totalexpertdelete',
				data: "client_id=" + client_id + "&_token=" + ajax_token,
				success : function(d) {
					//alert("OK");
				}
			  });
              window.location.reload(true);  			  
		  }	
/*		  
		  if (te_activated == "no") {
		      goOuath2();	
  			  this.checked = !this.checked;
		  }
		  else {
			  // https://myleads.leadpops.com/lp/popadmin/totalexpert
			  $("#te_status").val(newStatus); // change status
			  $.ajax( {
				type : "POST", 
				url: site.baseUrl+site.lpPath+'/popadmin/totalexpertoauth',
				data: "client_id=" + client_id + "&status=" + newStatus,
				success : function(d) {
					//alert("OK");
				}
			  });
		  }
*/	  
		});
//<input type="hidden" name="te_activated" id="te_activated" value="yes">
//<input type="hidden" name="te_status" id="te_status" value="active">	
        // Search field in funnel selection popup
        $('#search').keyup(function(){
            var search = $(this).val();
            if(search != ''){
                $('div[class="item"]').hide();
                $('input[data-value *="'+search+'"]').parent().show();
            }else{
                $('div[class="item"]').show();
            }
        });

        $('#reset').click(function(){
            $("#funnel-selector input[type=checkbox]").prop('checked', false);
            $("#funnel-selector input[type=checkbox]").next().removeClass('lp-white');
        });

        $('#all-funnel-checkbox').change(function(){
            if($(this).is(":checked")) {
                $('#funnel-selector input:checkbox').prop('checked', true);
                $('#funnel-selector input:checkbox').next().addClass('lp-white');
            } else {
                $('#funnel-selector input:checkbox').prop('checked', false);
                $('#funnel-selector input:checkbox').next().removeClass('lp-white')
            }
        });

        $(".fs-sgrp, .sub-group").change(function(){
            var group = $(this).data("key");
            if($(this).is(":checked")) {
                $("#funnel-selector input[type=checkbox]").each(function(index,el) {
                    if ($(el).hasClass(group)) {
                        $(el).prop('checked', true);
                        $(el).next().addClass('lp-white');
                    }
                });
            } else {
                $("#funnel-selector input[type=checkbox]").each(function(index,el) {
                    if ($(el).hasClass(group)) {
                        $(el).prop('checked', false);
                        $(el).next().removeClass('lp-white');
                    }
                });
            }
        });

    });
})(jQuery);