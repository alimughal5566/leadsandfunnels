//console.log(site.items);
//var stringifyObj = JSON.stringify(site.items);
//

//jQuery(window).on('load',function(){
    function setscrollornot(obj){
        if(isMobile.any()) {
            obj.mCustomScrollbar('destroy');
        }else{
            obj.mCustomScrollbar('update');
            /*$(".right-section").mCustomScrollbar({
                axis:"y",
                theme:"lp-theme",
                scrollInertia: 60,
                mouseWheelPixels:100,
                // scrollButtons:{ enable: true },
                advanced: {
                    updateOnBrowserResize: true,
                    updateOnContentResize: true,
                    autoScrollOnFocus:false,
                    updateOnImageLoad:false,
                },
                contentTouchScroll:true,
                callbacks:{
                    onScrollStart:function(){
                    }
                }
            });*/
        }
    }
//});
$(document).on("click",".panel-default",function (){
    $(".panel-collapse").removeClass('show');
});
$(document).on("shown.bs.collapse", ".panel-collapse", function (e) {
    //alert('Event fired on #' + e.target.id);
    if($(this).data('type') == undefined) {
        var href = $(this).prev().attr("href");
        console.log(href);
        var _target = $(href).parents(".mCustomScrollbar");
        if (_target.length) {
            e.preventDefault();
            if (isMobile.any()) {
                $("html, body").animate({scrollTop: $(href).offset().top}, "slow");
            } else {
                _target.mCustomScrollbar("scrollTo", scrollToOffset(href));
            }
        }
    }
});
function scrollToOffset(el) {
    var offset = 315;
    if( $(".right-section .mCSB_container").length > 0) {
        var elTop = $(el).offset().top - $(".right-section .mCSB_container").offset().top;
        return elTop - offset;
    }
}
if(site.items) {
    var myObj = JSON.parse((site.items));
    ovrl_obj_data = [];
    for (var i in myObj) {
        ovrl_obj_data[i] = myObj[i];
    }
}
//console.log(JSON.parse(JSON.stringify({"13":{"vertical":{"id":13,"version_id":2,"vertical_name":"Mortgage","summary_title":"Talk With a Seasoned <br>Marketing Specialist","summary":"Schedule a 1:1 call with a leadPops <br> Marketing Coach and take your <br> advertising ROI to the next level.","phone":"(855) 732-3767","cta_title":"BOOK MY FREE CONSULTATION","cta_url":"https:\/\/leadpops.com\/consult\/","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11"},"vertical_cta":{"21":{"id":21,"vertical_id":13,"cta_name":"Access Our How-To Videos","cta_url":"http:\/\/leadpops.local\/lp\/support\/index\/sup\/videos","cta_target":"_blank","cta_link_desc":"(should point to support section of admin, specifically to another point with How-To Videos)","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11"},"22":{"id":22,"vertical_id":13,"cta_name":"Access Our Marketing Action Plans(MAPS)","cta_url":"http:\/\/leadpops.local\/lp\/popadmin\/hub","cta_target":"_self","cta_link_desc":"(add space between \"Plans(MAPS)\"; should point to the Marketing Hub)","active":1,"updated_at":"2017-05-15 18:16:27","created_at":"2017-05-15 18:16:27"},"23":{"id":23,"vertical_id":13,"cta_name":"Schedule a FREE 1:1 Marketing Coaching Call","cta_url":"https:\/\/leadpops.com\/consult\/","cta_target":"_self","cta_link_desc":"(should point to www.leadpops.com\/consult)","active":1,"updated_at":"2017-05-15 18:16:27","created_at":"2017-05-15 18:16:27"},"24":{"id":24,"vertical_id":13,"cta_name":"Submit a Technical Support Ticket","cta_url":"http:\/\/leadpops.local\/lp\/support\/index\/sup\/ticket","cta_target":"_self","cta_link_desc":"(should point to support section of admin , specifically to another point to submit a support ticket)","active":1,"updated_at":"2017-05-15 18:16:27","created_at":"2017-05-15 18:16:27"},"25":{"id":25,"vertical_id":13,"cta_name":"Email Support@leadPops.com","cta_url":"mailto:support@leadpops.com","cta_target":"_self","cta_link_desc":"(drop the 24\/7, should open up mailto: support@leadpops.com)","active":1,"updated_at":"2017-05-15 18:16:27","created_at":"2017-05-15 18:16:27"},"26":{"id":26,"vertical_id":13,"cta_name":"Call 855.3767 @ 7am-4:30pm PST, Mon-Fri","cta_url":"tel:8555323767","cta_target":"_self","cta_link_desc":"(should be click-to-call enabled)","active":1,"updated_at":"2017-05-15 18:16:27","created_at":"2017-05-15 18:16:27"}},"vertical_item":{"12":{"id":12,"vertical_id":13,"item_name":"Introduction<br>to Funnels","short_description":"Learn the basics about&lt;br \/&gt;leadPops Funnels and see what the rage is all about.","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"&lt;p&gt;You just signed up for a free trial of leadPops Funnelswelcome!&lt;\/p&gt;&lt;p&gt;&lt;br&gt;Now what, you ask?&lt;\/p&gt;&lt;p&gt;&lt;br&gt;Now its time to start generating leads! &lt;\/p&gt;&lt;p&gt;&lt;br&gt;Lets dive right into the quickest possible ways for you to generate some quality exclusive leads for free during the trial phase and beyond. &lt;\/p&gt;&lt;p&gt;&lt;br&gt;I want to make you a believer.&lt;\/p&gt;&lt;p&gt;&lt;br&gt;No wait I want to make you a raving fan!&lt;\/p&gt;&lt;p&gt;&lt;br&gt;Quick, to the bat cave er I mean, your leadPops admin panel :)&lt;\/p&gt;&lt;p&gt;&lt;br&gt;Youre going to want to get familiar with how the leadPops admin works for making quick customizations on the fly. Its super easy.&lt;\/p&gt;&lt;p&gt;&lt;br&gt;Your Funnels come ready-to-go out of the box, but keep in mind that making slight customizations to messaging on Funnels to match your ad, offer, email blast, blog content, social media postwhatever the campaigncan make a big difference in your lead conversion rates.&lt;\/p&gt;&lt;p&gt;&lt;br&gt;&lt;\/p&gt;","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/62.png","icon_name":"ovdesktop.png","order":1},"13":{"id":13,"vertical_id":13,"item_name":"Email Blast<br>Your Database","short_description":"Email your database with a link to one of your Funnels to generate leads fast.","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"Email your databse with a link to one of your Funnels to generate leads fasts.","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/62.png","icon_name":"ovemail.png","order":2},"14":{"id":14,"vertical_id":13,"item_name":"Optimize Your Website<br>to Convert More Leads","short_description":"Make sure your website converts traffic into leads consistently  and isn&#039;t coasting you clients.","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"Make sure your your website converts leads and isn&#039;t coasting you clients","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/53.png","icon_name":"ovconversion.png","order":3},"15":{"id":15,"vertical_id":13,"item_name":"Instant Leads w\/<br>Facebook Ads","short_description":"Facebook Ads + leadPops Funnels = exclusive leads like within an hour! Start now!","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"Facebook Ads + leadPops Funnels = exclusive leads.. like within an hour! Start now!","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/admin.png","icon_name":"ovlead.png","order":4},"16":{"id":16,"vertical_id":13,"item_name":"Google Analytics <br>& Facebook Pixels","short_description":"Create a custom audience for retargeting and track your marketing.","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"Create a custom audience for retargetting and track your marketing.","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/77.png","icon_name":"ovfacebook.png","order":5},"17":{"id":17,"vertical_id":13,"item_name":"Get More Leads from<br> All of your Marketing","short_description":"Learn how the most successful companies in the world are generating leads.","video_type":1,"video":"http:\/\/www.youtube.com\/embed\/lgZBsWGaQY0","description":"Learn how the most successful companies in the world are generating leads.","active":1,"updated_at":"2017-05-15 18:16:11","created_at":"2017-05-15 18:16:11","icon":"http:\/\/leadpops_helper.local\/images\/icons\/24.png","icon_name":"ovmconversion.png","order":6}}},"14":{"vertical":{"id":14,"version_id":2,"vertical_name":"Real state","summary_title":"Real state summary title","summary":"Real state summary ","phone":"(855) 732-3767","cta_title":"Real state cta title","cta_url":"Real state cta url","active":1,"updated_at":"2017-12-15 18:16:11","created_at":"2017-12-15 18:16:11"},"vertical_cta":{"27":{"id":27,"vertical_id":14,"cta_name":"Real state cta name","cta_url":"Real state cta url","cta_target":"_blank","cta_link_desc":"Real state cta link desc","active":1,"updated_at":"2017-12-15 18:16:11","created_at":"2017-12-15 18:16:11"}},"vertical_item":{"18":{"id":18,"vertical_id":14,"item_name":"Real state item name ","short_description":"Real state item short description ","video_type":1,"video":null,"description":"Real state description","active":1,"updated_at":"2017-12-15 18:16:11","created_at":"2017-12-15 18:16:11","icon":null,"icon_name":null,"order":0}}},"15":{"vertical":{"id":15,"version_id":2,"vertical_name":"Finance","summary_title":"Finance summary title","summary":"Finance summary","phone":" (855)  732-3767","cta_title":"Finance cta title","cta_url":"Finance cta url","active":1,"updated_at":"2017-12-15 00:00:00","created_at":"2017-12-15 00:00:00"},"vertical_cta":{"28":{"id":28,"vertical_id":15,"cta_name":"Finance cta name","cta_url":"Finance cta url","cta_target":"_blank","cta_link_desc":null,"active":1,"updated_at":"2017-12-15 00:00:00","created_at":"2017-12-15 00:00:00"}},"vertical_item":{"19":{"id":19,"vertical_id":15,"item_name":"Finance item name","short_description":"Finance short description","video_type":1,"video":null,"description":"Finance item description","active":1,"updated_at":"2017-12-15 00:00:00","created_at":"2017-12-15 00:00:00","icon":null,"icon_name":null,"order":0}}}})));
//var ovrl_obj_data = jQuery.parseJSON(str);
$.fn.toHtml=function(){
   return $(this).html($(this).text())
}
/*$( window ).resize(function() {
    var win_wid=$(this);
    console.log(window.innerWidth);
        if(window.innerWidth > 786) {
            $(".right-section").mCustomScrollbar({
                axis:"y",
                theme:"lp-theme",
                scrollInertia: 0,
                scrollButtons:{ enable: true },
                advanced: {
                    updateOnBrowserResize: true,
                    updateOnContentResize: true,
                    autoScrollOnFocus:false,
                }
            });
            $(".left_column_scrollbar").mCustomScrollbar({
                axis:"y",
                theme:"lp-theme",
                scrollInertia: 0,
                scrollButtons:{ enable: true },
                advanced: {
                    updateOnBrowserResize: true,
                    updateOnContentResize: true,
                    autoScrollOnFocus:false,
                }
            });
        } else {
            $(".right-section").mCustomScrollbar("destroy");
            $(".left_column_scrollbar").mCustomScrollbar("destroy");
        }
});
*/$(document).ready(function(){
    //Funnel builder helder
    FBHelper.init();

    $(document).on('click','.note_msg', function () {
        $("body").addClass('modal-open');
    });
    /*$("body").on("click", "a[href^=\'#\']", function (e) {
        var href = $(this).attr("href");
        var target = $(href).parents(".mCustomScrollbar");
        if (target.length) {
            e.preventDefault();
            target.mCustomScrollbar("scrollTo", href);
        }
    });*/

    $( "input:checkbox[class^=lp-ovr-tran-vid-]").on("click",function(){
        var complete=0;
        var itemid=$(this).data('itemid');
        var top_ele=$("#lp-ovr-tran-vid-tp-"+itemid);
        var bt_ele=$("#lp-ovr-tran-vid-bt-"+itemid);
        if($(this).is(":checked")){
            complete=1
            top_ele.prop('checked', true);
            bt_ele.prop('checked', true);
        }else{
            top_ele.prop('checked', false);
            bt_ele.prop('checked', false);
        }
        var vertical=$(this).data('vertical');
        var data={complete:complete,itemid:itemid,vertical:vertical,_token:ajax_token};
        clienttraningsetting(data);
        return;
    });

    $("#lp-train-module,#lp-train-module-sup").on("click",function(e){
        e.preventDefault();
        //console.log($("meta[data-lp-vpflag='lpvpflg']"));
        //$("meta[data-lp-vpflag='lpvpflg']").attr('name', '');
        $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />');
        $("#mask").show();
        $(".overlay_container").addClass("d-none");
        //var target_parent=$(this).data("ov-target");
        var target_parent=$(this).attr("data-ov-target");
        setTimeout(function(){
            //$("."+$(this).data("ov-target")).css({"display":"block"});
            $("."+target_parent).removeClass("d-none").addClass("d-block");
            $('body').css('overflow', 'hidden');
            $("#mask").hide();
        }, 1000);
    });
    /*$(document).on('click','.helper_popup .iframe_container img.lp-sup-video-thumbnail',function(e){
        $(this).css("display","none");
        var target_parent=$(this).attr("data-ov-target");
        var title=$(this).attr("data-lp-wistia-title");
        var wistia_key=$(this).attr("data-lp-wistia-key");
        if(wistia_key){
            var iframe_ele= $("."+target_parent+" .helper_popup .iframe_container");
            iframe_ele.html("");
            var wisurl='https://fast.wistia.com/embed/iframe/'+wistia_key;
            var htmlString = '<iframe class="popup-frame" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe>';
            iframe_ele.html(htmlString);
        }else{
            //console.log($(".helper_popup .iframe_container .popup-frame")[0].src);
            $("."+target_parent+" .helper_popup .iframe_container .popup-frame")[0].src += "?autoplay=1";

        }
        e.preventDefault();
    });*/
    //console.log($("#flagoverlay").val());
    if($("#flagoverlay").val()==1){
        $( "#lp-train-module").trigger( "click");
    }
    if($("#flagoverlayval").val()==1){
        $("#lp-helper-close").css("display","");
    }else{
        $("#lp-helper-close").css("display","none");
    }

    $('.sidebar_toggle').click(function(e){
        e.preventDefault();
        if($('.left_column .left_column_scrollbar').hasClass('_shown')){
            $('.left_column .left_column_scrollbar').hide();
            $('.left_column .left_column_scrollbar').removeClass('_shown');
            $('.left_column').css('height','auto');
        }else{
            $('.left_column .left_column_scrollbar').show();
            $('.left_column .left_column_scrollbar').addClass('_shown');
            $('.left_column').css('height','100%');
        }
    });
    $('.footer_close_link').click(function (e) {
        e.preventDefault();
        var heading="Confirmation";
        var question="Are you sure you want to close this screen permanently?";
        var cancelButtonTxt="Cancel";
        var okButtonTxt="Yes";
        confirmFunc(heading, question, cancelButtonTxt, okButtonTxt, closeoverlaymain);
    });

    $(".helper_overlay .close_btn").click(function(e){
        e.preventDefault();
        $('meta[name="viewport"]').remove();
        $("#flagoverlay").val(0);
        $("."+$(this).attr("data-ov-target")).removeClass("d-block").addClass("d-none");
        $('body').css('overflow', '');
        $("body").removeClass('modal-open');
        $('html').removeClass('en-survey');
        /*$.ajax({
            type: 'POST',
            url: site.baseUrl+site.lpPath+'/index/setoverlaysessionflag',
            success: function() {
                $("#flagoverlay").val(0);
                $(".overlay_container").css({"display":"none"});
                $('body').css('overflow', '');
            }
        });*/
    });
    function closeoverlaymain(){
        $.ajax({
            type: 'POST',
            url: site.baseUrl+site.lpPath+'/index/overlaycancel',
            data:{'action': 1, _token: ajax_token,  'client_id': site.client_id},
            success: function(data) {
                $("#flagoverlay").val(0);
                console.info($("#flagoverlay").val());
                $("#id556bg").hide();
                $( ".overlay_container" ).fadeOut( "fast", function () {
                    $(this).removeClass("d-block");
                    $("#id556bg").fadeIn('fast');
                    $(".lp_resource").hide().remove();
                    $('body').css('overflow', '');
                });
            }
        });
        //$('#ovlay-conform-popmdl').unbind(); // or $(this)
    }
    $(".helper_popup .close_btn").click(function(e){
        e.preventDefault();
        var ver_parent=$(this).attr("data-ov-target");
        $( "."+ver_parent +" .helper_popup" ).addClass('d-none');
        $( "."+ver_parent +" .helper_popup" ).find('iframe').attr('src','');
    });
    $('.lp_read_more').click(function (e) {
        e.preventDefault();
        var ver_parent=$(this).attr("data-ov-target");
        var verticalname=$(this).data("verticalname");
        var verticalid=$(this).data("verticalid");
        var verticaltar=$(this).data("verticaltar");
        var _id = $(this).attr('data-ovid');
        var last_id =  $("."+ver_parent+' .list').closest('li').last('li').attr('data-ovid');
        var lp_nav_btn=$("."+ver_parent+' .helper_popup .right_column .right-section .lp_navigation_btn a.lp-ol-nav-btn');
        if(_id==last_id){
            updatenavhtml(lp_nav_btn,true);
        }else{
            updatenavhtml(lp_nav_btn,false);
        }

        $("."+ver_parent+' .learn').removeClass('active');
        $("."+ver_parent+' #listitem'+_id).addClass('active');
        $("."+ver_parent+" .helper_popup" ).removeClass( "d-none");
        //_load_detail(site.items[_id]);

        _load_detail(ver_parent,ovrl_obj_data[verticalid]["vertical_item"][_id],'read');

        if($("."+ver_parent+' .left_column .left_column_scrollbar').hasClass('_shown')){
            $("."+ver_parent+' .left_column .left_column_scrollbar').hide();
            $("."+ver_parent+' .left_column .left_column_scrollbar').removeClass('_shown');
            $("."+ver_parent+' .left_column').css('height','auto');
        }
        lpUtilities.scrollArea();
    });
    $(".learn").click(function(){
        if($(this).hasClass('active')){
            return false;
        }
        var ver_parent=$(this).attr("data-ov-target");
        var verticalname=$(this).data("verticalname");
        var verticalid=$(this).data("verticalid");

        var _id = $(this).attr('data-ovid');
        var last_id =  $("."+ver_parent+' .list').closest('li').last('li').attr('data-ovid');
        var lp_nav_btn=$("."+ver_parent+' .helper_popup .right_column .right-section .lp_navigation_btn a.lp-ol-nav-btn');

        if(_id==last_id){
            updatenavhtml(lp_nav_btn,true);
        }else{
            updatenavhtml(lp_nav_btn, false);
        }

        $("."+ver_parent+' .learn').removeClass('active');
        $(this).addClass('active');
        //_load_detail(site.items[_id]);
        //_load_detail(ovrl_obj_data[_id]);
        if(_id){
            _load_detail(ver_parent,ovrl_obj_data[verticalid]["vertical_item"][_id],'learn');
        }

        if($("."+ver_parent+' .left_column .left_column_scrollbar').hasClass('_shown')){
            $("."+ver_parent+' .left_column .left_column_scrollbar').hide();
            $("."+ver_parent+' .left_column .left_column_scrollbar').removeClass('_shown');
            $("."+ver_parent+' .left_column').css('height','auto');
        }
        if(isMobile.any()) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }else{
            var _target = $(".right-section .mCustomScrollbar");
            _target.mCustomScrollbar("scrollTo",[0,0]);
        }
    });
    $(".lp_navigation_btn .accordian").click(function(){
        var ver_parent=$(this).attr("data-ov-target");
        var itemid=$(this).attr('data-itemid');
        var top_ele=$("#lp-ovr-tran-vid-tp-"+itemid);
        var bt_ele=$("#lp-ovr-tran-vid-bt-"+itemid);
        top_ele.prop('checked', true);
        bt_ele.prop('checked', true);
        var vertical=$(this).attr('data-vertical');
        var data={complete:1,itemid:itemid,vertical:vertical,_token:ajax_token};
        clienttraningsetting(data);
        var _id =  $("."+ver_parent+' .list a.active').closest('li').next('li').attr('data-ovid');
        var last_id =  $("."+ver_parent+' .list').closest('li').last('li').attr('data-ovid');
        /*console.log(itemid);
        console.log(_id);
        console.log(last_id);*/
        //if(_id==last_id){
        if(_id==last_id){
            updatenavhtml(this,true);
        }
        //_load_detail(site.items[_id]);
        //_load_detail(ovrl_obj_data[_id]);
        if(_id){
            $("."+ver_parent+' .learn').removeClass('active');
            $("."+ver_parent+' #listitem'+_id).addClass('active');
            _load_detail(ver_parent,ovrl_obj_data[vertical]["vertical_item"][_id],'learn');
        }
        if(itemid!=last_id){
            if(isMobile.any()) {
                //$('body').css('overflow', 'd-none');
                /*$("html, body").animate({ scrollTop: 0 }, "slow");
                $(".helper_overlay").animate({ scrollTop: 0 }, "slow");
                $(".helper_popup").animate({ scrollTop: 0 }, "slow");*/
                //$(".helper_popup").css("top", 0);
                //$(window).scrollTop(0);
            }else{
                var _target = $(this).parents(".mCustomScrollbar");
                _target.mCustomScrollbar("scrollTo",[0,0]);
                $(this).blur();
            }
        }
    });

    $(".lp_read_more").click(function(e){
        e.preventDefault();
        var lpdataVal = $(this).attr('data-ovid');
        if ( lpdataVal == 15 ){
            $(".lp-row").addClass('fb_ads');
        }else{
            $(".lp-row").removeClass('fb_ads');
        }
    });
    $("#listitem15").click(function(e){
        e.preventDefault();
        $(".lp-row").addClass('fb_ads');
    });
    $("#listitem12, #listitem13, #listitem14, #listitem16, #listitem17").click(function(e){
        e.preventDefault();
        $(".lp-row").removeClass('fb_ads');
    });

    function overlaytrigger(overlay){
        if(overlay == undefined) overlay = false;
        if(overlay==true){
            $('.helper_popup').css('overflow-y', 'scroll');
            $('body').css('overflow-y', 'hidden');
            $('body').css('position', 'fixed');
            $('body').css('height', '100%');
            $('body').bind('touchmove', function(e) {
               e.preventDefault()
           });
            $('.overlay').on('touchmove touchstart', function (e) {
               e.stopPropagation();
           });
        }else{
            $('.helper_popup').css('overflow-y', 'hidden');
            $('body').css('overflow-y', 'scroll');
            $('body').css('position', 'static');
            $('body').css('height', 'auto');
            $('body').unbind('touchmove');
        }

    }

    function updatenavhtml(tran_link,last){
        var lasthtml="";
        if(last==true){
            lasthtml='Complete this module ';
        }else{
            lasthtml='Complete this module and continue to the next  <i class="glyphicon glyphicon-arrow-right">';
        }
        $(tran_link).html(lasthtml);
    }

    function _load_detail(parent_ele,r_item,callfor){
        $("."+parent_ele+" .helper_popup .iframe_container").html('');
        var regex = /<br\s*[\/]?>/gi;
        $("."+parent_ele+" .helper_popup .heading" ).html((r_item["item_name"]).replace(regex, "\n"));
        $("."+parent_ele +' .helper_popup .sr_no').html(r_item["order"]+". ");
        var autoplay=false;
        if(callfor=="learn") autoplay=true;
        if(r_item["wistia_id"]){
            $("."+parent_ele+" .helper_popup .iframe_container").css('display','block');
            var iframe_ele= $("."+parent_ele+" .helper_popup .iframe_container");
            iframe_ele.html("");
            var wisurl='https://fast.wistia.com/embed/iframe/'+r_item["wistia_id"];
            //var wisurl='https://leadpops.wistia.com/medias/'+r_item["wistia_id"];
            var htmlString = '<iframe class="popup-frame" src="' + wisurl + '"';
            if(autoplay==false) htmlString +='autoPlay="false"';
             htmlString +='allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe>';
            iframe_ele.html(htmlString);
        }else{
            var ifsrc=r_item["video"];
            if(ifsrc!=""){
                if(autoplay==true) {
                    $("."+parent_ele+" .helper_popup .iframe_container img.lp-sup-video-thumbnail").css("display","none");
                    ifsrc +="?autoplay=1";
                }
                //console.log($(".helper_popup .iframe_container .popup-frame")[0].src);
                //$("."+target_parent+" .helper_popup .iframe_container .popup-frame")[0].src += "?autoplay=1";
                $("."+parent_ele+" .helper_popup .iframe_container").html('<img src="'+site.rackspaceDefaultImages+'/videoph-min.png" data-ov-target="'+parent_ele+'" data-lp-wistia-title="'+ r_item["title"]+'" data-lp-wistia-key="'+ r_item["wistia_id"]+'" class="lp-sup-video-thumbnail"><iframe class="popup-frame d-none"  src="'+ifsrc+'"  frameborder="1" allowfullscreen></iframe>');
                //$("."+parent_ele+" .helper_popup .iframe_container").html('<img src="'+site.baseUrl+site.lpAssetsPath+'/adminimages/videoph-min.png" data-ov-target="'+parent_ele+'" data-lp-wistia-title="'+ r_item["title"]+'" data-lp-wistia-key="'+ r_item["wistia_id"]+'" class="lp-sup-video-thumbnail"><iframe class="popup-frame d-none"  src="'+ifsrc+'"  frameborder="1" allowfullscreen></iframe>');
            }else {
                $("."+parent_ele+" .helper_popup .iframe_container").css('display','none');
            }
        }
        var lp_nav_btn=$("."+parent_ele+' .helper_popup .right_column .right-section .lp_navigation_btn a.lp-ol-nav-btn');
        //console.log(lp_nav_btn);
        lp_nav_btn.attr("data-itemid",r_item["id"]);
        lp_nav_btn.attr("data-vertical",r_item["vertical_id"]);

        var deshtml=$.parseHTML(r_item["description"]);
        //console.log(deshtml[0]);
        $("."+parent_ele+' .helper_popup .description').empty().html(deshtml[0]);
        $("."+parent_ele+' .helper_popup .description').toHtml();
        //$('.helper_popup .description').empty().append($deshtml[0]);

        $("."+parent_ele+' .popup-frame').removeClass('d-none');
        $("."+parent_ele+' .popup-frame').css('position','relative');

        /*$('.popup-frame').load(function (e) {
            $(this).removeClass('d-none');
            $(this).css('position','relative');
        });*/
        if(isMobile.any()) {
            $("."+parent_ele+" .right-section").mCustomScrollbar('destroy');
        }else{
            $("."+parent_ele+" .right-section").mCustomScrollbar("scrollTo", 0);
            $(".right-section .mCSB_container").css("top", 0);
            $(".right-section .mCSB_dragger").css("top", 0);

            $("."+parent_ele+" .right-section").mCustomScrollbar({
                axis:"y",
                theme:"lp-theme",
                scrollInertia: 60,
                mouseWheelPixels:100,
                // scrollButtons:{ enable: true },
                advanced: {
                    updateOnBrowserResize: true,
                    updateOnContentResize: true,
                    autoScrollOnFocus:false,
                    updateOnImageLoad:false,
                },
                contentTouchScroll:true,
                callbacks:{
                    onScrollStart:function(){
                    }
                }
            });
        }



        $("."+parent_ele+" .left_column_scrollbar").mCustomScrollbar({
            axis:"y",
            theme:"lp-theme",
            scrollInertia: 0,
            contentTouchScroll:true,
            // scrollButtons:{ enable: true },
            advanced: {
                updateOnBrowserResize: true,
                updateOnContentResize: true,
                autoScrollOnFocus:false,
            }
        });


        /*$(".right-section, .left_column_scrollbar").mCustomScrollbar({
            axis:"y",
            theme:"lp-theme",
            scrollInertia: 0,
            scrollButtons:{ enable: true }
        });*/
    }
});

function clienttraningsetting(pdata){
    $.ajax({

        url: site.baseUrl+site.lpPath+'/clienttraningsetting',

        type: 'POST',

        data: pdata,

        success: function (data) {

        },complete: function () {

        }
    });

}

function showlpovvideo(title,wistiskey){
    $("#lp-video-modal .modal-dialog .modal-content .modal-header .modal-title").html("<span>How-To Video:</span>"+title);
    var wisurl='https://fast.wistia.com/embed/iframe/'+wistiskey;
    //var wisurl='https://leadpops.wistia.com/medias/'+wistiskey;
    var htmlString = '<div class="video-lp-wistia"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';
    var iframe_ele=$("#lp-video-modal .modal-dialog .modal-content .modal-body .ifram-wrapper .video");
    iframe_ele.html(htmlString);
    $('#lp-video-modal').modal('show');
}

/* Generic Confirm func */
  function confirmFunc(heading, question, cancelButtonTxt, okButtonTxt, callback) {
    var confirmModal =
      $('<div id="ovlay-conform-popmdl" class="modal fade lp-modal-box ovlay-conform-pop">' +
          '<div class="modal-dialog modal-dialog-centered" role="document">' +
              '<div class="modal-content">' +
                  '<div class="modal-header">' +
                     '<h3 class="modal-title">' + heading +'</h3>' +
                  '</div>' +
                  '<div class="modal-body">' + question + '</div>' +
                  '<div class="modal-footer">' +
                      '<div class="action">' +
                          '<ul class="action__list">' +
                              '<li class="action__item">' +
                                '<button type="button" class="button button-bold button-cancel" data-dismiss="modal">' + cancelButtonTxt + '</button>' +
                              '</li>' +
                              '<li class="action__item">' +
                                '<button id="okButton" class="button button-bold button-primary"  type="submit">' + okButtonTxt + '</button>' +
                              '</li>' +
                          '</ul>' +
                      '</div>' +
                  '</div>' +
                '</div>' +
            '</div>' +
          '</div>');

      // $('<div id="ovlay-conform-popmdl" class="modal fade add_recipient ovlay-conform-pop ">' +
      //     '<div class="modal-dialog">' +
      //     '<div class="modal-content">' +
      //     '<div class="modal-header">' +
      //       '<a class="close" data-dismiss="modal" >&times;</a>' +
      //       '<h3>' + heading +'</h3>' +
      //     '</div>' +
      //
      //     '<div class="modal-body">' +
      //       '<p>' + question + '</p>' +
      //     '</div>' +
      //
      //     '<div class="modal-footer lp-modal-footer footer-border">' +
      //       '<a href="#!" class="btn lp-btn-cancel" data-dismiss="modal">' +
      //         cancelButtonTxt +
      //       '</a>' +
      //       '<a href="#!" id="okButton" class="btn lp-btn-add">' +
      //         okButtonTxt +
      //       '</a>' +
      //     '</div>' +
      //     '</div>' +
      //     '</div>' +
      //   '</div>');

      confirmModal.find('#okButton').click(function(event) {
          callback();
          confirmModal.modal('hide');
          event.stopPropagation();
      });
      confirmModal.on('hidden.bs.modal', function (e) {
            $('body').removeClass('modal-open');
        });

      confirmModal.modal('show');
  }

function resethomepagemessage(cval, anchor) {
    $(anchor).css('pointer-events','none');
    var $form = $('#ctaform');
    var msg = $('#mian__message').val();
    var current_hash = $("#current_hash").val();
    if (current_hash == '') {
        current_hash = $('[data-id="main-submit"]').data("lpkeys");
    }
    if (GLOBAL_MODE) {
        var newaction = "";
        switch (cval) {
            case "1":
                newaction = site.baseUrl + site.lpPath + '/global/resetCtaMessageActionGlobalAdminThree';
                break;
            case "2":
                newaction = site.baseUrl + site.lpPath + '/global/resetCtaDescriptionActionGlobalAdminThree';
                break;
        }
        if(newaction) {
            $($form).prop('action', newaction);
            if (checkIfFunnelsSelected()) {
                showGlobalRequestConfirmationForm($form);
            }
        }
    } else {
        $("#success-alert").find('span').text("");
        //$("#leadpopovery").show();
        //$("#mask").show();
        let {hide}  = displayAlert('loading', 'Resetting, Please wait...');
        var resetfun = "";
        switch (cval) {
            case "1":
                resetfun = "resetctamessage";
                break;
            case "2":
                resetfun = "resetctadescription";
                break;
        }

        var form_data = $($form).serializeArray();
        jQuery.ajax({
            type: "POST",
            data: form_data,
            url: site.baseUrl + site.lpPath + '/popadmin/' + resetfun + '/' + current_hash,
            success: function (data) {
                //  debugger;
                hide();
                var style_data = jQuery.parseJSON(data);
                var fontfamily = style_data.style.font_family.replace(" ", "_");
                var fontsize = style_data.style.font_size;
                var color = style_data.style.color;
                var line_height = style_data.style.line_height;
                var msg = style_data.style.main_message;
                var css_prop_obj = {
                    'font-family': style_data.style.font_family,
                    //'font-family':"Times new Romen,Sans serif",
                    'font-size': fontsize,
                    //'font-size':'14px',
                    'color': color,
                    'line-height':line_height,
                }
                // console.log(css_prop_obj);
                switch (cval) {
                    case "1":
                        // $("#success-alert").find('span').text("CTA Main Message style reset successfully");
                        //  debugger;
                        $('#msgfonttype').val(style_data.style.font_family).change();
                        $('#msgfontsize').val(fontsize).trigger('change');
                        $("#mian__message").val(msg).css(css_prop_obj);
                        $(".select2-linehight-main-msg, #mlineheight").val(line_height).trigger('change');
                        $('.colorSelector-mmessagecp').css('backgroundColor', color);
                        $('.select2__parent-font-type .select2-selection__rendered').css('font-family',style_data.style.font_family);
                        if (color) {
                            $('#mmessagecpval').val(color).trigger('change');;
                            $('.colorSelector-mmessagecp').ColorPickerSetColor(color);
                        }

                        var ta = document.querySelector('textarea#mian__message');
                        autosize(ta);
                        ta.value = msg;
                        var evt = document.createEvent('Event');
                        evt.initEvent('autosize:update', true, false);
                        ta.dispatchEvent(evt);

                        lptoast.cogoToast.success("CTA Main message default style has been reset.", {
                            position: 'top-center',
                            heading: 'Success'
                        });
                        break;
                    case "2":
                        //  debugger;
                        // $("#success-alert").find('span').text("Cta Description style reset successfully");
                        $('#dfonttype').val(style_data.style.font_family).trigger('change');
                        $('#dfontsize').val(fontsize).trigger('change');
                        $("#desc__message").val(msg).css(css_prop_obj);
                        $('.colorSelector-mdescp').css('backgroundColor', color);
                        $('.select2__parent-dfont-type .select2-selection__rendered').css('font-family',style_data.style.font_family);
                        //$(".select2-linehight-dsc-msg, #dlineheight").val(line_height).change();
                        $(".select2-linehight-dsc-msg, #dlineheight").val(line_height).trigger('change');
                        if (color) {
                            $('#dmessagecpval').val(color).trigger('change');
                            $('.colorSelector-mdescp').ColorPickerSetColor(color);
                        }

                        var ta = document.querySelector('textarea#desc__message');
                        autosize(ta);
                        ta.value = msg;
                        var evt = document.createEvent('Event');
                        evt.initEvent('autosize:update', true, false);
                        ta.dispatchEvent(evt);
                        lptoast.cogoToast.success("CTA Description default style has been reset.", {
                            position: 'top-center',
                            heading: 'Success'
                        });
                        break;
                }
                // enable cta message and featured image rendering in right preview for first question only
                FunnelsBuilder.enableCTAFeaturedImagePreviewTrigger();
                updateCtaDOMState();
                //$("#leadpopovery").hide();
                //$("#mask").hide();
                /*goToByScroll("success-alert");
                $("#success-alert").fadeTo(3000, 500).slideUp(500, function () {
                    $(this).slideUp(500);
                });*/
            },
        });
    }
    setTimeout(function () {
        $(anchor).css('pointer-events','auto');
    }, 2000);
    /*$('#ctaform').attr('action',site.baseUrl+site.lpPath+'/popadmin/'+resetfun+'/'+current_hash);
    $('#ctaform').submit();*/
    return false;
}

function validateCTAForm($form, ajaxCtaHandler) {
    $form.validate({
        rules: {
            mmainheadingval: {
                required: true,
                //minlength: 30
            },
            dmainheadingval: {
                required: false,
                //minlength: 50
            }
        },

        messages: {
            mmainheadingval: {
                required: "Please enter the message."
            },
            dmainheadingval: {
                required: "Please enter the description."
            }
        },
        submitHandler: function (form) {
            // disable global mode for funnel builder page
            if (FBHelper.isFunnelBuilder() && FBHelper.isActiveFunnelBuilder()) {
                GLOBAL_MODE = false;
            }
            ajaxCtaHandler.submitForm(function (response, isError) {
                if(!isError && FBHelper.isFunnelBuilder()) {
                    if ($('[data-toggle-cta]').is(':checked')) {
                        $('[data-enable-cta-class]').addClass('active');
                        $('[data-enable-cta-feature-icon]').removeClass('inactive');
                    } else {
                        $('[data-enable-cta-class]').removeClass('active');
                        $('[data-enable-cta-feature-icon]').addClass('inactive');
                    }

                    // enable cta message and featured image rendering in right preview for first question only
                    FunnelsBuilder.enableCTAFeaturedImagePreviewTrigger();
                    updateCtaDOMState();

                    $('#homepage-cta-message-pop').modal('hide');
                }
            });

            // debugger;
            // if (GLOBAL_MODE) {
            //   //  $($form).prop('action', $($form).data("global_action"));
            //     if (checkIfFunnelsSelected()) {
            //         //  debugger;
            //          if (confirmationModalObj.globalConfirmationCurrentForm) {
            //        // if (1) {
            //             form.submit();
            //         } else {
            //             showGlobalRequestConfirmationForm($form);
            //         }
            //     }
            //     // form.submit();
            // } else {
            //     form.submit();
            // }
        }

    });
}

/**
 * update hidden variables in DOM for populating cta popup
 */
function updateCtaDOMState() {
    $('#selected_font_main_message').val($('#msgfonttype').val());
    $('#selected_font_size_main_message').val($('#msgfontsize').val());
    $('#selected_line_spacing_main_message').val($('[data-main-message-line-spacing]').val());
    $('#selected_color_main_message').val($('.colorSelector-mmessagecp').css('backgroundColor'));
    $('#selected_font_description').val($('#dfonttype').val());
    $('#selected_font_size_description').val($('#dfontsize').val());
    $('#selected_line_spacing_description').val($('[data-description-line-spacing]').val());
    $('#selected_color_description').val($('.colorSelector-mdescp').css('backgroundColor'));
    let selected_cta_toggle = $('[data-toggle-cta]').is(':checked') ? 1 : 0;
    $('#selected_cta_toggle').val(selected_cta_toggle);
    $('#selected_cta_main_message').val($('[data-cta-main-message]').val().trim());
    $('#selected_cta_description').val($('[data-cta-description]').val().trim());
}


var FBHelper = {
    is_funnel_builder: false,
    init:function(){
        if(jQuery('#funnel_builder').length) {
            this.is_funnel_builder = true;
        }
    },

    isFunnelBuilder: function () {
        return this.is_funnel_builder;
    },

    isActiveFunnelBuilder: function () {
        return jQuery('#funnel_builder').val() == 1;
    }
};
