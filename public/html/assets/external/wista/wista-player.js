/**
 * Created by root on 6/13/17.
 */



$(function(){

    $.showYtVideo = function(options) {

        options = $.extend({
            modalSize: 'm',
            shadowOpacity: 0.5,
            shadowColor: '#000',
            clickOutside: 1,
            closeButton: 1,
            videoId: ''
        }, options);

        var modal = $('<div class="modal fade add_recipient video-modal" id="lp-video-modal"></div>');
        var closeButton = $('<div class="lp-modal-footer footer-border"><a data-dismiss="modal" class="btn lp-btn-cancel">Close</a></div>');

        if (options.closeButton) {
            closeButton.appendTo(modal);
        }

        var modalBg = $('<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h3 class="modal-title"><span>How To Video:</span>Domain Names</h3></div><div class="modal-body"></div></div>');

        modalBg.appendTo(modal);
        modal.appendTo('body');

        var videoWidth = modal.width();
        var videoHeight = modal.height();
        var modalWidth = modal.outerWidth();
        var modalHeight = modal.outerHeight();


        if (options.videoId) {
            var iframe = $('<iframe width="'
                + videoWidth
                + '" height="'
                + videoHeight
                + '" src="'
                + options.videoId
                + '" frameborder="0" allowfullscreen></iframe>');

            iframe.appendTo(modal);
        } else {
            console.error('showYtVideo plugin error: videoId not specified');
        }

        modal.css({
            marginLeft: -modalWidth/2,
            marginTop: -modalHeight/2
        });

        modalBg.css({
            opacity: options.shadowOpacity,
            backgroundColor: options.shadowColor
        });


        closeButton.on('click', function() {
            $(this).parent().fadeOut(350, function() {
                $(this).detach();
                modalBg.detach();
            })
        });


        if (options.clickOutside) {
            $(document).mouseup(function(e) {
                if (!modal.is(e.target) && modal.has(e.target).length === 0) {
                    modal.fadeOut(350, function() {
                        $(this).detach();
                        modalBg.detach();
                    });
                }
            });
        }
    }

    /*$('.lp-yt-video').on('click', function () {
        var videoid=$(this).data("videolink");
        $.showYtVideo({
            videoId: videoid
        });
    });*/








//     var picker = new CP(document.querySelector('#show-color-val'), false);
//
//     picker.on("change", function(color) {
//         this.target.value = '#' + color;
//     });
//
//
//
//
// // add a `static` class to the color picker panel
//     picker.picker.classList.add('static');
//
// // show the color picker panel in the second `<p>` element
//     picker.enter(document.querySelector('#target-color'));

    // SUPPORT JS



    //$(".lp-select2").select2();





    $(".lp-select2-with-custom-optclass").select2({
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass($(data.element).attr("class"));
            }
            return data.text;
        }
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({
            cursorcolor:"#02abec",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #fff",
        });
    });



    $(".lp-expand-collapse").on( "click", function() {
        $(this).parent().next().slideToggle(250);
        if($(this).parent().hasClass('lp-last-video')){
            $(this).parent().removeClass('last');
        }
        if($(this).hasClass('lp-collapse')){
            if($(this).parent().hasClass('lp-last-video')){
                $(this).parent().addClass('last');
            }
            $(this).addClass('deactive');
            $(this).prev().removeClass('deactive');
        }else{
            $(this).addClass('deactive');
            $(this).next().removeClass('deactive');
        }
        $fexpand = $(this).find(">:first-child");
        if ($(this).hasClass('opened')) {
            $(this).removeClass('opened');
        } else {
            $(this).addClass('opened');
        };
    });

    // LOGIN JS






    // Dropdown JS

    $('.lp-dropdown').hover(
        function(){
            $(this).addClass("active");
        },
        function(){
            $(this).removeClass('active');
        }
    );

    $('.lp-dropdown > .lp-submenu > .lp-dropdown').hover(function(){
        $(this).addClass ('active');
    },function(){
        $(this).removeClass('active');
    });

    // SUPPORT JS

    // $('.selectpicker').selectpicker();
    // $('#mainissue').selectpicker();



    // Home JS

    // Extra js remove later

    // $(".dropdown-menu > li > a.trigger").hover(function(e){
    //     var current=$(this).next();
    //     var grandparent=$(this).parent().parent();
    //     if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
    //         $(this).toggleClass('right-caret left-caret');
    //     grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
    //     grandparent.find(".sub-menu:visible").not(current).hide();
    //     current.toggle();
    //     e.stopPropagation();
    // });
    // $(".dropdown-menu > li > a:not(.trigger)").hover(function(){
    //     var root=$(this).closest('.dropdown');
    //     root.find('.left-caret').toggleClass('right-caret left-caret');
    //     root.find('.sub-menu:visible').hide();
    // });

    $('.custom-btn').click(function(){
        $(this).toggleClass('btn-active')
    });

    $(document).click(function (e) {
        $('.custom-btn').removeClass('btn-active')
    });
////////////////FOR EMAIL FIRE///////////////////////
    $('.email_fire').click(function () {
        var _this = $(this);
        if(_this.data('value')==0){
            $('#emailfiremodel .modal-title').html(_this.data('title'));
            $('#emailfiremodel .funnel-message').html(_this.data('message'));
            if(_this.attr('data-class')!=undefined){
                $('#emailfiremodel .funnel-message').addClass(_this.attr('data-class'));
            }

            $('#emailfiremodel').modal('show');
            return false;
        }
        else {
            if(_this.attr('data-redirect')==1){
                window.location.href = _this.attr('href');
            } else if(_this.hasClass('email_firelogin-box')){
                $('#emailfire').modal('show');
                return false;
            }
        }
    });
    ////////////////END EMAIL FIRE///////////////////////

    $('.performance-reporting').click(function (e) {
        if( $(this).attr('data-syncpass') == 0 ){
            e.preventDefault();
            $('#modal_performance_reporting').modal('show');
        }
    });

    $('.btnAction_sync_portal').click(function (e) {
        $("#loader-reporting").show()
        e.preventDefault();

        $.ajax( {
            type : "POST",
            data : "action=sync-password",
            url : "/lp/index/syncportalpassword",
            dataType: "json",
            success : function(r) {
                $("#loader-reporting").hide()
                $('.performance-reporting').attr("data-syncpass", "1");
                $("#modal_performance_reporting").modal('hide');
                $('#pr_title').text(r.messages['title']);
                $('#pr_msg').html(r.messages['description']);
                $('#modal_confirmPeromanceReportingMessage').modal('show');
            },
            error: function (e) {
                $("#loader-reporting").hide()
            },
            cache : false,
            async : false
        });
    });


    $('#lp-video-modal').on('hidden.bs.modal', function () {
        code.stopVideo(this);
    });
});

(function (window) {

    $(".lp-select2").select2(
    ).on("select2:open", function () {
        $('.select2-results__options').niceScroll({
            cursorcolor:"#02abec",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #fff",
        });
    });


    /*$(".video__button").on("click",function(e){
        console.log($(this).data('youtube-button'));
    });*/

    'use strict';

    window.code = window.code || {};

    window.code.stopVideo = function ( element ) {

        var iframe = element.querySelector( 'iframe');
        var video = element.querySelector( 'video' );
        /*console.log(element);
        console.log(iframe);
        console.log(iframe.src);
        console.log(video);*/
        if ( iframe ) {
            var iframeSrc = iframe.src;
            //if(iframeSrc.indexOf("leadpops.wistia.com/medias") !=-1){
            if(iframeSrc.indexOf("fast.wistia.com/embed/iframe") !=-1){
                /*var ap_f=iframeSrc.replace("?autoPlay=true", "?autoPlay=false");
                iframe.src = ap_f;*/
                //iframe.src = iframeSrc;
                // iframe.wistiaApi.pause();
                iframe.src = "";
            }else{
                iframe.src = iframeSrc;
            }
        }
        if ( video ) {
            // video.pause();
        }
        $("body").removeClass('modal-open');
        return false;
    };
    window.code.lightweightYoutubePlayer = function () {

        var dataYoutubeVideos = '[data-youtube]';

        //var dataWistiaVideos = '[data-wistia]';

        // var youtubeVideos = [...document.querySelectorAll(dataYoutubeVideos)];
        var youtubeVideos = [document.querySelectorAll(dataYoutubeVideos)];


        //var wistiaVideos = [...document.querySelectorAll(dataWistiaVideos)];

        /*console.log(youtubeVideos);

        console.log(wistiaVideos);*/

        function init() {
            var i=0;
            /*for (i = 0; i < youtubeVideos.length; i++) {
                bindYoutubeVideoEvent(youtubeVideos[0]);
            }*/
            /*for (i = 0; i < wistiaVideos.length; i++) {
                //bindYoutubeVideoEvent(youtubeVideos[0]);
                bindWistiaVideoEvent(wistiaVideos[0]);
            }*/
        }
        function bindWistiaVideoEvent(element){
            console.log(element);
            var button = element.querySelector('[data-wistia-button]');
            button.addEventListener('click', createIframeWistia);

        }
        function bindYoutubeVideoEvent(element) {
            console.log(element);
            var button = element.querySelector('[data-youtube-button]');
            button.addEventListener('click', createIframe);
        }
        function createIframeWistia(event){
            var url = event.target.dataset.wistiaButton;
            var title = event.target.dataset.videoTitle;
            var iframPlaceholder = event.target.parentNode;
            /*var modeltitle = document.querySelector("#lp-video-modal .modal-dialog .modal-content .modal-header .modal-title");
            modeltitle.innerHTML="<span>How To Video:</span>"+title;*/


            //var wisurl='https://fast.wistia.com/embed/medias/'+url+'?autoPlay=true&embedType=iframe&videoFoam=true';

            var wisurl='https://fast.wistia.com/embed/iframe/'+url;
            //var wisurl='https://leadpops.wistia.com/medias/'+url;

            //<script src="//fast.wistia.net/assets/external/E-v1.js" async></script>

            var htmlString = '<div class="video__youtube"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" autoPlay="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';

            iframPlaceholder.style.display = 'none';
            iframPlaceholder.insertAdjacentHTML('beforebegin', htmlString);
            iframPlaceholder.parentNode.removeChild(iframPlaceholder);

        }

        function createIframe(event) {
            var url = event.target.dataset.youtubeButton;
            var title = event.target.dataset.videoTitle;
            var youtubePlaceholder = event.target.parentNode;
            /*var modeltitle = document.querySelector("#lp-video-modal .modal-dialog .modal-content .modal-header .modal-title");
            modeltitle.innerHTML="<span>How To Video:</span>"+title;            */

            var htmlString = '<div class="video__youtube"> <iframe class="video__iframe" src="' + url + '" frameborder="0" allowfullscreen></iframe></div>';

            youtubePlaceholder.style.display = 'none';
            youtubePlaceholder.insertAdjacentHTML('beforebegin', htmlString);
            youtubePlaceholder.parentNode.removeChild(youtubePlaceholder);
        }

        return {
            init: init
        }
    };

})(window)

ready();

//lpchat();

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function ready() {

    var lightweightYoutubePlayer = new code.lightweightYoutubePlayer();

    if (document.readyState != 'loading') {

        //page.init();

    } else {

        document.addEventListener('DOMContentLoaded', lightweightYoutubePlayer.init);

    }
}

function lpchat(){
    //Start of Zopim Live Chat Script
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set._.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");$.src="//v2.zopim.com/?2zZD0se3AbZPgbt9qorzMU79K0wAQTsc";z.t=+new Date;$.type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
    //End of Zopim Live Chat Script
}
$(document).ready(function(){
    if(isMobile.any()) {
        $("#lp-mobile-check").show();
        $('header').addClass("mobile-class");
        $(".container").css("width","100%");
        //console.log("yes it is mobile device");
        //some code...
    }
    $(document).on("click",".lp-wistia-video",function(e){
        e.preventDefault();
        //stopvideo();
        console.log("loaded now");
        showlpvideo($(this).data("lp-wistia-title"), $(this).data("lp-wistia-key") );
        return;
    });
    $('#lp-video-modal').on('hidden.bs.modal', function () {
        stopvideo($(this));
    });

});
function pausewistiavideos(video){
    //console.log(video);
    var allVideos = Wistia.api.all();
    for (var i = 0; i < allVideos.length; i++) {
        //if (allVideos[i].hashedId() !== video.hashedId()) {
        allVideos[i].pause();
        //}
    }
}


function showlpvideo(title,wistiskey){
    pausewistiavideos();
    $("#lp-video-modal .modal-dialog .modal-content .modal-header .modal-title").html("<span>How To Video:</span>"+" "+title);
    var wisurl='https://fast.wistia.com/embed/iframe/'+wistiskey;
    //var wisurl='https://leadpops.wistia.com/medias/'+wistiskey;
    var htmlString = '<div class="video-lp-wistia"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';
    var iframe_ele=$("#lp-video-modal .modal-dialog .modal-content .modal-body .ifram-wrapper .video");
    iframe_ele.html(htmlString);
    $('#lp-video-modal').modal('show');
}
function stopvideo(ele){
    //console.log(ele);
    /*console.log(iframe);
    return;*/
    if(ele == undefined) ele = false;
    var iframe ="" ;
    var video ="" ;
    if(ele==false){
        iframe = $( 'iframe');
        video = $( 'video');
    }else{
        iframe = ele.find( 'iframe');
        video = ele.find( 'video');

    }
    if ( iframe ) {
        var iframeSrc = $(iframe).attr("src");
        //if(iframeSrc.indexOf("leadpops.wistia.com/medias") !=-1){
        if(iframeSrc.indexOf("fast.wistia.com/embed/iframe") !=-1){
            // $(iframe).wistiaApi.pause();
            iframe.src = "";
        }else{
            $(iframe).attr("src",iframeSrc);
        }
    }
    if ( video ) {
        // video.pause();
    }
    $("body").removeClass('modal-open');
    return false;
}


