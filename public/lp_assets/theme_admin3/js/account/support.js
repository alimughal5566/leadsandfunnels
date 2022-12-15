var support = {

    /*
    ** Select support Function
    **/
    // request_form: $("#lp-support-form"),

    selectSupport: function () {
        var amIclosing = false;

        $('.subject-select01').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.subject-select-parent01')
        }).on('select2:opening', function() {
            // jQuery('.subject-select-parent01 .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.subject-select-parent01 .select2-dropdown').hide();
            jQuery('.subject-select-parent01 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.subject-select-parent01 .select2-selection__rendered').hide();
            lpUtilities.niceScroll();

            setTimeout(function () {
                jQuery('.subject-select-parent01 .select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = jQuery('.subject-select01').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight - 50;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.subject-select-parent01 .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.subject-select01').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.subject-select-parent01 .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.subject-select-parent01 .select2-selection__rendered').show();
            jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'none');
        }).on('select2:select', function(){
            $('.subject-select02').removeAttr('disabled');
        });

        $('.subject-select02').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.subject-select-parent02')
        }).on('select2:opening', function(e) {
            if($(this).find('option').length < 2){
                e.preventDefault()
            }
        }).on('select2:open', function() {
            jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.subject-select-parent02 .select2-dropdown').hide();
            jQuery('.subject-select-parent02 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.subject-select-parent02 .select2-selection__rendered').hide();
            setTimeout(function () {
                jQuery('.subject-select-parent02 .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.subject-select-parent02 .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.subject-select02').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.subject-select-parent02 .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.subject-select-parent02 .select2-selection__rendered').show();
            jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'none');
        });
    },


    deactivateAccount: function (){
        jQuery.ajax( {
            type : "POST",
            // data :'_token='+ajax_token,
            url: site.baseUrl + site.lpPath + '/cancelrequest',
            success : function(res) {
                var obj = jQuery.parseJSON( res );
                if(obj.responce=="yes"){
                    displayAlert('success', obj.msg);
                }else if(obj.responce=="no"){
                    displayAlert('danger', obj.msg);
                }
                $('#cancelrequest').modal("hide");
            },
        });
        return;
    },

    /*
   ** init Function
   **/

    init: function () {
        support.selectSupport();
    }
};

jQuery(document).ready(function() {
    support.init();

    // jQuery("#btn-spt-form").click(function () {
    //     $("#lp-support-form").submit();
    // });

    if($("#targetele").val()){
        goToByScroll($("#targetele").val());
    }

    $("#lpcancelbtn").on("click",function(e){
        e.preventDefault();
        $('#cancelrequest').modal({
            show: true,
            backdrop: 'static',
            keyboard: true
        }).on('click', '#cancelrequestbtn', function(e) {
            //e.preventDefault();
            e.stopImmediatePropagation();
            support.deactivateAccount();
        });
    });

    var support_issue_data=$.parseJSON($('#issuedatainfo').val());

    if($("#maintopic").val() != ""){
        var option_val ='';
        $.each(support_issue_data[$("#maintopic").val()].subissue, function(key, value) {
            option_val+='<option value="'+key+'">'+value+'</option>';
        });
        $('#mainissue').empty().append(option_val).find('option[value="'+$('#mainissue').data('select')+'"]').attr("selected","selected");
        // $('#mainissue').selectpicker('refresh');
        // $('#subject').val(support_issue_data[$(this).val()].maintitle);
    }

    $('body').on('change', '#mainissue', function(){
        if($(this).val()){
            $("#mainissue-error").hide();
        }
    })

    $('body').on('change','#maintopic',function(e){
        e.preventDefault();
        if($(this).val()){
            $("#maintopic-error").hide();
        }
        //console.log(support_issue_data[$(this).val()].subissue);
        var option_val='<option value="">Select Topic</option>',
            mainTopic = $(this).val();
        if(mainTopic != "" && support_issue_data[$(this).val()].subissue != 'undefined'){
            $.each(support_issue_data[mainTopic].subissue, function(key, value) {
                option_val+='<option value="'+key+'">'+value+'</option>';
            });
        }

        //console.log(option_val)
        $('#mainissue')
            .empty()
            .append(option_val)
            .find('option:first')
            .attr("selected","selected");

        //setting value in hidden field
        // $('#subject').val((mainTopic=="" ? mainTopic : support_issue_data[mainTopic].maintitle));
        // $('#mainissue').selectpicker('refresh');
    });
    $('body').on('change','#mainissue',function(e){
        e.preventDefault();
        var main_topic=$('#maintopic').val();
        var isseue_sele=$(this).val();
        if($("#mainissue option:selected").text().toLowerCase()=="other"){
            $("#issumemessage").html("");
        }else{
            var msg_text="";
            if($(this).val() != "" && support_issue_data[main_topic].subdetail[isseue_sele]!='undefined'){
                console.log(support_issue_data[main_topic].subdetail[isseue_sele]);
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



    $(document).on("click",".lpsupportwistia",function(e){
        e.preventDefault();
        showlpsupvideo($(this).data("lp-wistia-title"),$(this).data("lp-wistia-button"));
        return;
    });
});
function showlpsupvideo(title,wistiskey){
    $("#lp-sup-video-modal .modal-dialog .modal-content .modal-header .modal-title").html("<span>How-To Video:</span>"+" "+title);
    wistiskey = $.trim(wistiskey);
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
        if(iframeSrc.indexOf("fast.wistia.com/embed/iframe") != -1){
            $(iframe).wistiaApi.pause();
        }else{
            $(iframe).attr("src",iframeSrc);
        }
    }
    if ( video) {
        video.pause();
    }
    return false;
}


$(function () {
    $(".lpsupportvideo").YouTubeModal({
        autoplay:1,
        width:'100%',
        height:480,
        hideTitleBar: false,
        cssClass:"lpsupportvideopopmdl",
        title:"<span>How-To Video:</span> Mobile"
    });
    $("#YouTubeModal .modal-header button.close").remove();
    $("#YouTubeModal .modal-content").append('<div class="modal-footer">' +
            '<div class="action">' +
                '<ul class="action__list">' +
                    '<li class="action__item">' +
                        '<button type="button" class="button button-cancel lp-btn-cancel" data-dismiss="modal">Close</button>' +
                    '</li>' +
                '</ul>' +
            '</div>' +
        '</div>');
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
