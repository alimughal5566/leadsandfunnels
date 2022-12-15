$(document).ready(function(){
	if($("#targetele").val()){
		goToByScroll($("#targetele").val());
	}
	$("#lpcancelbtn").on("click",function(e){
        e.preventDefault();
        $('#cancelrequest').modal({
	 		show: true,
	        backdrop: 'static',
	        keyboard: true
        }).one('click', '#cancelrequestbtn', function(e) {
    	   //e.preventDefault();
            $('#cancelrequest').modal("hide");
            lpcancelrequest();
    	});
    });

	support_issue_data=$.parseJSON($('#issuedatainfo').val());

    if($("#maintopic").val() != ""){
        var option_val ='';
        $.each(support_issue_data[$("#maintopic").val()].subissue, function(key, value) {
            option_val+='<option value="'+key+'">'+value+'</option>';
        });
        $('#mainissue').empty().append(option_val).find('option[value="'+$('#mainissue').data('select')+'"]').attr("selected","selected");
        $('#mainissue').selectpicker('refresh');
    }

	$('body').on('change','#maintopic',function(e){
		e.preventDefault();
		//console.log($(this).val());
		//console.log(support_issue_data[$(this).val()].subissue);
		if(support_issue_data[$(this).val()].subissue!='undefined'){
			var option_val='<option value="">Select Topic</option>';
			$.each(support_issue_data[$(this).val()].subissue, function(key, value) {
				option_val+='<option value="'+key+'">'+value+'</option>';
			});
			//console.log(option_val)
			$('#mainissue')
			    .empty()
			    .append(option_val)
			    .find('option:first')
			    .attr("selected","selected")
			;
			//$('#mainissue').selectpicker('render');
			$('#mainissue').selectpicker('refresh');
		}
	});
	$('body').on('change','#mainissue',function(e){
		e.preventDefault();
		var main_topic=$('#maintopic').val();
		var isseue_sele=$(this).val();
		if($("#mainissue option:selected").text().toLowerCase()=="other"){
			$("#issumemessage").html("");
		}else{
			var msg_text="";
			console.log(support_issue_data[main_topic].subdetail[isseue_sele]);
			if(support_issue_data[main_topic].subdetail[isseue_sele]!='undefined'){
				msg_text+=support_issue_data[main_topic].subdetail[isseue_sele].heading;
				msg_text+=support_issue_data[main_topic].subdetail[isseue_sele].body;
				msg_text+=support_issue_data[main_topic].subdetail[isseue_sele].action;
				$("#mailsubject").val(support_issue_data[main_topic].subdetail[isseue_sele].heading);
			}
			//console.log()
			$("#issumemessage").html("");
			$("#issumemessage").html(msg_text);
			$("#mailmsg").val(msg_text);
		}
	});
	function lpcancelrequest(){
		//$("#lpcancelbtn").on('click',function(e){
			//e.preventDefault();
			//$("#leadpopovery").show();
			$("#mask").show();
	        jQuery.ajax( {
	            type : "POST",
                data: { _token:ajax_token },
                url: site.baseUrl+site.lpPath+'/cancelrequest',
	            success : function(res) {
	                var obj = jQuery.parseJSON( res );
	                var msg_class="";
	                if(obj.responce=="yes"){
	                	msg_class="#alert-success";
	                }else if(obj.responce=="no"){
	                	msg_class="#alert-danger";
	                }
	                goToByScroll(msg_class.replace("#",""));
	                $(msg_class).removeClass("hide");
					$(msg_class).html('<button type="button" class="close" data-dismiss="alert">x</button><span>'+obj.msg+'</span></div>').
						fadeTo(3000, 500).slideUp("slow", function(){
		                $(this).slideUp("slow");
		            });
	                //$("#leadpopovery").hide();
	                $("#mask").hide();
	                /*$("#lp-alert-resp").removeClass("alert-success alert-danger").addClass(msg_class);
	                $("#lp-alert-resp").find('p').text(obj.msg);
	                $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
	                    $(".alert-success").slideUp(500);
	                });*/
	               //$(window).load();
	            },
	        });
		//});
		return;
	}

	var $form = $("#lp-support-form"),
		$successMsg = $(".alert");
	$form.validate({
		rules: {
			maintopic: {
				required: true
			},
			mainissue: {
				required: true
			},
			subject: {
				required: true
			},
			message: {
				required: true
			}
		},
		messages: {
			maintopic: {
				required: "Please select the main topic"
			},
			mainissue: {
				required: "Please select the main issue"
			},
			subject: {
				required: "Please enter the subject"
			},
			message: {
				required: "Please enter the message"
			}
		},
		errorPlacement: function(error, element) {
			//Custom position: main topic and main issue
			if (element.attr("name") == "maintopic" ) {
				error.insertAfter($("#errmaintopic"));
			}else if (element.attr("name") == "mainissue" ) {
				error.insertAfter($("#errissue"));
			}else {
				error.insertAfter(element);
			}
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
	$( "#lp-support-form" ).change(function() {
		var frm = $( "#lp-support-form" );
		var errors = frm.validate().numberOfInvalids();
		if(errors){
			if($('#mainissue').parent().hasClass('error')){
				$('#mainissue').parent().removeClass('error');
			};
			frm.valid();
		}
	});
	$(document).on("click",".lpsupportwistia",function(e){
		e.preventDefault();
		showlpsupvideo($(this).data("lp-wistia-title"),$(this).data("lp-wistia-button"));
		return;
	});
	$('#lp-sup-video-modal').on('hidden.bs.modal', function () {
        stopsupvideo($(this));
    });


	//lpsupportvideos();
});
function showlpsupvideo(title,wistiskey){
	$("#lp-sup-video-modal .modal-dialog .modal-content .modal-header .modal-title").html("<span>How To Video:</span>"+" "+title);

    var wisurl='https://fast.wistia.com/embed/iframe/'+wistiskey;
    //var wisurl='https://leadpops.wistia.com/medias/'+wistiskey;
    var htmlString = '<div class="video-lp-wistia"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';
    var iframe_ele=$("#lp-sup-video-modal .modal-dialog .modal-content .modal-body .ifram-wrapper .video-lp-wistia");
    iframe_ele.html(htmlString);
    $('#lp-sup-video-modal').modal('show');
}
function stopsupvideo(ele){
	//console.log(ele);
	var iframe = ele.find( 'iframe');
	/*console.log(iframe);
	return;*/
	var video = ele.find( 'video');
	if ( iframe ) {
		var iframeSrc = $(iframe).attr("src");
		//if(iframeSrc.indexOf("leadpops.wistia.com/medias") !=-1){
		if(iframeSrc.indexOf("fast.wistia.com/embed/iframe") !=-1){
			$(iframe).wistiaApi.pause();
		}else{
			$(iframe).attr("src",iframeSrc);
		}
	}
	if ( video ) {
		video.pause();
	}
	return false;
}


/*(function (window) {

    'use strict';

    window.lp_sup_code = window.lp_sup_code || {};

    window.lp_sup_code.stopSupVideo = function ( element ) {

        var iframe = element.querySelector( 'iframe');
        var video = element.querySelector( 'video');
        if ( iframe ) {
            var iframeSrc = iframe.src;
            if(iframeSrc.indexOf("fast.wistia.com/embed/iframe") !=-1){
                iframe.wistiaApi.pause();
            }else{
                iframe.src = iframeSrc;
            }
        }
        if ( video ) {
            video.pause();
        }
        return false;
    };
    window.lp_sup_code.lightweightWistiaPlayer = function () {


        var dataSupWistiaVideos = '[data-lp-wistia-button]';

        var wistiaSupVideos = [...document.querySelectorAll(dataSupWistiaVideos)];

        console.log("wistiaSupVideos");

        console.log(wistiaSupVideos);

        function init() {

            var i=0;
            wistiaSupVideos.forEach(function (wisele) {
            	console.log("wisele");
            	console.log(wisele);
                bindSupWistiaVideoEvent(wisele);
			});
        }
        function bindSupWistiaVideoEvent(element){
            console.log("element");
            console.log(element);
            //console.log("button");
            //var button = element.querySelector('[data-lp-wistia-button]');
            //console.log(button);
            if(element){
	            element.addEventListener('click', createSupIframeWistia);
            }

        }
        function createSupIframeWistia(event){

            console.log("event");

            console.log(event.currentTarget.dataset.lpWistiaButton);
            console.log(event.currentTarget.dataset.lpWistiaTitle);
            console.log("url");
            var url = event.currentTarget.dataset.lpWistiaButton;
            //var iframPlaceholder = event.target.parentNode;

            console.log(url);
            var modeltitle = document.querySelector("#lp-sup-video-modal .modal-dialog .modal-content .modal-header .modal-title");
            console.log(modeltitle);
            modeltitle.innerHTML="<span>How To Video:</span>"+event.currentTarget.dataset.lpWistiaTitle;
            var iframPlaceholder = document.querySelector("#lp-sup-video-modal .modal-dialog .modal-content .modal-body .ifram-wrapper");
            //iframPlaceholder.innerHTML = "";

            //var wisurl='https://fast.wistia.com/embed/medias/'+url+'?autoPlay=true&embedType=iframe&videoFoam=true';

            console.log(iframPlaceholder);
            var wisurl='https://fast.wistia.com/embed/iframe/'+url;
            console.log(wisurl);

            //<script src="//fast.wistia.net/assets/external/E-v1.js" async></script>

            var htmlString = '<div class="video-lp-wistia"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';

            iframPlaceholder.style.display = 'none';
            iframPlaceholder.insertAdjacentHTML('beforebegin', htmlString);
            iframPlaceholder.parentNode.removeChild(iframPlaceholder);

        }

        return {
           init: init
        }
    };

})(window);

supready();

function supready() {

	var lightweightWistiaPlayer = new lp_sup_code.lightweightWistiaPlayer();

    if (document.readyState != 'loading') {

        //page.init();

    } else {

        document.addEventListener('DOMContentLoaded', lightweightWistiaPlayer.init);

    }

}
*/
$(function () {

    $(".lpsupportvideo").YouTubeModal({
        autoplay:1,
        width:640,
        height:480,
        hideTitleBar: false,
        cssClass:"lpsupportvideopopmdl",
        title:""
    });
});


function lpsupportvideos(){

    var youtube = document.querySelectorAll( ".lpsupportvideo" );

    for (var i = 0; i < youtube.length; i++) {

        var source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";

        var image = new Image();
	        image.src = source;
	        image.addEventListener( "load", function() {
	            youtube[ i ].appendChild( image );
	        }( i ) );

	        youtube[i].addEventListener( "click", function() {

	            var iframe = document.createElement( "iframe" );

	                iframe.setAttribute( "frameborder", "0" );
	                iframe.setAttribute( "allowfullscreen", "" );
	                iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );

	                this.innerHTML = "";
	                this.appendChild( iframe );
	        } );
    };

}
