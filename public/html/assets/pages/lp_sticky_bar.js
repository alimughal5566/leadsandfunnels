var setting = {
    'client_id' : '',
    'clients_leadpops_id' : '' ,
    'update_form' : false,
    'token': '',
    'domain_name': '',
    'element_id'  : '',
    'active_flag' : false,
    'insert_flag' : false,
    'add_flag' : true,
    'data_id' : '0',
    'sticky_funnel_url': '',
    'url_arr' : '',
    'cta_box_shadow':'10',
    'change_flag':'',
    'previous_sticky_url' : '',
    'lp_stop' : true,
    'owl_height':0,
    'third_party_website_flag':'0',
    'current_funnel_sticky_id' : '',
    'thrid_party_last_insert_url' : '',
    'pages_flag': '',
    'sticky_url_pathname' : '',
    'background_image_path':'',
    'logo_image_path':'',
    'sticky_url_protocol': 'http://',
    'inactive_funnel_url' : '',
    'updated_index' : '',
    'sticky_cta': 'I am your sticky bar and i am being awesome!',
    'sticky_button' : 'Lets do it!',
    'sticky_url' : '',
    'sticky_js_file':'',
    'sticky_status' : '0',
    'cta_text_font_family':'',
    'cta_btn_text_font_family':'',
    'cta_btn_vertical_padding':'20px',
    'cta_btn_horizontal_padding':'53px',
    'pending_flag' : '0',
    'sticky_website_flag' : '0',
    'script_type' : 'a',
    'zindex' : '1000000',
    'zindex_type' : 1,
    'sticky_size':'f',
    'ratio':1,
    'owl_index':null,
    'third_party_index':null,
    'checker':0,
    'thrid_party_website_share_url':'',
    'another_thrid_party_website_share_url': '0',
    'last_thrid_party_website_share_url': '',
    'last_thrid_party_website_share_url_style': '',
    'hide_animation': '0',
    'sticky_location':'t',
    'temp' : '0',
    'when_to_display':'immediately',
    'when_to_hide':'immediately',
    'advance_sticky_location': 'stick-at-top',
    'cta_btn_animation':'wobble',
    'logo_image_base_code':'',
    'logo_image':'',
    'background_image':'',
    'background_image_base_code':'',
    'background_image_added_flag':'0',
    'third_party_url_edit':'',
    'third_party_url_edit_hash':'',
    'logo_image_added_flag':'0',
    'logo_image_replacement':'0',
    'background_image_removed_flag':'0',
    'logo_image_removed_flag':'0',
    'campany_name':'0',
    'full_page_sticky_bar_flag':'off',
    'old_slug':'',
    'logo_spacing':'32',
    'sticky_bar_update_flag':0,
    'logo_left_spacing':'0',
    'logo_bottom_spacing':'0',
    'number_of_share_links':0,
    'base_code':0,
    'cta_text_html': '<p style="font-size: 30px; color: #ffffff;" >I am your sticky bar and i am being awesome!</p>',
    'cta_btn_text_html': '<p style="font-size: 26px;  color: #ffffff;" >Lets do it!</p>',
    'placed_select2_html':
        '<option value="stick-at-top">Stick it to the top</option>\n' +
        '<option value="top-disappear-on-scroll">Top -- disappears on scroll</option>\n' +
        '<option value="stick-at-bottom">Stick it to the bottom</option>\n' +
        '<option class="non_clixly" value="bottom-disappear-on-scroll">Bottom -- disappears on scroll</option>',
    'display_select2_html':
        '<option value="Immediately">Immediately</option>\n' +
        '<option value="5-sec">After 5 seconds</option>\n' +
        '<option value="10-sec">After 10 seconds</option>\n' +
        '<option value="20-sec">After 20 seconds</option>\n' +
        '<option value="30-sec">After 30 seconds</option>\n' +
        '<option value="45-sec">After 45 seconds</option>\n' +
        '<option value="60-sec">After 60 seconds</option>\n' +
        '<option value="little-scroll">After scrolling a little</option>\n' +
        '<option value="middle-scroll">After scrolling to middle</option>\n' +
        '<option value="bottom-scroll">After scrolling to bottom</option>\n' +
        '<option value="user-intend">When user intends to leave</option>',
    'new_placed_select2_html':
        '<option value="stick-at-top">Stick it to the top</option>\n' +
        '<option value="stick-at-bottom">Stick it to the bottom</option>',
    'new_display_select2_html':
        '<option value="Immediately">Immediately</option>\n' +
        '<option value="5-sec">After 5 seconds</option>\n' +
        '<option value="10-sec">After 10 seconds</option>\n' +
        '<option value="20-sec">After 20 seconds</option>\n' +
        '<option value="30-sec">After 30 seconds</option>\n' +
        '<option value="45-sec">After 45 seconds</option>\n' +
        '<option value="60-sec">After 60 seconds</option>\n'+
        '<option value="user-intend">When user intends to leave</option>',

};
var thrid_party_url_clicked ="";
var third_party_setting = {
    'update_form' : false,
    'url_arr' : '',
    'cta_box_shadow':'10',
    'previous_sticky_url' : '',
    'lp_stop' : true,
    'third_party_website_flag':'0',
    'current_funnel_sticky_id' : '',
    'thrid_party_last_insert_url' : '',
    'pages_flag': '',
    'sticky_url_pathname' : '',
    'sticky_url_protocol': 'http://',
    'inactive_funnel_url' : '',
    'sticky_cta': 'I am your sticky bar and i am being awesome!',
    'sticky_button' : 'Lets do it!',
    'sticky_url' : 'example.com',
    'sticky_js_file':'',
    'sticky_status' : '0',
    'cta_btn_vertical_padding':'20px',
    'cta_btn_horizontal_padding':'53px',
    'pending_flag' : '0',
    'sticky_website_flag' : '0',
    'script_type' : 'a',
    'zindex' : '1000',
    'cta_color': 'ffffff',
    'url_flag': "",
    'cta_background_color': '000000',
    'cta_btn_color' : 'ffffff',
    'cta_btn_background_color' :'FF9900',
    'hide_animation' : '0',
    'when_to_display' : 'Immediately',
    'when_to_hide' : 'Immediately',
    'cta_btn_animation' : 'Wobble',
    'logo_spacing':'32',
    'full_page_sticky_bar_flag' :'off',
    'advance_sticky_location': 'stick-at-top',
    'zindex_type' : "1",
    'background_image_path' : "",
    'edit_url_hash' : "",
    'sticky_location':'t',
    'checker':0,
    'third_party_url_edit_flag': 0,
    'sticky_size':'138',
    'ratio':1,
    'owl_index':null,
    'third_party_index':null,
    'third_party_url_edit' :"",
    'cta_btn_text_font_family' : "",
    'cta_text_font_family' : "",
    'logo_image_path' : "",
    'logo_image_height' : "",
    'logo_image_width' : "",
    'another_cta_url' : "",
    'temp' : '0',
    'background_image_base_code' : "",
    'logo_image_path_base_code' : "",
    'background_image_color_overlay' : "00aef0",
    'logo_image_replacement' : "left",
    'background_image_opacity' : "0.60",
    'background_image_size' : "100",
    'logo_image_size' : "100",
    'stickybar_number' : "",
    'stickybar_number_flag' :"0",
    'background_image_added_flag':'0',
    'logo_image_added_flag':'0',
    'background_image':'',
    'background_image_removed_flag':'0',
    'logo_image_removed_flag':'0',
    'stickybar_btn_flag' : "f",
    'campany_name':'0',
    'old_slug':'',
    'temp_logo_path':'',
    'temp_background_path':'',
    'stickybar_cta_btn_other_url' : "",
    'sticky_bar_update_flag':0,
    'website_change':0,
    'base_code':0,
    'sticky_bar_v2' : false,
    'cta_text_html': '<p style="font-size: 30px; color: #ffffff;" >I am your sticky bar and i am being awesome!</p>',
    'cta_btn_text_html': '<p style="font-size: 26px;  color: #ffffff;" >Lets do it!</p>'
};
var owl = $('.owl-carousel');
var dropzone;
var funnel_index = "";
var a = 0;
var checker = 0;
var has_error = 0;
var c_data_obj = {};
var current_temp_data_obj = {};
var image_file_reader= {};
/*
* Note: These websites are not allowed.
* */
var not_allowed_website = ["Amazon.com",
    "Bankrate.com", "Remax.com", "Homes.com",
    "Redfin.com", "Forbes.com","Zillow.com",
    "Facebook","LinkedIn","Twitter"];
var third_party_obj = "";

/*current funnel index*/

function getActiveElementObj()
{
    // return funnel_data[funnel_index];
}

/*owl refresh*/

function owl_refresh(time)
{
    setTimeout(function(){
        owl.trigger('refresh.owl.carousel');
    },time);
}

/*full page outerheight*/

function fullpage_outerheight()
{
    var window_h = $(window).height();
    $('.lp-sticky-bar__outer').css({'height':window_h});
}

/* page outter height */

function page_outerheight()
{
    var result = $(window).innerHeight();
    var lp_stickbar_header = $(".leadpops-wrap").innerHeight();
    var height = result-lp_stickbar_header;
    $('.lp-sticky-bar__outer').css({'height':height});
}

/*image resizer*/

function presize($obj, w, h)
{
    var nw = jQuery('body').find($obj).width(),
        nh = jQuery('body').find($obj).height();
    if ((nw > w) && w > 0) {
        nw = w;
        nh = (w / jQuery('body').find($obj).width()) * jQuery('body').find($obj).height();
    }
    if ((nh > h) && h > 0) {
        nh = h;
        nw = (h / jQuery('body').find($obj).height()) * jQuery('body').find($obj).width();
    }
    xscale = jQuery('body').find($obj).width() / nw;
    yscale = jQuery('body').find($obj).height() / nh;
    jQuery('body').find($obj).width(nw).height(nh);
}

/*logo image resize*/

function logopresize($obj, w, h)
{
    var nw = jQuery('body').find($obj).width(),
        nh = jQuery('body').find($obj).height();
    nw = w;
    nh = (w / jQuery('body').find($obj).width()) * jQuery('body').find($obj).height();
    nh = h;
    nw = (h / jQuery('body').find($obj).height()) * jQuery('body').find($obj).width();
    xscale = jQuery('body').find($obj).width() / nw;
    yscale = jQuery('body').find($obj).height() / nh;
    jQuery('body').find($obj).width(nw).height(nh);
}

/* import logo Image  and create preview*/

function importlogoImage(input)
{
    var fileReference = input.files && input.files[0];
    if(fileReference){
        image_file_reader= "";
        image_file_reader= new FileReader();
        setting.base_code ="";
        image_file_reader.addEventListener("load", function () {
            $('.cta__logo').attr("src", image_file_reader["result"]);
            setting.logo_image_base_code = image_file_reader["result"];
            $(".dropzone__logo-image img").remove();
            $(".dropzone__logo-image").append('<img src="'+setting.logo_image_base_code+'" class="logo_preview" >\n');
            presize($(".cta__logo") , $(".lp_froala__sticky-bar-text").offset().left , $(".leadpops-wrap").height() );
            $(".dropzone__logo-image").css("pointer-events"," none");
            if ($('.select__logo-placement').val() == "top"){
                $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()));
                $(".cta__logo").css("left","");
                if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
                    $(".cta__logo").css("bottom",+c_data_obj.logo_spacing+"px");
                }else{
                    $(".cta__logo").css("bottom","-"+c_data_obj.logo_spacing+"px");
                }
            } else {
                $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()));
                $(".cta__logo").css("bottom","");
                $(".cta__logo").css("left","-"+c_data_obj.logo_spacing+"px");
            }
            $("#dropzone-logo-space").bootstrapSlider('setValue', c_data_obj.logo_spacing,true);
            $(".logo_preview").css({'height':$(".cta__logo").height(),'width':$(".cta__logo").width(),"margin":"auto"});
        });
        image_file_reader.readAsDataURL(fileReference);
    }
}

/*import background Image and create preview*/

function importbackgroundImage(input)
{
    var fileReference = input.files && input.files[0];
    if(fileReference){
        image_file_reader= "";
        image_file_reader= new FileReader();
        setting.base_code ="";
        image_file_reader.addEventListener("load", function () {
            $('.leadpops-wrap').css("background-image", "url("+image_file_reader["result"]+")");
            setting.background_image_base_code = image_file_reader["result"];
            $('.leadpops-wrap').addClass("has_background_image");
            $(".dropzone__background-image .background-preview").remove();
            $(".dropzone__background-image").append("<div style='background-image:url("+setting.background_image_base_code+")' class='background-preview' ></div>\n");
            $(".dropzone__background-image ").css("pointer-events","none");
            $(".background-preview").css({'height':"167px",'width':"100%","margin":"auto","background-size":"contain","background-repeat":"no-repeat","background-position" : "50% 50%"})
        });
        image_file_reader.readAsDataURL(fileReference);
    }
    return;
}

/*RGB to Hex code*/

function rgb2hex(rgb)
{
    rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    return (rgb && rgb.length === 4) ? "" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
}

/* init dropzone for logo image */

function logo_dropzone_init (obj)
{
    $( "#logo-image .dropzone__wrapper" ).append( '<div id="dropzone__logo-image" class="dropzone dropzone__logo-image dropzone__logo-image_cloud" action="UploadImages"></div>\n' );
    dropzone = $(".dropzone__logo-image").dropzone(
        {
        thumbnailWidth: 290,
        thumbnailHeight: 120,
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        init: function()
        {
            instance = this;
            if(obj.logo_image_path != null && obj.logo_image_path != "")
            {
                $(".dropzone__logo-image").css("pointer-events"," none");
                var logo_image = obj.logo_image_path;
                $(".dropzone__logo-image").append('<img src="'+logo_image+'" class="logo_preview" >\n');
                $(".logo_preview").css({'height':$(".cta__logo").height(),'width':$(".cta__logo").width(),"margin":"auto"})
                $("#logo-image .dropzone__wrapper").addClass("dropzone__wrapper_after-added");
                $(".dropzone__control-wrapper_logo").slideDown();
                // $(".dropzone__logo-image").css("background-image","none");
                $(".dz-message").first().css("display","none");
                $(".lp-sticky-bar__wrapper").addClass("logo-added");
                owl_refresh(400);
            }else
                {
                    $(".lp-sticky-bar__wrapper").removeClass("logo-added");
                    $(".dropzone__logo-image").css("pointer-events"," auto");
                    $(".dropzone__control-wrapper_logo").slideUp();
                    $(".dz-message").first().css("display","block");
                    // $(".dropzone__logo-image").css("background-image",'url("../lp_assets/adminimages/cloud-uploading.png)');
                    $(".dropzone__logo-image img").remove();
                }
            instance.on("maxfilesexceeded", function(file)
            {
                this.removeAllFiles();
                this.addFile(file);
            });
            instance.on("addedfile", function(file)
            {
                $("#logo-image .dropzone__wrapper").addClass("dropzone__wrapper_after-added");
                $("#logo-image .dz-started .dz-message").css("display","none");
                $(".lp-sticky-bar__wrapper").addClass("logo-added");
                $(".dropzone__logo-image").css("pointer-events"," none");
                if (file.type != "image/jpeg" && file.type != "image/jpg" && file.type != "image/png" && file.type != "image/gif")
                {
                    $(".logo-error").removeClass("dropzone-error");
                    $("#dropzone__logo-image-error").remove();
                    $("#dropzone__logo-image").addClass("dropzone-error");
                    $('#dropzone__logo-image').after('<label id="dropzone__logo-image-error" class="error logo-error" for="dropzone__logo-image">Please add image with type png, jpg, gif and jpeg. Delete this one and upload&nbsp;again.</label>');
                    owl_refresh(400);
                    return;
                }else if(file.size > 2048*1000)
                {
                    if(!$("#dropzone__logo-image").hasClass("dropzone-error"))
                    {
                        $(".logo-error").removeClass("dropzone-error");
                        $("#dropzone__logo-image-error").remove();
                        $("#dropzone__logo-image").addClass("dropzone-error");
                        $('#dropzone__logo-image').after('<label id="dropzone__logo-image-error" class="error logo-error" for="dropzone__logo-image">Please add image of 2MB or smaller. Please Delete this one and upload&nbsp;again.</label>');
                        owl_refresh(400);
                        return;
                    }
                }else
                    {
                        $("#dropzone__logo-image-error").remove();
                        $(".dropzone__logo-image").css("pointer-events","auto");
                        $(".logo-error").removeClass("dropzone-error");
                        $(".lp-sticky-bar__wrapper").addClass("logo-added");
                    }

                setting.update_form = true;
                setting.logo_image_added_flag = 1;
                setTimeout(function()
                {
                    owl.trigger('refresh.owl.carousel');
                    $('#dropzone-logo-size').trigger('change');
                    $(".logo_preview").css({'height':$(".cta__logo").height(),'width':$(".cta__logo").width(),"margin":"auto"});
                },200);

            });
            instance.on("removedfile", function(file)
            {
                owl_refresh(400);
            });
            instance.on("thumbnail", function(file)
            {
                if ( (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png"
                        || file.type == "image/gif") && file.size < 2048*1000)
                {
                    importlogoImage(this);
                    if ($(".select__logo-placement").val() == "top"){
                        $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
                    } else
                        {
                            $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
                        }
                    setting.update_form = true;
                    if($(".lp-sticky-bar__wrapper").hasClass("cta__logo-above"))
                    {
                        setTimeout(function(){
                            page_outerheight();
                        },400);
                    }
                }
                $(".dropzone__control-wrapper_logo").slideDown();
                owl_refresh(400);
            });
        },
        paramName: "file",
        dictDefaultMessage: "Drag and Drop your file here <br> or you can <u>browse</u> your computer.",
        maxFilesize: 5,
        maxFiles : 1,
        autoProcessQueue : false,
    });

}

/*init dropzone for background image*/

function background_dropzone_init(obj)
{
    $( "#background-image .dropzone__wrapper" ).append( '<div id="dropzone__background-image" class="dropzone dropzone__background-image dropzone__background-image_cloud" action="UploadImages"></div>\n');
    $(".dropzone__background-image").dropzone(
        {
        thumbnailWidth: 280,
        thumbnailHeight: 190,
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        init: function()
        {
            instance = this;
            if(obj.background_image_path != null  && obj.background_image_path != "" && obj.background_image_path != "none" )
            {
                $(".dropzone__background-image ").css("pointer-events","none");
                $(".color-overlay").css("background-color","#"+obj.background_image_color_overlay);
                $("#background-image .dropzone__wrapper").addClass("dropzone__wrapper_after-added");
                $(".dropzone__control-wrapper_background").slideDown();
                $(".lp-sticky-bar__wrapper").addClass("backgound-added");
                $('.leadpops-wrap').addClass("has_background_image");
                $(".dz-message").last().css("display","none");
                $(".dropzone__background-image").append("<div style='background-image:url("+obj.background_image_path+")' class='background-preview' ></div>\n");
                $(".background-preview").css({'height':"167px",'width':"100%","margin":"auto","background-size":"contain","background-repeat":"no-repeat","background-position" : "50% 50%"})

            }else
                {
                    $(".dropzone__background-image ").css("pointer-events","auto");
                    $(".color-overlay").css("background-color","");
                    $(".dz-message").last().css("display","block");
                    $(".dropzone__background-image ").css("pointer-events","auto");
                    $(".dropzone__control-wrapper_background").slideUp();
                    $(".dropzone__background-image .background-preview").remove();
                }

            instance.on("maxfilesexceeded", function(file)
            {
                this.removeAllFiles();
                this.addFile(file);
            });
            instance.on("addedfile", function(file)
            {
                $(".color-overlay").css("background-color","#"+obj.background_image_color_overlay);
                $(".lp-sticky-bar__wrapper").addClass("backgound-added");
                $("#background-image .dropzone__wrapper").addClass("dropzone__wrapper_after-added");
                $("#background-image .dz-started .dz-message").css("display","none");
                if (file.type != "image/jpeg" && file.type != "image/jpg" && file.type != "image/png" && file.type != "image/gif" && file.size < 1024*1024*2/*2MB*/) {
                    $("#dropzone__background-image").removeClass("dropzone-error");
                    $('.bg-error').remove();
                    $("#dropzone__background-image").addClass("dropzone-error");
                    $('#dropzone__background-image').after('<label id="dropzone__background-image-error" class="error bg-error" for="dropzone__background-image">Please add image with type png, jpg, gif and jpeg. Please Delete this one and upload&nbsp;again.</label>');
                    owl_refresh(400);
                    $(".dropzone__background-image ").css("pointer-events","none");
                    return;
                }else if(file.size > 2024*1000)
                {
                    $("#dropzone__background-image").removeClass("dropzone-error");
                    $('.bg-error').remove();
                    $("#dropzone__background-image").addClass("dropzone-error");
                    $('#dropzone__background-image').after('<label id="dropzone__background-image-error" class="error bg-error" for="dropzone__background-image">Please add image of 2MB or smaller. Please Delete this one and upload&nbsp;again.</label>');
                    owl_refresh(400);
                    $(".dropzone__background-image ").css("pointer-events","none");
                    return;
                }else
                    {
                        $("#dropzone__background-image").removeClass("dropzone-error");
                        $('.bg-error').remove();
                        setting.update_form = true;
                        setting.background_image_added_flag = 1;
                    }
                owl_refresh(400);
            });
            instance.on("removedfile", function(file)
            {
                owl_refresh(400);
            });
            instance.on("thumbnail", function(file)
            {
                if ( (file.type == "image/jpeg" || file.type == "image/jpg" || file.type == "image/png" || file.type == "image/gif")
                    && file.size < 2048*1000) {
                    setting.update_form = true;
                    importbackgroundImage(this);
                }
                $(".dropzone__control-wrapper_background").slideDown();
                owl_refresh(400);
            });
            // var $this = this;
            // $(".dropzone__logo-remove").click(function() {
            //     $this.removeAllFiles(true);
            // });
        },
        paramName: "file",
        dictDefaultMessage: "Drag and Drop your file here <br> or you can <u>browse</u> your computer.",
        maxFilesize: 5,
        maxFiles : 1,
        // previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size" data-dz-size></div><img data-dz-thumbnail /></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
        autoProcessQueue : false
    });

}

/*current url's style render*/

function third_party_sticky_popup(third_party_obj)
{
    $(".cta__logo").hide();
    setting.sticky_bar_update_flag = 0;
    if(setting.website_change == 1){
        if(c_data_obj.third_party_website != ""){
            if (c_data_obj.third_party_website[c_data_obj.sticky_id].length  != 0 && $(".zindex-adding-stickybar").val() == 1){
                if(c_data_obj.third_party_website == ""){
                    $("#third-party__previoue-link").hide();
                }else{
                    $("#third-party__previoue-link").show();
                }
                third_party_share_url_update(third_party_obj);
                $(".slug__url-text").show();
                specific_3rd_party_url_render(c_data_obj);
                $(".sorting").first().attr('data-sort','desc');
            }else {
                /* setting.thrid_party_website_share_url = third_party_obj.sticky_url;*/
                setting.last_thrid_party_website_share_url="";
                setting.last_thrid_party_website_share_url_style = "";
                $('.thrid_party_website_share_url').val("");
                specific_page_render();
                $("#cta_url").val(c_data_obj.sticky_url);
                /*$(".zindex-adding-stickybar").val('0').trigger('change');
                $(".zindex-adding-stickybar").trigger('change');*/
            }
        }else if($(".zindex-adding-stickybar").val() != 1) {
            $("#cta_url").val(c_data_obj.sticky_url);
        }else{
            $("#cta_url").val("");
        }

        specific_page_render(c_data_obj);
        setting.update_form = true;
        setting.sticky_bar_update_flag = 1;

    }
    // sticky text change
    setTimeout(function () {
        $('.lp_froala__sticky-bar-text').froalaEditor('html.set', third_party_obj.cta_text_html);
        $('.lp_froala__sticky-bar-button').froalaEditor('html.set', third_party_obj.cta_btn_text_html);
    },100);
    // logo image change
    $('.cta__logo').removeAttr("style");
    $(".dropzone__logo-image").remove();
    logo_dropzone_init(third_party_obj);
    if(third_party_obj.logo_image_width != null ){
        if(third_party_obj.logo_image_width != ""){
            $(".cta__logo").css("width",  parseInt(third_party_obj.logo_image_width)+"px");
            $(".cta__logo").css("height",parseInt(third_party_obj.logo_image_height)+"px");
            $(".logo_preview").css({'height':parseInt(third_party_obj.logo_image_height)+"px",'width': parseInt(third_party_obj.logo_image_width)+"px","margin":"auto"});
            $(".cta__logo-wrapper").css("width",""+third_party_obj.logo_image_size+"px");
        }else{
            $('.cta__logo').removeAttr("style");
        }
    }else{
        $('.cta__logo').removeAttr("style");
    }
    if(third_party_obj.logo_image_path != null  && third_party_obj.logo_image_path != ""){
        setting.logo_image = third_party_obj.logo_image_path;
        $('.cta__logo').attr("src", setting.logo_image);
        setting.temp_logo_path = third_party_obj.logo_image_path;
    }else {
        setting.logo_image = "";
        $('.cta__logo').attr("src", setting.logo_image);
    }
    if(third_party_obj.logo_image_path == null){
        $('.cta__logo').removeAttr("style");
    }
    $('.select__logo-placement').val(third_party_obj.logo_image_replacement);
    $('.select__logo-placement').trigger('change');
    if(third_party_obj.full_page_sticky_bar_flag == "on"){
        $('#lp-sticky-bar__full-page-checker').prop('checked',true);
        $(".lp-sticky-bar__wrapper").addClass("lp-sticky-bar__full-page");
        setTimeout(function(){
            fullpage_outerheight();
            owl.trigger('refresh.owl.carousel');
        },1000);
    }
    else {
        $(".leadpops-wrap").css('width','100%');
        $('#lp-sticky-bar__full-page-checker').prop('checked',false);
        $(".lp-sticky-bar__wrapper").removeClass("lp-sticky-bar__full-page");
        setTimeout(function(){
            page_outerheight();
            owl.trigger('refresh.owl.carousel');
        },1000);
    }
    $("#dropzone-logo-space").bootstrapSlider('setValue', third_party_obj.logo_spacing,true);
    if ($('.select__logo-placement').val() == "top"){
        if(parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()) < 0 ){
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
        }else{
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()));
        }
        $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
        $(".cta__logo").css("left","");
        if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
            $(".cta__logo").css("bottom",+third_party_obj.logo_spacing+"px");
        }else{
            $(".cta__logo").css("bottom","-"+third_party_obj.logo_spacing+"px");
        }
    } else {
        if(parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()) < 0 ){
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
        }else{
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()));
        }
        $(".cta__logo").css("bottom","");
        $(".cta__logo").css("left","-"+third_party_obj.logo_spacing+"px");
        $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
        $('.leadpops-wrap').height(third_party_obj.sticky_size);
    }
    if(third_party_obj.logo_image_path != "" && third_party_obj.logo_image_replacement == "top" && third_party_obj.logo_image_path != STICKY_BAR_IMAGES_PATH && third_party_obj.logo_image_path != "/"+STICKY_BAR_IMAGES_PATH){
        $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
    }else{
        $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
    }
    $("#dropzone-logo-size").bootstrapSlider('setValue', third_party_obj.logo_image_size,true);
    // background image change
    $(".dropzone__background-image").remove();
    background_dropzone_init(third_party_obj);
    if(third_party_obj.background_image_path != null && third_party_obj.background_image_path != "" && third_party_obj.background_image_path != "none"){
        $('.leadpops-wrap').css("background-image", "url("+third_party_obj.background_image_path+")");
        $('.leadpops-wrap').addClass("has_background_image");
        setting.temp_background_path = third_party_obj.background_image_path;
    }else {
        setting.background_image  = "none";
        $('.leadpops-wrap').css("background-image", setting.background_image);
        $('.leadpops-wrap').removeClass("has_background_image");
    }
    $('.cta_background_color-overlay').val(third_party_obj.background_image_color_overlay);
    $(".background-sticky-bar-box-overlay").css("background-color","#"+third_party_obj.background_image_color_overlay);

    $(".dropzone-color-opacity__wrapper .slider .slider-handle").css("left",''+third_party_obj.background_image_opacity*100 +"%");
    $(".dropzone-color-opacity__wrapper .slider .slider-track .slider-selection").css("width",''+third_party_obj.background_image_opacity*100+"%");
    $('#dropzone-color-opacity').val(third_party_obj.background_image_opacity);
    $(".color-overlay").css("opacity",third_party_obj.background_image_opacity);
    $(".dropzone-image-size_wrapper .slider .slider-handle").css("left",''+third_party_obj.background_image_size+"%");
    $(".leadpops-wrap").css("background-size",third_party_obj.background_image_size+"%");
    $(".dropzone-image-size_wrapper .slider .slider-track .slider-selection").css("width",''+third_party_obj.background_image_size+"%");
    $('#dropzone-image-size').val(third_party_obj.background_image_size);

    // cta btn link

    if(third_party_obj.stickybar_number_flag == 1 && third_party_obj.stickybar_btn_flag == 1){
        $('#call_text_check').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
    }else if (third_party_obj.stickybar_btn_flag == 'f'){
        $('#funnel_check').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
    } else if(third_party_obj.stickybar_btn_flag == 'b'){
        $('#no_button').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.ctalink').hide();
        $('.ctalink').addClass("hide");
        $(".no-button").css("padding-bottom","0");
    }else if(third_party_obj.stickybar_btn_flag == 'c'){
        $('#close_sticky').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $(".no-button").css("padding-bottom","0");
    }else{
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
        $('#url_check').prop('checked',true);
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
    }
    if (third_party_obj.stickybar_cta_btn_other_url != ""){
        $("#outside_url").val(third_party_obj.stickybar_cta_btn_other_url);
    }
    if(third_party_obj.v_sticky_button != null ){
        setting.sticky_button = third_party_obj.v_sticky_button;
    }
    // sticky bar stlye
    $('.leadpops-wrap').css('backgroundColor', '#'+third_party_obj.cta_background_color);
    setTimeout(function () {
        $('.cta .fr-element.fr-view > p').css({'color': '#'+third_party_obj.cta_color,"font-weight":"300"});
        $('#linkanimation .lp_froala__sticky-bar-button .fr-element.fr-view > p*').css({"color": '#'+third_party_obj.cta_btn_color,'font-weight':'300','font-size':'26px'});
        $('#linkanimation').css('background', '#'+third_party_obj.cta_btn_background_color);
    },400);

    // box values
    $('.background-sticky-bar-box').css('background', '#'+third_party_obj.cta_background_color);
    $('.text-sticky-bar-box').css('background', '#'+third_party_obj.cta_color);
    $('.btn-text-sticky-bar-box').css('background', '#'+third_party_obj.cta_btn_color);
    $('.btn-background-sticky-bar-box').css('background', '#'+third_party_obj.cta_btn_background_color);
    // hidden input value
    $(".cta_btn_background_color").val(third_party_obj.cta_btn_background_color);
    $(".cta_btn_color").val(third_party_obj.cta_btn_color);
    $(".cta_color").val(third_party_obj.cta_color);
    $(".cta_background_color").val(third_party_obj.cta_background_color);
    // span text
    $(".cta_btn_background_color_code").text(third_party_obj.cta_btn_background_color);
    $(".cta_btn_background_color .color-box__hex-block").val('#'+third_party_obj.cta_btn_background_color);
    $(".cta_btn_color_code").text(third_party_obj.cta_btn_color);
    $(".cta_btn_color .color-box__hex-block").val('#'+third_party_obj.cta_btn_color);
    $(".cta_text-color_code").text(third_party_obj.cta_color);
    $(".cta-text-Color .color-box__hex-block").val('#'+third_party_obj.cta_color)
    $(".cta_background_color_code").text(third_party_obj.cta_background_color);
    $(".cta_background_color .color-box__hex-block").val('#'+third_party_obj.cta_background_color);
    $(".cta_background_color-overlay .color-box__hex-block").val('#'+third_party_obj.background_image_color_overlay);

    $("#linkanimation").css("padding", third_party_obj.cta_btn_vertical_padding+"  "+third_party_obj.cta_btn_horizontal_padding+"");
    var vertical =  third_party_obj.cta_btn_vertical_padding;
    vertical = vertical.replace("px", "");
    var horizontal =  third_party_obj.cta_btn_horizontal_padding;
    horizontal = horizontal.replace("px", "");
    $('#cta_height').val(vertical);
    $('#cta_width').val(horizontal);

    // button background color
    $(".cta_btn_background_color .color-box__r .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_background_color).r);
    $(".cta_btn_background_color .color-box__g .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_background_color).g);
    $(".cta_btn_background_color .color-box__b .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_background_color).b);
    // button color
    $(".cta_btn_color .color-box__r .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_color).r);
    $(".cta_btn_color .color-box__g .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_color).g);
    $(".cta_btn_color .color-box__b .color-box__rgb").val(hexToRgb(third_party_obj.cta_btn_color).b);
    //Text color
    $(".cta-text-Color .color-box__r .color-box__rgb").val(hexToRgb(third_party_obj.cta_color).r);
    $(".cta-text-Color .color-box__g .color-box__rgb").val(hexToRgb(third_party_obj.cta_color).g);
    $(".cta-text-Color .color-box__b .color-box__rgb").val(hexToRgb(third_party_obj.cta_color).b);
    //background color
    $(".cta_background_color .color-box__r .color-box__rgb").val(hexToRgb(third_party_obj.cta_background_color).r);
    $(".cta_background_color .color-box__g .color-box__rgb").val(hexToRgb(third_party_obj.cta_background_color).g);
    $(".cta_background_color .color-box__b .color-box__rgb").val(hexToRgb(third_party_obj.cta_background_color).b);
    // color overlay
    $(".cta_background_color-overlay .color-box__r .color-box__rgb").val(hexToRgb(third_party_obj.background_image_color_overlay).r);
    $(".cta_background_color-overlay .color-box__g .color-box__rgb").val(hexToRgb(third_party_obj.background_image_color_overlay).g);
    $(".cta_background_color-overlay .color-box__b .color-box__rgb").val(hexToRgb(third_party_obj.background_image_color_overlay).b);

    $("#sticky-bar__how-big").bootstrapSlider('setValue', third_party_obj.sticky_size,true);
    $('.leadpops-wrap').css("height",parseInt(third_party_obj.sticky_size));

    if(third_party_obj.cta_box_shadow != "none" && third_party_obj.cta_box_shadow != "" ){
        $("#sticky-bar__shadow").bootstrapSlider("setValue",third_party_obj.cta_box_shadow,true);
        $(".leadpops-wrap").css("box-shadow","0 0  "+third_party_obj.cta_box_shadow+"px #444");

    }else{
        $("#sticky-bar__shadow").bootstrapSlider("setValue",10);
        $(".leadpops-wrap").css("box-shadow","0 0  10px #444");
    }

    setting.hide_animation = third_party_obj.hide_animation;
    if(third_party_obj.hide_animation == 1){
        $('#lp-sticky-bar__hide-checker').prop('checked',true);
        $(".lp-sticky-bar__when-hide-wrapper").slideDown();
        $('.sticky-hide').show();
    }else {
        $('.sticky-hide').hide();
    }

    $('.lp-sticky-bar__when-hide-select').val(third_party_obj.when_to_hide);
    $('.lp-sticky-bar__when-hide-select').trigger('change');
    $('.select__want-display').val(third_party_obj.when_to_display);
    $('.select__want-display').trigger('change');

    if(third_party_obj.sticky_location == null || third_party_obj.sticky_location == 't' || third_party_obj.advance_sticky_location == 'stick-at-top' || third_party_obj.advance_sticky_location == 'top-disappear-on-scroll'){
        $("#pin_flag_top").prop('checked' , true);
        $('.leadpops-wrap').removeClass('sticky-position-bottom');
        $('.select__want-placed').val(third_party_obj.advance_sticky_location);
        $('.select__want-placed').trigger('change');
    }else {
        $('.select__want-placed').val(third_party_obj.advance_sticky_location);
        $('.select__want-placed').trigger('change');
        $("#pin_flag_bottom").prop('checked' , true);
        $('.leadpops-wrap').addClass('sticky-position-bottom');
    }

    setting.advance_sticky_location = third_party_obj.advance_sticky_location;
    $('.select__want-animation').val(third_party_obj.cta_btn_animation);
    $('.select__want-animation').trigger('change');
    if(third_party_obj.cta_btn_animation == "Radioactive") {
        var cta_button = $("#linkanimation");
        $(cta_button).addClass("radio-active_animation");
        var bg_btn_clr = "#"+third_party_obj.cta_btn_background_color;
        $(".radio__active-animation").remove();
        $('head').append('<style class="radio__active-animation" type="text/css">#linkanimation.radio-active_animation:before , #linkanimation.radio-active_animation:after {background-color:'+bg_btn_clr +'}</style>');
    }else {
        $("#linkanimation").removeClass("radio-active_animation");
        $(".radio__active-animation").remove();
    }
    // color picker start
    $('.cta_background_color-init').ColorPicker({
        color: "#"+third_party_obj.cta_background_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_background_color_code").text(hex);
            $(".cta_background_color").val(hex);
            $('.leadpops-wrap , .background-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    // sticky bar text color
    $('.cta_color-init').ColorPicker({
        color: "#"+third_party_obj.cta_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta-text-Color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta-text-Color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta-text-Color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta-text-Color .color-box__hex-block").val('#'+hex);
            $(".cta_text-color_code").text(hex);
            $(".cta_color").val(hex);
            $('.cta .lp_froala__sticky-bar-text .fr-element.fr-view > p*').css('color', '#' + hex);
            $(".lp_froala__sticky-bar-text p span*").css('color', '#' +hex);
            $('.text-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    // sticky bar button background color
    $('.cta_btn_background_color-init').ColorPicker({
        color: "#"+third_party_obj.cta_btn_background_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_btn_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_btn_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_btn_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_btn_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_btn_background_color_code").text(hex);
            $(".cta_btn_background_color").val(hex);
            // $('#linkanimation .lp_froala__sticky-bar-button .fr-element.fr-view > p*').css('backgroundColor', '#' + hex);
            // $(".lp_froala__sticky-bar-button p span*").css('backgroundColor', '#' +hex);
            $('.btn-background-sticky-bar-box , #linkanimation').css('backgroundColor', '#' + hex);
            $(".radio__active-animation").remove();
            $('head').append('<style class="radio__active-animation" type="text/css">@-webkit-keyframes activePulse {0% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.4);}10% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.5);}20% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.6);}30% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.7);}40% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.8);}50% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.9);}60% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.8);}70% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.7);}80% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.6);}90% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.5);}100% {background: rgba('+rgb.r+','+rgb.g+','+rgb.b+',0.4);}}</style>');
            var cta_button = $("#linkanimation");
            var animation_type = $('.select__want-animation').val();
            if(animation_type == "Radioactive"){
                $(cta_button).addClass("radio-active_animation");
                var bg_btn_clr = $("#linkanimation").css("background-color");
                $(".radio__active-animation").remove();
                $('head').append('<style class="radio__active-animation" type="text/css">#linkanimation.radio-active_animation:before , #linkanimation.radio-active_animation:after {background-color:'+bg_btn_clr +'}</style>');
            } else {
                $(cta_button).removeClass("radio-active_animation");
                $(".radio__active-animation").remove();
            }
        }
    });
    // sticky bar button text color
    $('.cta_btn_color-init').ColorPicker({
        color: "#"+third_party_obj.cta_btn_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $('#cta_btn_color').addClass('open');
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $('#cta_btn_color').removeClass('open');
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_btn_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_btn_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_btn_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_btn_color .color-box__hex-block").val('#'+hex);
            $(".cta_btn_color_code").text(hex);
            $(".cta_btn_color").val(hex);
            $('#linkanimation .lp_froala__sticky-bar-button .fr-element.fr-view > p*').css('color', '#' + hex);
            $(".lp_froala__sticky-bar-button p span*").css('color', '#' +hex);
            $('.btn-text-sticky-bar-box').css('backgroundColor', '#' + hex);
            $('#linkanimation').css('color', '#' + hex);
        }
    });
    if(third_party_obj.background_image_color_overlay == "None"){
        $(".sticky-bar-code-overlay").text("None");
        $("#cta_background_color-overlay").addClass("color-box__none");
        var overlay = third_party_obj.background_image_color_overlay;
    }else{
        $("#cta_background_color-overlay").removeClass("color-box__none");
        $(".sticky-bar-code-overlay").text('# '+third_party_obj.background_image_color_overlay);
        var overlay = "#"+third_party_obj.background_image_color_overlay+""
    }

    //sticky bar color overlay
    $('.cta_background_color-overlay-init').ColorPicker({

        color: overlay,
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $('#cta_btn_color').addClass('open');
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $('#cta_btn_color').removeClass('open');
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $("#cta_background_color-overlay").removeClass("color-box__none");
            $(".cta_background_color-overlay .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color-overlay .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color-overlay .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color-overlay .color-box__hex-block").val('#'+hex);
            $(".sticky-bar-code-overlay").text('# '+hex);
            $(".cta_background_color-overlay").val(hex);
            $('.background-sticky-bar-box-overlay,.color-overlay').css('backgroundColor', '#' + hex);
            //    background color change
            $(".cta_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_background_color_code").text(hex);
            $(".cta_background_color").val(hex);
            $('.leadpops-wrap , .background-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    //color picker end
    //step 4 start

    /*if(third_party_obj.sticky_url != null){
        setting.sticky_url = third_party_obj.sticky_url;
    }*/
    var cta_title_phone_number = third_party_obj.stickybar_number;
    $('#cta_title_phone_number').val(cta_title_phone_number);
    var phone_number_checked = third_party_obj.stickybar_number_flag;
    if(phone_number_checked == "1"){
        $('#call_text_check').prop('checked',true);
        $("#cta_title_phone_number").inputmask({"mask": "(999) 999-9999"});
        $('.lp-sticky-bar__form-group_phone-number').slideDown();
        // $('.lp-sticky-bar__form-group_phone-number').addClass('lp-sticky-bar__form-group_phone-number_show');
    }else {
        $('#call_text_check').prop('checked',false);
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        // $('.lp-sticky-bar__form-group_phone-number').removeClass('lp-sticky-bar__form-group_phone-number_show');
    }
    if(c_data_obj.third_party_website_flag != 1 ){
        var pending = c_data_obj.pending_flag;
        if(c_data_obj.sticky_status != 0 && ($(".zindex-adding-stickybar").val() == 0)){
            $('#toggle-status').bootstrapToggle('on');
            setting.update_form = false;
            if(pending != 0){
                if(c_data_obj.full_page_sticky_bar_flag == "on"){
                    $(".fullpage__status").show();
                    $(".defaultpage__status").hide();
                }else {
                    $(".defaultpage__status").show();
                    $(".fullpage__status").hide();
                }
                $(".lp-sticky-bar__note").text('(Installed Successfully)');
            }else{
                if(c_data_obj.full_page_sticky_bar_flag == "on"){
                    $(".fullpage__status").show();
                    $(".defaultpage__status").hide();
                }else {
                    $(".fullpage__status").hide();
                    $(".defaultpage__status").show();
                }
                $(".lp-sticky-bar__note").text('(Pending Installation)');
            }
        }else if ($(".zindex-adding-stickybar").val() == 2){
            $(".fullpage__status").hide();
            $(".defaultpage__status").hide();
        }else{
            // hide
            if(pending != 0 && ($(".zindex-adding-stickybar").val() == 0)){
                if(c_data_obj.full_page_sticky_bar_flag == "on"){
                    $(".fullpage__status").show();
                }else{
                    $(".defaultpage__status").show();
                }
                $(".lp-sticky-bar__note").text('(Pending Installation)');
            }else{
                $(".defaultpage__status").hide();
                $(".fullpage__status").hide();
            }
        }
    }else{
        $(".fullpage__status").hide();
        $(".defaultpage__status").hide();
    }
    $("#stickybar__pixel_code").val(third_party_obj.sticky_bar_pixel);
    $('#toggle-status').bootstrapToggle('off');
    if(c_data_obj.third_party_website != "" && c_data_obj.third_party_website!= null){
        setting.number_of_share_links = c_data_obj.third_party_website[c_data_obj.sticky_id].length;
    }
    setting.full_page_sticky_bar_flag = third_party_obj.full_page_sticky_bar_flag;
    setting.logo_image_added_flag=setting.logo_image_removed_flag=setting.background_image_added_flag=setting.background_image_removed_flag=0;
}

/*get froala html*/

function get_fraola_html(selector)
{
    setting.update_form = true;
    var html = ""
    var number_of_paragraph = $(selector).find("p").length;
    for(var i=1 ; number_of_paragraph >= i ; i++){
        var paragraph_stlye = $(selector).find('p:nth-child('+i+')').attr('style');
        var paragraph_html = $(selector).find('p:nth-child('+i+')').html();
        html = html+'<p style="'+paragraph_stlye+'">'+paragraph_html+'</p>';
    }
    return html;
}

/*hex to RBG*/

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

/*update current data obj with current values*/

function current_data_obj() {
    if(setting.update_form== true){
        c_data_obj = getActiveElementObj();
        c_data_obj._token = ajax_token;
        c_data_obj.insert_flag = $('[name=insert_flag]').val();
        c_data_obj.sticky_cta = "I am your sticky bar and i am being awesome!";
        c_data_obj.sticky_button = "Lets do it!";
        // c_data_obj.show_cta = $('[name=cta_icon]').val();
        c_data_obj.show_cta = 0;
        c_data_obj.clients_leadpops_id = setting.data_id;
        if($('.leadpops-wrap').height()< 139 ){
            c_data_obj.sticky_size = $('.leadpops-wrap').height();
        }else{
            c_data_obj.sticky_size = $('#sticky-bar__how-big').val();
        }
        c_data_obj.cta_btn_horizontal_padding = $("#linkanimation").css("padding-left");
        c_data_obj.cta_btn_vertical_padding = $("#linkanimation").css("padding-top");
        c_data_obj.sticky_status = $('[name=sticky_status]').val();
        c_data_obj.pending_flag = $('[name=pending_flag]').val();
        c_data_obj.sticky_location = "t";
        c_data_obj.zindex = $('[name=zindex]').val();
        c_data_obj.zindex_type = $('[name=zindex_type]:checked').val();
        c_data_obj.sticky_website_flag = $('[name=pages_flag]:checked').val();
        c_data_obj.sticky_funnel_url = $('[name=sticky_bar_url]').val();
        c_data_obj.script_type = $('#sticky_script_type').val();
        c_data_obj.sticky_url = $('#cta_url').val();
        if($(".lp-sticky-bar__wrapper").hasClass("cta__logo-above") == true){
            var logo_Spacing =   $(".cta__logo").css("bottom");
            logo_Spacing =  parseInt(logo_Spacing);
            if(logo_Spacing < 0){
                logo_Spacing = - logo_Spacing
            }
            c_data_obj.logo_spacing = logo_Spacing;
        }else{
            var logo_Spacing =   $(".cta__logo").css("left");
            logo_Spacing =  parseInt(logo_Spacing);
            if(logo_Spacing < 0){
                logo_Spacing = - logo_Spacing
            }
            c_data_obj.logo_spacing = logo_Spacing;
        }
        c_data_obj.edit_url_hash = setting.third_party_url_edit_hash;
        c_data_obj.third_party_url_edit = setting.third_party_url_edit;
        c_data_obj.stickybar_number = $('[name=cta_title_phone_number]').val();
        c_data_obj.stickybar_number_flag = $('#call_text_check:checked').val();
        c_data_obj.stickybar_btn_flag = $('[name=where_button_goes]:checked').val();
        if($('[name=lp-sticky-bar__full-page-checker]:checked').val() === undefined){
            c_data_obj.full_page_sticky_bar_flag = "off";
        }else{
            c_data_obj.full_page_sticky_bar_flag = $('[name=lp-sticky-bar__full-page-checker]:checked').val();
        }
        c_data_obj.hide_animation = setting.hide_animation;
        if(c_data_obj.stickybar_number_flag === undefined){
            c_data_obj.stickybar_number_flag = 0;
        }
        c_data_obj.third_party_website_flag = $(".zindex-adding-stickybar").val();
        c_data_obj.cta_btn_background_color = $(".cta_btn_background_color").val();
        c_data_obj.cta_btn_color = $(".cta_btn_color").val();
        c_data_obj.cta_color = $(".cta_color").val();
        c_data_obj.cta_background_color = $(".cta_background_color").val();
        c_data_obj.cta_btn_animation = setting.cta_btn_animation;
        c_data_obj.advance_sticky_location = setting.advance_sticky_location;
        c_data_obj.when_to_display = setting.when_to_display;
        c_data_obj.cta_box_shadow = setting.cta_box_shadow;
        c_data_obj.when_to_hide = setting.when_to_hide;
        c_data_obj.sticky_bar_pixel = $("#stickybar__pixel_code").val();
        c_data_obj.cta_text_html = get_fraola_html('.lp_froala__sticky-bar-text .fr-wrapper');
        c_data_obj.cta_btn_text_html = get_fraola_html('.lp_froala__sticky-bar-button .fr-wrapper');
        if($("#another_cta_url").val() != "" || $("#new_cta_url").val() != "" ){
            c_data_obj.another_cta_url = 1;
        }else{
            c_data_obj.another_cta_url = "";
        }
        if(setting.background_image_added_flag == 1 && setting.background_image_removed_flag == 1){
            c_data_obj.background_image_base_code = setting.background_image_base_code;
        }else if (setting.background_image_added_flag == 1){
            c_data_obj.background_image_base_code = setting.background_image_base_code;
        }
        if(setting.logo_image_added_flag == 1 && setting.logo_image_removed_flag == 1){
            c_data_obj.logo_image_base_code = setting.logo_image_base_code;
        }else if (setting.logo_image_added_flag == 1){
            c_data_obj.logo_image_base_code = setting.logo_image_base_code;
        }
        if(setting.thrid_party_website_share_url ==  $('#cta_url').val() && setting.third_party_website_flag == 1){
            c_data_obj.url_flag = "false";
            c_data_obj.third_party_url = $(".thrid_party_website_share_url").val()+"~"+$("#cta_url").val() ;

        }else {
            c_data_obj.third_party_url = setting.last_thrid_party_website_share_url ;
        }
        c_data_obj.cta_btn_text_font_family = setting.cta_btn_text_font_family;
        c_data_obj.cta_text_font_family = setting.cta_text_font_family;
        c_data_obj.stickybar_cta_btn_other_url = $("#outside_url").val();
        c_data_obj.background_image_added_flag = setting.background_image_added_flag;
        c_data_obj.logo_image_added_flag = setting.logo_image_added_flag;
        c_data_obj.background_image_removed_flag = setting.background_image_removed_flag;
        c_data_obj.logo_image_removed_flag = setting.logo_image_removed_flag;
        if($(".sticky-bar-code-overlay").text()== "None"){
            c_data_obj.background_image_color_overlay = "None";
        }else{
            c_data_obj.background_image_color_overlay = $(".cta_background_color-overlay").val();

        }
        c_data_obj.logo_image_replacement = $(".select__logo-placement").val();
        c_data_obj.background_image_opacity = $("#dropzone-color-opacity").val();
        c_data_obj.logo_image_size = $("#dropzone-logo-size").val();
        c_data_obj.background_image_size = $("#dropzone-image-size").val();
        c_data_obj.logo_image_height = $(".cta__logo").height();
        c_data_obj.logo_image_width = $(".cta__logo").width();
        if(setting.logo_image == "" && setting.logo_image == null && setting.change_flag == 1){
            c_data_obj.logo_image_path = "";
        }else {
            if($(".cta__logo").attr("src") != ""){
                var path = $(".cta__logo").attr("src");
                c_data_obj.logo_image_path =  path;
            }else if(setting.logo_image_removed_flag != 1){
                c_data_obj.logo_image_path = "";
            }
        }
        if(setting.background_image == "" && setting.background_image == null){
            c_data_obj.background_image_path = "";
        }else{
            if($('.leadpops-wrap').css('background-image') != 'none' && $('.leadpops-wrap').css('background-image') != ""){
                var bg_url =$('.leadpops-wrap').css('background-image');
                bg_url = /^url\((['"]?)(.*)\1\)$/.exec(bg_url);
                bg_url = bg_url ? bg_url[2] : "";
                c_data_obj.background_image_path=  bg_url;
            }else{
                c_data_obj.background_image_path = "";
            }
        }
    }
}

function set_defeult_steps(){
    $("#another-url-sticky-bar").removeClass('hide-another');
    $(".third-party__another-modal").removeClass('show-another');
    $(".third-party__step").removeClass('hide-another');
    $(".step-1--normal").removeClass('hide-another');
    $(".step-1--normal").addClass('show-another');
    $(".step-1--third-party").removeClass('show-another');
    $(".step-1--third-party").addClass('hide-another');
    $("#new_cta_url").val('');
    var input_condtion = $("input.thrid_party_website_share_url");
    $(".lp-sticky-bar__edit-url").show();
    $(".lp-sticky-bar__copy-url").show();
    $(".lp-sticky-bar__edit-url-option").css('display','none');
    $(input_condtion).prop( "disabled", true );
    $('#prev-sticky-bar').show();
}

function set_obj_after_ajax() {
    c_data_obj.sticky_bar_v2 = true;
    setting.logo_image_added_flag = 0;
    setting.logo_image_removed_flag = 0;
    setting.logo_image_added_flag = 0;
    setting.background_image_added_flag = 0;
    setting.background_image_removed_flag = 0;
    setting.third_party_url_edit_hash = "";
    setting.third_party_url_edit = "";
    setting.logo_image_path =  "";
    setting.background_image_path =  "" ;
    setting.update_form = false;
    c_data_obj.url_flag = "";
    c_data_obj.another_cta_url ="";
    setting.third_party_index = "";
}

function data_rander_after_ajax(){
    if(c_data_obj.logo_image_base_code != "" && c_data_obj.logo_image_base_code != null){
        c_data_obj.logo_image_base_code = "";
    }
    if(c_data_obj.background_image_base_code != "" && c_data_obj.background_image_base_code != null){
        c_data_obj.background_image_base_code  = "";
    }
    if(c_data_obj.third_party_website_flag == 1){
        if(setting.number_of_share_links ==  c_data_obj.third_party_website[c_data_obj.sticky_id].length){
            // update
            if(setting.third_party_index != "" && setting.third_party_index != null  ){
                third_party_sticky_popup(JSON.parse(c_data_obj.third_party_website[c_data_obj.sticky_id][setting.third_party_index].sticky_bar_style));
            }else{
                third_party_sticky_popup(JSON.parse(c_data_obj.third_party_website[c_data_obj.sticky_id][0].sticky_bar_style));
            }
        }else{
            // insert first index
            third_party_sticky_popup(JSON.parse(c_data_obj.third_party_website[c_data_obj.sticky_id][0].sticky_bar_style));

        }
    }
}

/* is website support Iframe  option*/

function is_website_support_iframe($url) {
    $('.lp-sticky-bar__loader').show();
    $.ajax({
        type: "POST",
        url: "/lp/popadmin/is_iframe_support",
        data: {'domain': $url ,'_token':ajax_token},
        success: function (data) {
            var obj = $.parseJSON(data);
            if (obj.status == 'error') {
                $('.alert').remove();
                var message = 'URL you are adding is not support such functionality.';
                var html = '<div class="alert alert-danger lp-sticky-bar__alert">\n' +
                    '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                    '  <strong> Error! </strong>' + obj.message +
                    '</div>';
                $("#cta_url").addClass("error");
                $('.lp-sticky-bar__loader').hide();
                $(html).hide().appendTo(".msg").slideDown(500).delay(50000).slideUp(500, function () {
                    $(this).remove();
                });
                has_error= 1;
                setting.update_form = false;
                return false;
            }else{
                $('.lp-sticky-bar__loader').hide();
            }
        },
        cache: false,
        async: false
    });
}

/* show sticky POPUP */

function showstickybarpopup(_this) {
    $("body").addClass("sticky-bar__v2");
    funnel_index = funnel_data.map(function (ele) { return ele.clients_leadpops_id; }).indexOf(parseInt(_this.attr("data-id")));
    c_data_obj = funnel_data[funnel_index];
    setting.sticky_bar_update_flag=0;
    $("input.thrid_party_website_share_url").prop('disabled',true);
    if(c_data_obj.new_client == false){
        setting.cta_btn_text_html = c_data_obj.cta_btn_text_html;
        setting.cta_text_html = c_data_obj.cta_text_html;
    }
    $('body').append('<div id="clickable_tooltip" class="clickable_tooltip">Learn more about <a style="text-decoration: underline; display: inline-block" href="https://clix.ly" target="_blank">Clixly</a>.</div>');
    //Function to convert hex format to a rgb color
    // fraola
    $(function() {
        /*
        *  Phone number option is froala editor-+
        * */
        $.FroalaEditor.DefineIcon('phone', {NAME: 'phone'});
        $.FroalaEditor.RegisterCommand('phone', {
            title: 'Phone Number',
            focus: true,
            undo: true,
            refreshAfterCallback: true,
            callback: function () {
                window.current  = this;
                window.get_phone_label = this.selection.text();
                window.frtext = this.selection.text();
                this.phonePlugin.showPopup();
                $("#fr-link-insert-layer-url-phone").val("");
                $("#fr-link-insert-layer-text").val("");
                $("#fr-link-insert-layer-text").val(window.get_phone_label);
                $("#fr-link-insert-layer-url-phone").inputmask({"mask": "(999) 999-9999"});
                $(".fr-submit__number").click(function () {
                    if($("#fr-link-insert-layer-url-phone").val() != ""){
                        var phonenumber = $("#fr-link-insert-layer-url-phone").val();
                        phonenumber = phonenumber.replace(/\_/g, '');
                        // console.info(phonenumber.length );
                        if(phonenumber.length == 14){
                            $("#fr-link-insert-layer-phone").removeClass("fr-error");
                            var lbl_val = $("#fr-link-insert-layer-text").val();
                            var get_phone_number = $("#fr-link-insert-layer-url-phone").val();
                            get_phone_number = get_phone_number.replace(/\_/g, '');
                            var cta_html = $(".cta .lp_froala__sticky-bar-text .fr-wrapper .fr-view p").html();
                            var cta_style = $(".cta .lp_froala__sticky-bar-text .fr-wrapper .fr-view p").attr("style");
                            var new_cta_html =  cta_html.replace(window.frtext,'<a class="sb-phone-number" href="tel:'+get_phone_number+'">'+lbl_val+'</a>');
                            $('.lp_froala__sticky-bar-text p').html(new_cta_html);
                            $('.lp_froala__sticky-bar-text a').filter(function(){return $(this).text().trim().length==0}).remove();
                            window.current.phonePlugin.hidePopup();
                        }else{
                            $("#fr-link-insert-layer-phone").addClass("fr-error");
                        }
                    }
                });
            },
            plugin: 'phonePlugin'

        });
        $.FroalaEditor.DefineIcon('phoneEdit', {NAME: 'phone'});
        $.FroalaEditor.RegisterCommand('phoneEdit', {
            title: 'Edit Phone Number',
            focus: true,
            undo: true,
            spellcheck: false,
            refreshAfterCallback: true,
            callback: function () {
                window.current = this;
                var text =  $('.lp_froala__sticky-bar-text').froalaEditor('link.get', true);
                this.editphonePlugin.showPopup();
                $("#fr-link-edit-layer-url-phone").inputmask({"mask": "(999) 999-9999"});
                var edit_phone_number =  text.attributes.href.value;
                edit_phone_number = decodeURIComponent(edit_phone_number);
                $('#fr-link-edit-layer-url-phone').val(edit_phone_number);
                $('#fr-link-edit-layer-text').val(text.innerText);

                $(".fr-update__number").click(function () {
                    if($("#fr-link-edit-layer-url-phone").val() != ""){
                        var phonenumber = $("#fr-link-edit-layer-url-phone").val();
                        phonenumber = phonenumber.replace(/\_/g, '');
                        if(phonenumber.length == 14){
                            /*
                            *  success case
                            * */
                            var lbl_val = $("#fr-link-edit-layer-text").val();
                            var get_phone_number = $("#fr-link-edit-layer-url-phone").val();
                            get_phone_number = get_phone_number.replace(/\_/g, '');
                            var cta_html = $(".cta .lp_froala__sticky-bar-text .fr-wrapper .fr-view p").html();
                            var cta_style = $(".cta .lp_froala__sticky-bar-text .fr-wrapper .fr-view p").attr("style");
                            var new_cta_html =  cta_html.replace(text.innerText,'<a class="sb-phone-number" href="tel:'+get_phone_number+'">'+lbl_val+'</a>');
                            $('.lp_froala__sticky-bar-text p').html(new_cta_html);
                            $('.lp_froala__sticky-bar-text a').filter(function(){return $(this).text().trim().length==0}).remove();
                            window.current.editphonePlugin.hidePopup();
                        }else{
                            /*
                            * error case
                            * */

                        }
                    }
                });
            },
            plugin: 'editphonePlugin'

        });
        var stickybar_text =$('.lp_froala__sticky-bar-text').froalaEditor({
            key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
            toolbarVisibleWithoutSelection: true,
            fontSizeDefaultSelection: '30',
            quickInsertEnabled: false,
            spellcheck: false,
            linkEditButtons: ['bold', 'lineHeight','italic', 'underline', 'strikeThrough','fontFamily',
                'fontSize','color', 'fontAwesome', 'align', 'phoneEdit','-','emoticons',
                'insertLink', 'undo', 'redo','clearFormatting','linkOpen', 'linkStyle','linkEdit' ,'linkRemove'],
            zIndex: 99999999,
            colorsHEXInput: true,
            toolbarInline: true,
            charCounterCount: true,
            fontSize:['1','2','3','4','5','6','7','6','7','8','9','10',
                '11','12','13','14','15','16','17','18','19','20',
                '21','22','23','24','25','26','27','28','29','30',
                '31','32','33','34','35','36','37','38','39','40',
                '41','42','43','44','45','46','47','48','49','50',
                '51','52','53','54','55','56','57','58','59','60',
                '61','62','63','64','65','66','67','68','69','70','71','72'],
            toolbarButtons: ['bold', 'lineHeight', 'italic', 'underline', 'strikeThrough','fontFamily',
                'fontSize','color', 'fontAwesome', 'align','formatUL', 'phone','-','emoticons',
                'insertLink', 'undo', 'redo','clearFormatting'],
            fontFamily: font_object
        });
        $(stickybar_text).on('froalaEditor.commands.after', function (e, editor, textColor) {
            setting.update_form = true;
            if($(".lp_froala__sticky-bar-text p span").first().css("color") !== undefined){
                var froala_elem_color = rgb2hex( $(".lp_froala__sticky-bar-text p span").first().css("color") );
                $(".cta_text-color_code").text(froala_elem_color);
                $('.text-sticky-bar-box').css('background', '#'+froala_elem_color);
            }
            setting.cta_text_html =  get_fraola_html('.lp_froala__sticky-bar-text .fr-wrapper');
        });
        $(stickybar_text).on('froalaEditor.click', function (e, editor, clickEvent) {
            setting.cta_text_html =  get_fraola_html('.lp_froala__sticky-bar-text .fr-wrapper');
        });
        $(stickybar_text).on('froalaEditor.mouseup', function (e, editor, clickEvent) {
        },function(){
            setTimeout(function () {
                if($(".sticky-bar__v2 .fr-toolbar").eq(0).hasClass('fr-above')){
                    var  cta_top = parseInt($(".lp_froala__sticky-bar-text").offset().top);
                    cta_top = cta_top + 40;
                    $(".sticky-bar__v2 .fr-toolbar").eq(0).removeClass('fr-above');
                    $(".sticky-bar__v2 .fr-toolbar").eq(0).css("top", cta_top);
                }
            },50);
        });
        $(stickybar_text).on('froalaEditor.keyup', function (e, editor, keyupEvent) {
            setting.cta_text_html =  get_fraola_html('.lp_froala__sticky-bar-text .fr-wrapper');
        });
        $(stickybar_text).on('froalaEditor.contentChanged', function (e, editor, contentChangedEvent) {
            var number_of_span =  $(".lp_froala__sticky-bar-text .fr-element p span").length;
            var obj = {};
            obj[$(".lp_froala__sticky-bar-text .fr-element p").css("font-family")] = $(".lp_froala__sticky-bar-text .fr-element p").css("font-family");
            for(var a = 1; a <= number_of_span ; a++){
                if($(".lp_froala__sticky-bar-text .fr-element p span:nth-child("+a+")").css("font-family") !== undefined){
                    var font_family =  $(".lp_froala__sticky-bar-text .fr-element p span:nth-child("+a+")").css("font-family");
                    obj[font_family] = font_family;
                }
            }
            setting.cta_text_font_family = obj;
        });
        var stickybar_button = $('.lp_froala__sticky-bar-button').froalaEditor({
            key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
            toolbarVisibleWithoutSelection: true,
            fontSizeDefaultSelection: '20',
            quickInsertEnabled: false,
            zIndex: 99999999,
            toolbarInline: true,
            spellcheck: false,
            charCounterCount: true,
            fontSize:['1','2','3','4','5','6','7','6','7','8','9','10',
                '11','12','13','14','15','16','17','18','19','20',
                '21','22','23','24','25','26','27','28','29','30',
                '31','32','33','34','35','36','37','38','39','40',
                '41','42','43','44','45','46','47','48','49','50',
                '51','52','53','54','55','56','57','58','59','60',
                '61','62','63','64','65','66','67','68','69','70','71','72'],
            toolbarButtons: ['bold', 'lineHeight', 'italic', 'underline', 'strikeThrough','fontFamily',
                'fontSize','color','fontAwesome','align','formatUL','height','width','-', 'emoticons','undo', 'redo','clearFormatting'],
            fontFamily: font_object
        });
        $(stickybar_button).on('froalaEditor.commands.after', function (e, editor, backgroundColor) {
            setting.update_form = true;
            if( $(".lp_froala__sticky-bar-button p span").first().css("color") !== undefined){
                var froala_elem_color = rgb2hex( $(".lp_froala__sticky-bar-button p span").first().css("color") );
                $(".cta_btn_color_code").text(froala_elem_color);
                $('.btn-text-sticky-bar-box').css('background', '#'+froala_elem_color);

            }
            setting.cta_btn_text_html =  get_fraola_html('.lp_froala__sticky-bar-button .fr-wrapper');
        });
        $(stickybar_button).on('froalaEditor.click', function (e, editor, clickEvent) {
            setting.cta_btn_text_html =  get_fraola_html('.lp_froala__sticky-bar-button .fr-wrapper');
        });
        $(stickybar_button).on('froalaEditor.keyup', function (e, editor, keyupEvent) {
            setting.cta_btn_text_html =  get_fraola_html('.lp_froala__sticky-bar-button .fr-wrapper');
        });

        $(stickybar_button).on('froalaEditor.mouseup', function (e, editor, clickEvent) {
        },function(){
            setTimeout(function () {
                if($(".sticky-bar__v2 .fr-toolbar").eq(1).hasClass('fr-above')){
                    var  cta_top = parseInt($(".lp_froala__sticky-bar-text").offset().top);
                    cta_top = cta_top + 40;
                    $(".sticky-bar__v2 .fr-toolbar").eq(1).removeClass('fr-above');
                    $(".sticky-bar__v2 .fr-toolbar").eq(1).css("top", cta_top);
                }
            },50);
        });
        $(stickybar_button).on('froalaEditor.contentChanged', function (e, editor, contentChangedEvent) {
            var number_of_span =  $(".lp_froala__sticky-bar-button .fr-element p span").length;
            var obj = {};
            obj[$(".lp_froala__sticky-bar-button .fr-element p").css("font-family")] = $(".lp_froala__sticky-bar-button .fr-element p").css("font-family")
            for(var a = 1; a <= number_of_span ; a++){
                if($(".lp_froala__sticky-bar-button .fr-element p span:nth-child(3)").css("font-family") !== undefined){
                    var font_family = $(".lp_froala__sticky-bar-button .fr-element p span:nth-child("+a+")").css("font-family");
                    obj[font_family] = font_family;
                }
            }
            setting.cta_btn_text_font_family = obj;
        });
    });
    var funnel_name = c_data_obj.sticky_funnel_url;
    setting.third_party_website = c_data_obj.third_party_website;
    setting.third_party_website_flag = c_data_obj.third_party_website_flag;
    setting.data_id = c_data_obj.clients_leadpops_id;
    setting.token = '';

    if (c_data_obj.third_party_website_flag == 1){
        $(".zindex-adding-stickybar").val('1').trigger('change');
        $(".zindex-adding-stickybar").trigger('change');
        var last_inserted_third_party_webiste_data_index = 0;
        if (c_data_obj.third_party_website != ""){
            for (i=0; i<c_data_obj.third_party_website[c_data_obj.sticky_id].length ; i++){
                if (c_data_obj.third_party_website[c_data_obj.sticky_id][i].id >  c_data_obj.third_party_website[c_data_obj.sticky_id][last_inserted_third_party_webiste_data_index].id){
                    last_inserted_third_party_webiste_data_index = i ;
                }
            }
            if(c_data_obj.third_party_website == ""){
                $("#third-party__previoue-link").hide();
            }else{
                $("#third-party__previoue-link").show();
            }
            third_party_share_url_update();
            var urlcopy = $('.thrid_party_website_share_url').attr("data-domain-url");
            var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
            urlcopy = urlcopy+"~"+sticky_url;
            urlcopy = urlcopy.replace(/['"]/,"");
            $('.lp-sticky-bar__input-right-icon').attr("href",urlcopy);
            var last_inserted_third_party_webiste_data = c_data_obj.third_party_website[c_data_obj.sticky_id][last_inserted_third_party_webiste_data_index];
            var sticky_url = setting.thrid_party_website_share_url = last_inserted_third_party_webiste_data.sticky_url;
            $(".slug__url-text a").attr('href', STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+last_inserted_third_party_webiste_data.third_party_url);
            $(".slug__url-text a").text("clix.ly/"+last_inserted_third_party_webiste_data.hash);
            setting.last_thrid_party_website_share_url = last_inserted_third_party_webiste_data.third_party_url;
            $('.thrid_party_website_share_url').val(last_inserted_third_party_webiste_data.hash);
            setting.last_thrid_party_website_share_url_style = last_inserted_third_party_webiste_data.sticky_bar_style;
            $(".sticky_url__wrapper").slideDown();
        }
    }else if(c_data_obj.third_party_website_flag == 2){
        $(".zindex-adding-stickybar").val('2').trigger('change');
        $(".zindex-adding-stickybar").trigger('change');
        $(".sticky_url__wrapper").slideUp();
        $('.lp-sticky-bar__input-right-icon').attr("href","http://"+c_data_obj.domain_name);
        $(".funnel_domian").val(c_data_obj.domain_name);
    }else {
        setting.thrid_party_website_share_url = "";
        setting.last_thrid_party_website_share_url="";
        $('.thrid_party_website_share_url').val("");
        setting.last_thrid_party_website_share_url_style = "";
        $(".sticky_url__wrapper").slideDown();
        $(".zindex-adding-stickybar").val('0').trigger('change');
        $(".zindex-adding-stickybar").trigger('change');
        var sticky_url = c_data_obj.sticky_url;
    }
    if(c_data_obj.stickybar_number_flag == 1 && c_data_obj.stickybar_btn_flag == 1){
        $('#call_text_check').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideDown();
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
    }else if (c_data_obj.stickybar_btn_flag == 'f'){
        $('#funnel_check').prop('checked',true);
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
        $('.url_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.funnel_case-check').slideDown();
    }else if(c_data_obj.stickybar_btn_flag == 'b'){
        $('#no_button').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.ctalink').hide();
        $('.ctalink').addClass("hide");
        $(".no-button").css("padding-bottom","0");
    }else if(c_data_obj.stickybar_btn_flag == 'c'){
        $('#close_sticky').prop('checked',true);
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $(".no-button").css("padding-bottom","0");
    }else{
        $('.ctalink').show();
        $('.ctalink').removeClass("hide");
        $(".no-button").css("padding-bottom","22px");
        $('#url_check').prop('checked',true);
        $('.funnel_case-check').slideUp();
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.url_case-check').slideDown();
    }

    if (c_data_obj.stickybar_cta_btn_other_url != ""){
        $("#outside_url").val(c_data_obj.stickybar_cta_btn_other_url);
    }
    if(c_data_obj.v_sticky_button != null ){
        setting.sticky_button = c_data_obj.v_sticky_button;
    }
    //sticky css
    $('.leadpops-wrap').css('background', '#'+c_data_obj.cta_background_color);
    setTimeout(function () {
        $('.cta .fr-element.fr-view > p').css({'color': '#'+c_data_obj.cta_color,"font-weight":"300"});
        $('#linkanimation .lp_froala__sticky-bar-button .fr-element.fr-view > p*').css({"color": '#'+c_data_obj.cta_btn_color,'font-weight':'300','font-size':'26px'});
        $('#linkanimation').css('background', '#'+c_data_obj.cta_btn_background_color);
    },400);
    // box values
    $('.background-sticky-bar-box').css('background', '#'+c_data_obj.cta_background_color);
    $('.text-sticky-bar-box').css('background', '#'+c_data_obj.cta_color);
    $('.btn-text-sticky-bar-box').css('background', '#'+c_data_obj.cta_btn_color);
    $('.btn-background-sticky-bar-box').css('background', '#'+c_data_obj.cta_btn_background_color);
    // hidden input value
    $(".cta_btn_background_color").val(c_data_obj.cta_btn_background_color);
    $(".cta_btn_color").val(c_data_obj.cta_btn_color);
    $(".cta_color").val(c_data_obj.cta_color);
    $(".cta_background_color").val(c_data_obj.cta_background_color);
    // span text
    $(".cta_btn_background_color_code").text(c_data_obj.cta_btn_background_color);
    $(".cta_btn_background_color .color-box__hex-block").val('#'+c_data_obj.cta_btn_background_color);
    $(".cta_btn_color_code").text(c_data_obj.cta_btn_color);
    $(".cta_btn_color .color-box__hex-block").val('#'+c_data_obj.cta_btn_color);
    $(".cta_text-color_code").text(c_data_obj.cta_color);
    $(".cta-text-Color .color-box__hex-block").val('#'+c_data_obj.cta_color)
    $(".cta_background_color_code").text(c_data_obj.cta_background_color);
    $(".cta_background_color .color-box__hex-block").val('#'+c_data_obj.cta_background_color);
    $(".cta_background_color-overlay .color-box__hex-block").val('#'+c_data_obj.background_image_color_overlay);
    if(c_data_obj.v_sticky_cta != null ){
        var onloaad_cat_text = c_data_obj.v_sticky_cta;
        setting.sticky_cta = c_data_obj.v_sticky_cta;
    }
    setting.cta_btn_vertical_padding = c_data_obj.cta_btn_vertical_padding;
    setting.cta_btn_horizontal_padding = c_data_obj.cta_btn_horizontal_padding;
    $("#linkanimation").css("padding", setting.cta_btn_vertical_padding+"  "+setting.cta_btn_horizontal_padding+"");

    var vertical =  setting.cta_btn_vertical_padding;
    vertical = vertical.replace("px", "");
    var horizontal =  setting.cta_btn_horizontal_padding;
    horizontal = horizontal.replace("px", "");
    $('#cta_height').val(vertical);
    $('#cta_width').val(horizontal);

    // button background color
    $(".cta_btn_background_color .color-box__r .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_background_color).r);
    $(".cta_btn_background_color .color-box__g .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_background_color).g);
    $(".cta_btn_background_color .color-box__b .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_background_color).b);
    // button color
    $(".cta_btn_color .color-box__r .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_color).r);
    $(".cta_btn_color .color-box__g .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_color).g);
    $(".cta_btn_color .color-box__b .color-box__rgb").val(hexToRgb(c_data_obj.cta_btn_color).b);
    //Text color
    $(".cta-text-Color .color-box__r .color-box__rgb").val(hexToRgb(c_data_obj.cta_color).r);
    $(".cta-text-Color .color-box__g .color-box__rgb").val(hexToRgb(c_data_obj.cta_color).g);
    $(".cta-text-Color .color-box__b .color-box__rgb").val(hexToRgb(c_data_obj.cta_color).b);
    //background color
    $(".cta_background_color .color-box__r .color-box__rgb").val(hexToRgb(c_data_obj.cta_background_color).r);
    $(".cta_background_color .color-box__g .color-box__rgb").val(hexToRgb(c_data_obj.cta_background_color).g);
    $(".cta_background_color .color-box__b .color-box__rgb").val(hexToRgb(c_data_obj.cta_background_color).b);
    // color overlay
    $(".cta_background_color-overlay .color-box__r .color-box__rgb").val(hexToRgb(c_data_obj.background_image_color_overlay).r);
    $(".cta_background_color-overlay .color-box__g .color-box__rgb").val(hexToRgb(c_data_obj.background_image_color_overlay).g);
    $(".cta_background_color-overlay .color-box__b .color-box__rgb").val(hexToRgb(c_data_obj.background_image_color_overlay).b);

    set_default_value(setting);
    if(setting.zindex_type != 2){
        $('#bs-slider-bar').bootstrapSlider('refresh');
        $('#zindex-label').text(1);
    }
    setting.cta_btn_vertical_padding = c_data_obj.cta_btn_vertical_padding;
    setting.cta_btn_horizontal_padding = c_data_obj.cta_btn_horizontal_padding;
    //step 3 start
    var sticky_size = c_data_obj.sticky_size;
    if(c_data_obj.sticky_size != null){
        $("#sticky-bar__how-big").bootstrapSlider('setValue', c_data_obj.sticky_size,true);
        $('.leadpops-wrap').css("height",parseInt(c_data_obj.sticky_size));
        $('#sticky-bar__how-big').val(parseInt(c_data_obj.sticky_size));
    }else{
        $('.leadpops-wrap').css("height",parseInt(138));
        $('#sticky-bar__how-big').val(parseInt(138));
        $("#sticky-bar__how-big").bootstrapSlider('setValue', 138,true);
    }
    if(c_data_obj.cta_box_shadow != "none" && c_data_obj.cta_box_shadow != "" ){
        $("#sticky-bar__shadow").bootstrapSlider("setValue",c_data_obj.cta_box_shadow,true);
        $(".leadpops-wrap").css("box-shadow","0 0  "+c_data_obj.cta_box_shadow+"px #444");
    }else{
        $("#sticky-bar__shadow").bootstrapSlider("setValue",10);
        $(".leadpops-wrap").css("box-shadow","0 0  10px #444");
    }
    setting.cta_btn_vertical_padding = c_data_obj.cta_btn_vertical_padding;
    setting.cta_btn_horizontal_padding = c_data_obj.cta_btn_horizontal_padding;
    var vertical =  setting.cta_btn_vertical_padding;
    vertical = vertical.replace("px", "");
    var horizontal =  setting.cta_btn_horizontal_padding;
    horizontal = horizontal.replace("px", "");
    $('#cta_height').val(vertical);
    $('#cta_width').val(horizontal);
    setting.hide_animation = c_data_obj.hide_animation;
    if(c_data_obj.hide_animation == 1){
        $('#lp-sticky-bar__hide-checker').prop('checked',true);
        $(".lp-sticky-bar__when-hide-wrapper").slideDown();
        $('.sticky-hide').show();
    }else {
        $('.sticky-hide').hide();
    }

    $('.lp-sticky-bar__when-hide-select').val(c_data_obj.when_to_hide);
    $('.lp-sticky-bar__when-hide-select').trigger('change');
    $('.select__want-display').val(c_data_obj.when_to_display);
    $('.select__want-display').trigger('change');

    if(c_data_obj.sticky_location == null || c_data_obj.sticky_location == 't' || c_data_obj.advance_sticky_location == 'stick-at-top' || c_data_obj.advance_sticky_location == 'top-disappear-on-scroll'){
        $("#pin_flag_top").prop('checked' , true);
        $('.leadpops-wrap').removeClass('sticky-position-bottom');
        $('.select__want-placed').val(c_data_obj.advance_sticky_location);
        $('.select__want-placed').trigger('change');
    }else {
        $('.select__want-placed').val(c_data_obj.advance_sticky_location);
        $('.select__want-placed').trigger('change');
        $("#pin_flag_bottom").prop('checked' , true);
        $('.leadpops-wrap').addClass('sticky-position-bottom');
    }

    setting.advance_sticky_location = c_data_obj.advance_sticky_location;

    if(c_data_obj.full_page_sticky_bar_flag == "on"){
        $('#lp-sticky-bar__full-page-checker').prop('checked',true);
        $(".lp-sticky-bar__wrapper").addClass("lp-sticky-bar__full-page");
        setTimeout(function(){
            fullpage_outerheight();
            owl.trigger('refresh.owl.carousel');
        },1000);
    } else {
        $(".leadpops-wrap").css('width','100%');
        $(".lp-sticky-bar__wrapper").removeClass("lp-sticky-bar__full-page");
        setTimeout(function(){
            page_outerheight();
            owl.trigger('refresh.owl.carousel');
        },1000);
    }

    $('.select__want-animation').val(c_data_obj.cta_btn_animation);
    $('.select__want-animation').trigger('change');
    if(c_data_obj.cta_btn_animation == "Radioactive"){
        var cta_button = $("#linkanimation");
        $(cta_button).addClass("radio-active_animation");
        var bg_btn_clr = "#"+c_data_obj.cta_btn_background_color;
        $(".radio__active-animation").remove();
        $('head').append('<style class="radio__active-animation" type="text/css">#linkanimation.radio-active_animation:before , #linkanimation.radio-active_animation:after {background-color:'+bg_btn_clr +'}</style>');
    }else {
        $("#linkanimation").removeClass("radio-active_animation");
        $(".radio__active-animation").remove();
    }
    //step 3 end
    // color picker start
    $('.cta_background_color-init').ColorPicker({
        color: "#"+c_data_obj.cta_background_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_background_color_code").text(hex);
            $(".cta_background_color").val(hex);
            $('.leadpops-wrap , .background-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    // sticky bar text color
    $('.cta_color-init').ColorPicker({
        color: "#"+c_data_obj.cta_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta-text-Color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta-text-Color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta-text-Color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta-text-Color .color-box__hex-block").val('#'+hex);
            $(".cta_text-color_code").text(hex);
            $(".cta_color").val(hex);
            $('.cta .lp_froala__sticky-bar-text .fr-element.fr-view > p*').css('color', '#' + hex);
            $(".lp_froala__sticky-bar-text p span*").css('color', '#' +hex);
            $('.text-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    // sticky bar button background color
    $('.cta_btn_background_color-init').ColorPicker({
        color: "#"+c_data_obj.cta_btn_background_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_btn_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_btn_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_btn_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_btn_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_btn_background_color_code").text(hex);
            $(".cta_btn_background_color").val(hex);
            $('.btn-background-sticky-bar-box , #linkanimation').css('backgroundColor', '#' + hex);

            var cta_button = $("#linkanimation");
            var animation_type = $('.select__want-animation').val();
            if(animation_type == "Radioactive"){
                $(cta_button).addClass("radio-active_animation");
                var bg_btn_clr = $("#linkanimation").css("background-color");
                $(".radio__active-animation").remove();
                $('head').append('<style class="radio__active-animation" type="text/css">#linkanimation.radio-active_animation:before , #linkanimation.radio-active_animation:after {background-color:'+bg_btn_clr +'}</style>');
            } else {
                $(cta_button).removeClass("radio-active_animation");
                $(".radio__active-animation").remove();
            }

        }
    });
    // sticky bar button text color
    $('.cta_btn_color-init').ColorPicker({
        color: "#"+c_data_obj.cta_btn_color+"",
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $('#cta_btn_color').addClass('open');
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $('#cta_btn_color').removeClass('open');
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $(".cta_btn_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_btn_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_btn_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_btn_color .color-box__hex-block").val('#'+hex);
            $(".cta_btn_color_code").text(hex);
            $(".cta_btn_color").val(hex);
            $('#linkanimation .lp_froala__sticky-bar-button .fr-element.fr-view > p*').css('color', '#' + hex);
            $(".lp_froala__sticky-bar-button p span*").css('color', '#' +hex);
            $('.btn-text-sticky-bar-box').css('backgroundColor', '#' + hex);
            $('#linkanimation').css('color', '#' + hex);
        }
    });
    if(c_data_obj.background_image_color_overlay == "None"){
        $(".sticky-bar-code-overlay").text("None");
        $("#cta_background_color-overlay").addClass("color-box__none");
        var overlay = c_data_obj.background_image_color_overlay;
    }else{
        $("#cta_background_color-overlay").removeClass("color-box__none");
        $(".sticky-bar-code-overlay").text('# '+c_data_obj.background_image_color_overlay);
        var overlay = "#"+c_data_obj.background_image_color_overlay+""
    }

    //sticky bar color overlay
    $('.cta_background_color-overlay-init').ColorPicker({

        color: overlay,
        flat: true,
        width: 240,
        height: 152,
        outer_height: 162,
        outer_width: 307,
        onShow: function (colpkr) {
            $('#cta_btn_color').addClass('open');
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $('#cta_btn_color').removeClass('open');
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            setting.update_form = true;
            $("#cta_background_color-overlay").removeClass("color-box__none");
            $(".cta_background_color-overlay .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color-overlay .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color-overlay .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color-overlay .color-box__hex-block").val('#'+hex);
            $(".sticky-bar-code-overlay").text('# '+hex);
            $(".cta_background_color-overlay").val(hex);
            $('.background-sticky-bar-box-overlay,.color-overlay').css('backgroundColor', '#' + hex);
            //    background color change
            $(".cta_background_color .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta_background_color .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta_background_color .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta_background_color .color-box__hex-block").val('#'+hex);
            $(".cta_background_color_code").text(hex);
            $(".cta_background_color").val(hex);
            $('.leadpops-wrap , .background-sticky-bar-box').css('backgroundColor', '#' + hex);
        }
    });
    //color picker end

    //step 4 start
    if(c_data_obj.logo_image_width != "" && c_data_obj.logo_image_width != 0){
        $(".cta__logo").css("width",  parseInt(c_data_obj.logo_image_width)+"px");
        $(".cta__logo").css("height",parseInt(c_data_obj.logo_image_height)+"px");
    }


    $(".cta__logo-wrapper").css("width",""+c_data_obj.logo_image_size+"px");
    Dropzone.autoDiscover = false;
    window.Dropzone;
    if(c_data_obj.logo_image_path != null  && c_data_obj.logo_image_path != ""){
        setting.logo_image = c_data_obj.logo_image_path;
        $('.cta__logo').attr("src", setting.logo_image);
    }else {
        setting.logo_image = "";
        $('.cta__logo').attr("src", setting.logo_image);
    }
    logo_dropzone_init(c_data_obj);
    if( c_data_obj.logo_image_path == null ){
        $('.cta__logo').removeAttr("style");
    }

    $('.select__logo-placement').val(c_data_obj.logo_image_replacement);
    $('.select__logo-placement').trigger('change');
    $("#dropzone-logo-space").bootstrapSlider('setValue', c_data_obj.logo_spacing,true);
    if ($('.select__logo-placement').val() == "top"){
        if(parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()) < 0 ){
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
        }else{
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()));
        }
        $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
        $(".cta__logo").css("left","");
        if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
            $(".cta__logo").css("bottom",+c_data_obj.logo_spacing+"px");
        }else{
            $(".cta__logo").css("bottom","-"+c_data_obj.logo_spacing+"px");
        }
    } else {
        if(parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()) < 0 ){
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
        }else{
            $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()));
        }
        $(".cta__logo").css("bottom","");
        $(".cta__logo").css("left","-"+c_data_obj.logo_spacing+"px");
        $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
        $('.leadpops-wrap').height(c_data_obj.sticky_size);
    }
    if(c_data_obj.logo_image_path != "" && c_data_obj.logo_image_replacement == "top" && c_data_obj.logo_image_path != STICKY_BAR_IMAGES_PATH && third_party_obj.logo_image_path != "/"+STICKY_BAR_IMAGES_PATH){
        $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
    }else{
        $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
    }
    /*$(".dropzone-logo-size__wrapper  .slider .slider-handle").css("left",''+c_data_obj.logo_image_size+"%");
    $(".dropzone-logo-size__wrapper .slider .slider-track .slider-selection").css("width",''+c_data_obj.logo_image_size+"%");
    $('#dropzone-logo-size').val(c_data_obj.logo_image_size);*/
    $("#dropzone-logo-size").bootstrapSlider('setValue', c_data_obj.logo_image_size,true);
    background_dropzone_init(c_data_obj);
    if(c_data_obj.background_image_path != null && c_data_obj.background_image_path != "" && c_data_obj.background_image_path != "none"){
        $('.leadpops-wrap').css("background-image", "url("+c_data_obj.background_image_path+")");
        $('.leadpops-wrap').addClass("has_background_image");
    }else {
        setting.background_image  = "none";
        $('.leadpops-wrap').css("background-image", setting.background_image);
        $('.leadpops-wrap').removeClass("has_background_image");
    }
    $('.cta_background_color-overlay').val(c_data_obj.background_image_color_overlay);
    $(".background-sticky-bar-box-overlay").css("background-color","#"+c_data_obj.background_image_color_overlay);

    $(".dropzone-color-opacity__wrapper .slider .slider-handle").css("left",''+c_data_obj.background_image_opacity*100 +"%");
    $(".dropzone-color-opacity__wrapper .slider .slider-track .slider-selection").css("width",''+c_data_obj.background_image_opacity*100+"%");
    $('#dropzone-color-opacity').val(c_data_obj.background_image_opacity);
    $(".color-overlay").css("opacity",''+c_data_obj.background_image_opacity);
    $(".dropzone-image-size_wrapper .slider .slider-handle").css("left",''+c_data_obj.background_image_size+"%");
    $(".leadpops-wrap").css("background-size",c_data_obj.background_image_size+"%");
    $(".dropzone-image-size_wrapper .slider .slider-track .slider-selection").css("width",''+c_data_obj.background_image_size+"%");
    $('#dropzone-image-size').val(c_data_obj.background_image_size);
    //step 4 end
    if(c_data_obj.sticky_url != null){
        setting.sticky_url = c_data_obj.sticky_url;
    }
    var cta_title_phone_number = c_data_obj.stickybar_number;
    $('#cta_title_phone_number').val(cta_title_phone_number);
    var phone_number_checked = c_data_obj.stickybar_number_flag;
    if(phone_number_checked == "1"){
        $('#call_text_check').prop('checked',true);
        $("#cta_title_phone_number").inputmask({"mask": "(999) 999-9999"});
        $('.lp-sticky-bar__form-group_phone-number').slideDown();
    }else {
        $('#call_text_check').prop('checked',false);
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
    }

    $('#toggle-status').bootstrapToggle('off');
    setting.update_form = false;
    setting.element_id = '#'+_this.attr('id');
    var pending = 0;
    $('.lp-sticky-bar__note').text('');
    if(c_data_obj.sticky_bar_v2 == 'true') {
        setting.token = hash = c_data_obj.sticky_js_file;
        setting.current_funnel_sticky_id = c_data_obj.sticky_id;
        var data_obj = {
            "cta_text_html" : c_data_obj.cta_text_html,
            "cta_btn_text_html" : c_data_obj.cta_btn_text_html,
            "sticky_url" : sticky_url,
            "sticky_status" : c_data_obj.sticky_status,
            "script_type" : c_data_obj.script_type,
            "zindex" : c_data_obj.zindex,
            "zindex_type" : c_data_obj.zindex_type,
            "sticky_size" : c_data_obj.sticky_size,
            "sticky_js_file" : hash,
            "third_party_website_flag" : c_data_obj.third_party_website_flag

        };

        set_default_value(data_obj);

        pages_flag = c_data_obj.sticky_website_flag;
        $('#all_pages').prop('checked' , true);
        $(".lp__url-path").hide();
        if(pages_flag == 1){
            $('#specific_pages').prop('checked' , true);
            $(".lp__url-path").css('display','inline-block');
        }
        setting.cta_btn_text_font_family = c_data_obj.cta_btn_text_font_family;
        setting.cta_text_font_family = c_data_obj.cta_text_font_family;
        var sticky_show_cta = c_data_obj.show_cta;
        if(sticky_show_cta == '1'){
            $("#pin_cta_show").prop('checked' , true);
            $('.sticky-hide').show();
        }
        specific_page_render();
        specific_3rd_party_url_render(c_data_obj);
        $(".sorting").first().attr('data-sort','desc');
        specific_page_validation();

    }else {
        $('.lp-sticky-bar__share-wrap').remove();
    }
    $("#stickybar__pixel_code").val(c_data_obj.sticky_bar_pixel);
    setting.previous_sticky_url = c_data_obj.sticky_url;
    $("#mask").show();
    $("#stickybarurl").val(funnel_name);
    $("#stickybarname").val("");
    $("#stickybarbtnurl").val("");
    $(".lp-sticky-bar").attr("data-funnel", funnel_name);
    $('#client_leadpops_id').val(setting.data_id);
    setting.clients_leadpops_id= c_data_obj.clients_leadpops_id;
    $('#pending_flag').val(pending);
    $('.sticky_bar_url').val(funnel_name);
    $(".lp-sticky-bar").addClass("hidden");

    if(c_data_obj.third_party_website_flag == 1 ){
        third_party_share_url_update();
        third_party_sticky_popup(JSON.parse(setting.last_thrid_party_website_share_url_style));
    }
    setTimeout(function () {
        $(".lp-sticky-bar").removeClass("hidden").addClass("show");
        $('body').css('overflow', 'hidden');
        $("#mask").hide();
        setting.sticky_bar_update_flag = 1;
        setting.website_change = 0;
        if(c_data_obj.third_party_website != "" && c_data_obj.third_party_website!= null){
            setting.number_of_share_links = c_data_obj.third_party_website[c_data_obj.sticky_id].length;
        }
        setting.full_page_sticky_bar_flag = c_data_obj.full_page_sticky_bar_flag;
        c_data_obj.new_client = false;

    }, 500);
    // process_input();
}

/*third party links render*/

function specific_3rd_party_url_render(obj) {
    $('.select2-selection__rendered').removeAttr('title');
    var created_dates = [];
    var url_share = '';
    $('.lp-sticky-bar__share-wrap').remove();
    if(obj.third_party_website_flag == 1 && obj.third_party_website != ""){
        var thrid_party_sticky_urls = obj.third_party_website[c_data_obj.sticky_id];
        for(var a = 0 ; a < thrid_party_sticky_urls.length; a++) {
            if (thrid_party_sticky_urls[a] != '') {
                url_share += '<div class="data__index" data-index=' + a + '>\n' +
                    '<div class="lp-sticky-bar__form-group lp-sticky-bar__share-wrap" data-index="' + a + '"   data-id="' + thrid_party_sticky_urls[a].id + '"  data-sticky-url="' + thrid_party_sticky_urls[a].sticky_url + '"  data-sticky-style="' + thrid_party_sticky_urls[a].sticky_bar_style + '"    data-sticky-hash=' + thrid_party_sticky_urls[a].hash + '>\n' +
                    '           <div class="lp-sticky-bar__share-links">\n' +
                    '               <span class="share__link-date" date-creaded-date="' + thrid_party_sticky_urls[a].created_date + '">' + thrid_party_sticky_urls[a].created_date_format + '</span>\n' +
                    '               <span class="lp-sticky-bar__original-link-wrap">\n' +
                    '                   <span class="lp-sticky-bar__original-link sticky-tooltip-body" data-toggle="tooltip" title="' + thrid_party_sticky_urls[a].third_party_url_tooltip + '" data-html="true" data-container="body" data-placement="top">' + thrid_party_sticky_urls[a].sticky_url.replace(/^https?:\/\//,"") + '</span>\n' +
                    '               </span>\n' +
                    '               <span>' + thrid_party_sticky_urls[a].clicks + '</span>\n' +
                    '               <span class="share-link__action">\n' +
                    '                   <span href="#" class="share-link__edit sticky-tooltip third_party_sticky_url_edit" data-third-party-url=' + thrid_party_sticky_urls[a].third_party_url + '  data-toggle="tooltip" data-html="true" data-container="body" data-placement="top" data-original-title="Edit Sticky Bar">\n' +
                    '                       <i class="lp__sprite-icon lp__edit-icon sticky-tooltip"></i>\n' +
                    '                   </span>\n' +
                    '                   <span href="#" class="share-link__copy sticky-tooltip" data-toggle="tooltip" data-html="true" data-placement="top" data-container="body" data-original-title="Copy Link">\n' +
                    '                       <i class="lp__sprite-icon clone-icon"></i>\n' +
                    '                   </span>\n' +
                    '                   <span href="#" class="share-link__remove">\n' +
                    '                       <i class="lp__sprite-icon remove-icon"></i>\n' +
                    '                   </span>\n' +
                    '               </span>\n' +
                    '           </div>\n' +
                    '           <div class="share-link-remove__confirmation">\n' +
                    '               <span class="share-link-remove__confirmation-message">Are you sure you want to delete this share link?</span>\n' +
                    '               <span class="share-link-remove__confirmation-action">\n' +
                    '                   <a href="#" class="share-link-remove__yes">Yes</a>\n' +
                    '                   <a href="#" class="share-link-remove__no">No</a>\n' +
                    '               </span>\n' +
                    '           </div>\n' +
                    '       </div>\n' +
                    '       <div class="lp-original__link-block">\n' +
                    '       <div class="lp-original-link-header clearfix">\n' +
                    '       <span class="lp-original-link-heading">Share Link</span>\n' +
                    '       <span class="lp-original-close-block">\n' +
                    '       <i class="lp__sprite-icon close-icon"></i>\n' +
                    '       </span>\n' +
                    '       </div>\n' +
                    '       <div class="lp-original-link-body">\n' +
                    '           <div class="lp-original-link">\n' +
                    '               <a target="_blank" href=' + STICKY_BAR_THIRD_PARTY_DOMAIN + '/' + thrid_party_sticky_urls[a].hash + '~' + thrid_party_sticky_urls[a].sticky_url + '>' + STICKY_BAR_THIRD_PARTY_DOMAIN + '/' + thrid_party_sticky_urls[a].hash + '</a>\n' +
                    '           </div>\n' +
                    '           <div class="lp-original-link__social_wrapper">\n' +
                    '               <ul class="social_link__list">\n' +
                    '                   <li class="social_link__item">\n' +
                    '                       <a href="#" class="social_link__link">\n' +
                    '                           <i class="fa fa-facebook-f"></i>\n' +
                    '                       </a>\n' +
                    '                   </li>\n' +
                    '                   <li class="social_link__item">\n' +
                    '                       <a href="#" class="social_link__link">\n' +
                    '                           <i class="fa fa-pinterest-p"></i>\n' +
                    '                       </a>\n' +
                    '                   </li>\n' +
                    '                   <li class="social_link__item">\n' +
                    '                       <a href="#" class="social_link__link">\n' +
                    '                           <i class="fa fa-envelope"></i>\n' +
                    '                       </a>\n' +
                    '                   </li>\n' +
                    '                   <li class="social_link__item">\n' +
                    '                       <a href="#" class="social_link__link">\n' +
                    '                           <i class="fa fa-linkedin"></i>\n' +
                    '                       </a>\n' +
                    '                   </li>\n' +
                    '                   <li class="social_link__item">\n' +
                    '                       <a href="#" class="social_link__link">\n' +
                    '                           <i class="fa fa-twitter"></i>\n' +
                    '                       </a>\n' +
                    '                   </li>\n' +
                    '               </ul>\n' +
                    '           </div>\n' +
                    '       </div>\n' +
                    '       </div>\n' +
                    '       </div>';
            }
        }

        $(".lp-sticky-bar__third-party").mCustomScrollbar("destroy");
        $('.lp-sticky-bar__third-party__previous-links').html(url_share);
        $('.sticky-tooltip').tooltip();
        $('.sticky-tooltip-body').tooltip({
            template: '<div class="tooltip show_full-url"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
        });
        $(".lp-sticky-bar__third-party").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: false,
            mouseWheel:{ scrollAmount: 70 },
            callbacks:{
                onInit:function(){
                    if($(".data__index").length > 3){
                        $(".lp-sticky-bar__share-links").parents(".lp-sticky-bar__destination-bar").addClass("lp-sticky-bar__mrg-right");
                    } else {
                        $(".lp-sticky-bar__share-links").parents(".lp-sticky-bar__destination-bar").removeClass("lp-sticky-bar__mrg-right");
                    }
                }
            }
        });
    } else {
        var thrid_party_sticky_urls = null;
    }
}

/*specific page render*/

function specific_page_render() {
    $('.select2-selection__rendered').removeAttr('title');
    c_data_obj = getActiveElementObj();
    var pages_path = c_data_obj.sticky_url_pathname;
    if(pages_path==null){
        pages_path='';
    }
    var path_arr = pages_path.split("~");
    if(path_arr[0] == '/'){
        $('#sticky-home-page').prop('checked' , true);
        path_arr.splice(0 ,1);
    }
    for(var i = 0 ; i < path_arr.length; i++) {
        var field = '<div class="lp-sticky-page-wrap">\n' +
            '           <div class="lp-sticky-bar__form-group lp-sticky-bar_clone db_save">\n' +
            '               <div class="lp-sticky-bar__left">\n' +
            '                   <div class="lp-sticky-bar__input">\n' +
            '                      <span class="lp-sticky-bar__input-icon">\n' +
            '                        <i class="lp__sprite-icon link-icon"></i>\n' +
            '                      </span>\n' +
            '                       <input type="text" id="pages" name="pages[]" class="form-control lp-sticky-bar__form-control" value="' + path_arr[i] + '"/>\n' +
            '                   </div>\n' +
            '                   <label id="" class="error sticky-page__error" for="" style="">This field is required.</label>\n' +
            '           	</div>\n' +
            '				<div class="lp-sticky-bar__right">\n' +
            '					<a href="#" id="remove" class="lp-sticky-bar__remove"><i class="fa fa-remove"></i></a>\n' +
            '				</div>\n' +
            '			</div>\n' +
            '			<div class="lp-sticky-bar__form-group lp-sticky-bar__confirmation-block">\n' +
            '				<div class="lp-sticky-bar__confirmation">\n' +
            '					<span class="lp-note">Are you sure you want to delete this share link?</span>\n' +
            '					<span class="lp-option">\n' +
            '						<a href="#" class="yes">Yes</a>\n' +
            '						<a href="#" class="no">No</a>\n' +
            '					</span>\n' +
            '				</div>\n' +
            '			</div>\n' +
            '</div>';
        $('.add-more').before(field);
    }

}

/*specific page validation*/

function specific_page_validation(){
    $('.lp-sticky-bar_clone input').on('blur',function(){
        var remove_slash = $(this).val().replace(/\/$/, '');
        $(this).val(remove_slash);
        var url = $(this).val();
        var char = url.charAt(0);
        if(url != ''){
            // url = url.replace(/\/$/g,'');
            url = url.replace("\\", "");
            $(this).val(url);
            if(char !== '/' && char !== '?'){
                $(this).addClass('error');
                $(this).next().text('Please enter a valid URL.').show();
            }
        }else{
            $(this).addClass('error');
            $(this).next().show();
        }

    });
}

/*set values in input fields*/

function set_default_value(setting){
    setTimeout(function () {
        $('.lp_froala__sticky-bar-text').froalaEditor('html.set', setting.cta_text_html);
        $('.lp_froala__sticky-bar-button').froalaEditor('html.set', setting.cta_btn_text_html);

    },100);
    $('.bar_title').val(setting.sticky_cta);
    if(setting.hasOwnProperty('sticky_cta_text')){
        $('.bar_title[name=bar_title_visible]').val(setting.sticky_cta_text);
    }
    $('#cta_title').val(setting.sticky_button);
    console.info('here');
    $('#cta_url').val(setting.sticky_url);
    $('#insert_flag').val(c_data_obj.sticky_js_file);
    $('#sticky_status').val(setting.sticky_status);
    $('#sticky_script_type').val(setting.script_type);
    $('#zindex').val(setting.zindex);
    $('.lp-popup-radio_zindex[value='+setting.zindex_type+']').trigger('change');
    $('.lp-popup-radio_zindex[value='+setting.zindex_type+']').prop('checked', true);
    if(setting.zindex_type == 2){
        $('#bs-slider-bar').bootstrapSlider('setValue', setting.zindex);
        $('#zindex-label').text(setting.zindex);
        $('#zindex-label').digits();
    }else if(setting.zindex_type == 3){
        $(".zindex-company").val(setting.zindex).trigger('change');
    }
    var pending = setting.pending_flag;
    if(setting.script_type == 'f'){
        $('#switch-script').prop('checked' , true);
        $('.code-switch__caption').text('View Code without Script Tags'); //with
    }
    if(setting.third_party_website_flag != 1){
        $(".slug__url-text").hide();
        $("#third-party__previoue-link").hide();
        $('#toggle-status').show();
        if(setting.sticky_status != 0) {
            $('#toggle-status').bootstrapToggle('on');
            setting.update_form = false;
            if(pending != 0){
                if((setting.full_page_sticky_bar_flag == "on") && (setting.third_party_website_flag == 0 )){
                    $(".fullpage__status").show();
                    $(".defaultpage__status").hide();
                }else if((setting.full_page_sticky_bar_flag == undefined || setting.full_page_sticky_bar_flag == "off") && (setting.third_party_website_flag == 0 )){
                    $(".fullpage__status").hide();
                    $(".defaultpage__status").show();
                }else{
                    $(".fullpage__status").hide();
                    $(".defaultpage__status").hide();
                }
                $(".lp-sticky-bar__note").text('(Installed Successfully)');
            }else{
                if(setting.full_page_sticky_bar_flag == "on" && (setting.third_party_website_flag == 0 )){
                    $(".fullpage__status").show();
                    $(".defaultpage__status").hide();
                }else if((setting.full_page_sticky_bar_flag == undefined || setting.full_page_sticky_bar_flag == "off")  && setting.third_party_website_flag == 0){
                    $(".defaultpage__status").show();
                    $(".fullpage__status").hide();
                }else{
                    $(".defaultpage__status").hide();
                    $(".fullpage__status").hide();
                }
                $(".lp-sticky-bar__note").text('(Pending Installation)');
            }
        }else{
            // hide;
            if(pending != 0){
                if(setting.full_page_sticky_bar_flag == "on" && (setting.third_party_website_flag == 0 ||setting.third_party_website_flag == 2)){
                    $(".fullpage__status").show();
                    $(".defaultpage__status").hide();
                }else if(setting.full_page_sticky_bar_flag == "on" && setting.third_party_website_flag == 0 ){
                    $(".defaultpage__status").show();
                    $(".fullpage__status").hide();
                }else{
                    $(".defaultpage__status").hide();
                    $(".fullpage__status").hide();
                }
                $(".lp-sticky-bar__note").text('(Pending Installation)');
            }
        }
    }else{
        $('#toggle-status').hide();
        $(".fullpage__status").hide();
        $(".defaultpage__status").hide();
        $(".slug__url-text").show();
        $("#third-party__previoue-link").show();
    }

}


/*update current data obj with ajax response*/

function update_attributes(obj){
    var sb_obj = JSON.parse(obj.sticky);
    c_data_obj.sticky_cta= sb_obj.sticky_cta;
    c_data_obj.sticky_button= sb_obj.sticky_button;
    c_data_obj.sticky_url= sb_obj.sticky_url;
    c_data_obj.sticky_funnel_url= sb_obj.sticky_funnel_url;
    c_data_obj.sticky_js_file= obj.hash;
    c_data_obj.sticky_website_flag= sb_obj.sticky_website_flag;
    if(sb_obj.sticky_url_pathname==null){
        c_data_obj.sticky_url_pathname= "/";
    }else{
        c_data_obj.sticky_url_pathname= sb_obj.sticky_url_pathname;
    }
    c_data_obj.sticky_location=sb_obj.sticky_location;
    c_data_obj.script_type=sb_obj.script_type;
    c_data_obj.zindex=sb_obj.zindex;
    c_data_obj.zindex_type=sb_obj.zindex_type;
    c_data_obj.show_cta=sb_obj.show_cta;
    c_data_obj.stickybar_number=sb_obj.stickybar_number;
    c_data_obj.stickybar_number_flag=sb_obj.stickybar_number_flag;
    c_data_obj.third_party_website_flag= sb_obj.third_party_website_flag;
    if(c_data_obj.third_party_website_flag == 1){
        c_data_obj.third_party_website = sb_obj.third_party_website;
        third_party_share_url_update();
    }
    setactiveinactiveflag(obj);
}

/*update current data obj's third party data with ajax response*/

function third_party_share_url_update() {
    var last_inserted_third_party_webiste_data_index = 0;
    for (i=0; i<c_data_obj.third_party_website[c_data_obj.sticky_id].length ; i++){
        if (c_data_obj.third_party_website[c_data_obj.sticky_id][i].id >  c_data_obj.third_party_website[c_data_obj.sticky_id][last_inserted_third_party_webiste_data_index].id){
            last_inserted_third_party_webiste_data_index = i ;
        }
    }
    var last_inserted_third_party_webiste_data = c_data_obj.third_party_website[c_data_obj.sticky_id][last_inserted_third_party_webiste_data_index];
    var third_party_webiste_last_inserted_hash = last_inserted_third_party_webiste_data.hash;
    var third_party_webiste_last_inserted_sticky_url = last_inserted_third_party_webiste_data.sticky_url;
    setting.thrid_party_website_share_url = third_party_webiste_last_inserted_sticky_url;
    // $('.thrid_party_website_share_url').val(STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+third_party_webiste_last_inserted_hash);
    $('.thrid_party_website_share_url').val(third_party_webiste_last_inserted_hash);
    $('.thrid_party_website_share_url').attr("data-domain-url",STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+third_party_webiste_last_inserted_hash);
    $('.thrid_party_website_share_url').attr("data-sticky-url",third_party_webiste_last_inserted_sticky_url);
    $(".slug__url-text a").attr('href', STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+last_inserted_third_party_webiste_data.third_party_url);
    $(".slug__url-text a").text("clix.ly/"+third_party_webiste_last_inserted_hash);
    $("#cta_url").val(last_inserted_third_party_webiste_data.sticky_url);
    setting.last_thrid_party_website_share_url_style = last_inserted_third_party_webiste_data.sticky_bar_style;
}


/*alert msgs*/

function alert_message(msg , str){
    str = str || "success";
    var title = 'Success';
    if(str == 'danger'){
        title = 'Error';
    }
    var html = '<div class="alert alert-'+str+' lp-sticky-bar__alert">\n' +
        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
        '  <strong>'+title+'! </strong>'+ msg +
        '</div>';
    $(html).hide().appendTo(".msg").slideDown(500).delay(3000).slideUp(500 , function(){
        $(this).remove();
    });
}

/*sticky bar code*/

function generate_code(url , type){
    type = type || 'a';
    if(type == 'a'){
        var script = '&lt;script  type="text/javascript" src="'+url+'">&lt;/script>' + '<br /><br />';
        $('#copy_code').html(script);
    }else{
        var script ='\/* leadPops Sticky Bar Code Starts Here *\/'+'<br /><br />var lpsticky = document.createElement(\'script\');<br />' +
            'lpsticky.async = true;<br />' +
            'lpsticky.src=\''+ url + '\';<br />' +
            'var lpstickytag = document.getElementsByTagName(\'script\')[0];<br />' +
            'lpstickytag.parentNode.insertBefore(lpsticky , lpstickytag);<br /><br />'+'\/* leadPops Sticky Bar Code Ends Here *\/';
        $('#copy_code').html(script);
    }
}

/*clear form data*/

function clearForm(form) {
    $(':input', form).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        if (type == 'text' || type == 'hidden'|| type == 'password' || tag == 'textarea') {
            this.value = "";
        }else if (type == 'checkbox') {
            this.checked = false;
        }else if (tag == 'select') {
            this.selectedIndex = -1;
        }
    });
}

/*close sticky bar*/

function closestickypopup() {
    $("body").removeClass("sticky-bar__v2");
    $(".lp-sticky-bar").removeClass("show").removeAttr("data-funnel");
}

/*hide url notification*/

function hideUrlNotice() {
    $('.msg').slideUp(500,function(e){
        $(this).html('').show();
        setting.lp_stop = true;
    });
}

/* Set Active Inactive flag */

function setactiveinactiveflag(obj) {
    setting.active_flag = false;
    var sb_obj = JSON.parse(obj.sticky);
    var st = sb_obj.sticky_status;
    var pnd = sb_obj.pending_flag;

    //sticky builder flag

    if(st != 0){
        if(pnd != 0){
            $(".lp-sticky-bar__note").text('(Installed Successfully)').show();
        }else{
            $(".lp-sticky-bar__note").text('(Pending Installation)').show();
        }
    }else {
        // hide
        if (pnd != 0) {
            $(".lp-sticky-bar__note").text('(Pending Installation)').show();
        } else {
            $(".lp-sticky-bar__note").hide();
            $('#toggle-status').bootstrapToggle('off');
        }

    }
}


/*show url notification*/

function ShowUrlNotice(_selector) {
    var url = _selector.val();
    url = url.replace(/^(?:https?:\/\/)?/i, "").split('/')[0];
    _selector.val(url);
    var message = 'URL you are adding is already set up with funnel "'+setting.url_arr[url]+'"- after you save the previous funnel will become inactive. Remember to delete the code associated with "'+setting.url_arr[url]+'" on your domain and replace it with the generated code.';
    var html = '<div class="alert alert-success lp-sticky-bar__alert url-alert">\n' +
        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
        '  <strong>Alert! </strong>'+ message +
        '</div>';
    // $('[data-sticky_url="'+url+'"]').attr('data-sticky_website_flag');
    var radio_status = $('.sticky-radio:checked').val();
    if(setting.url_arr[url] != undefined && radio_status != '' && setting.url_arr[url] != $('.sticky_bar_url').val().toLowerCase()){
        $('#duplicate_url').val('1');
        if(setting.lp_stop){
            setting.lp_stop = false;
            $(html).hide().appendTo(".msg").slideDown(500).delay(50000).slideUp(500 , function(){
                $(this).remove();
                setting.lp_stop = true;
            });
        }
    }else{
        hideUrlNotice();
        $('#duplicate_url').val('0');
    }
}

/*window load*/

$(window).on("load",function(){
    $(".lp-sticky-bar__inner").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: false,
        mouseWheel:{ scrollAmount: 300 },
        callbacks:{
            whileScrolling:function(){
                var postion = $("#cta_background_color").offset();
                var select_button = $("#cta_color").offset();
                var select_button2 = $("#cta_btn_background_color").offset();
                var select_button3 = $("#cta_btn_color").offset();
                var select_button4 = $("#cta_background_color-overlay").offset();
                var window_height = $(window).height();
                var select_dropdown = $('.color-box__panel-wrapper').height();
                var select_dropdown_overlay = $('.color-box__panel-wrapper.cta_background_color-overlay').height();
                var select_total = select_button.top + select_dropdown;
                var select_total2 = select_button2.top + select_dropdown;
                var select_total3 = select_button3.top + select_dropdown;
                var select_total4 = select_button4.top + select_dropdown_overlay;

                $(".color-box__panel-wrapper.cta_background_color").offset({top:postion.top+47, left:postion.left+1});

                if(window_height < select_total){
                    $(".color-box__panel-wrapper.cta-text-Color").offset({top:select_button.top-select_dropdown-22, left:select_button.left+1});
                }
                else {
                    $(".color-box__panel-wrapper.cta-text-Color").offset({top:select_button.top+47, left:select_button.left+1});
                }
                if (window_height < select_total2){
                    $(".color-box__panel-wrapper.cta_btn_background_color").offset({top:select_button2.top-select_dropdown-22, left:select_button2.left+1});

                }
                else {
                    $(".color-box__panel-wrapper.cta_btn_background_color").offset({top:select_button2.top+47, left:select_button2.left+1});
                }
                if (window_height < select_total3){
                    $(".color-box__panel-wrapper.cta_btn_color").offset({top:select_button3.top-select_dropdown-23, left:select_button3.left+1});

                }
                else {
                    $(".color-box__panel-wrapper.cta_btn_color").offset({top:select_button3.top+47, left:select_button3.left+1});
                }
                if (window_height < select_total4){
                    $(".color-box__panel-wrapper.cta_background_color-overlay").offset({top:select_button4.top-select_dropdown_overlay-23, left:select_button4.left+1});
                }
                else {
                    $(".color-box__panel-wrapper.cta_background_color-overlay").offset({top:select_button4.top+47, left:select_button4.left+1});
                }
            }
        },
        advanced:{ updateOnSelectorChange: "true" }
    });
    $(".lp-sticky-bar__clone-wrap").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: false,
        mouseWheel:{ scrollAmount: 300 }
    });

    $(".lp-sticky-bar__third-party").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: false,
        mouseWheel:{ scrollAmount: 300 }
    });
});

Dropzone.autoDiscover = false;

/*window resize */

$(window).resize(function(){
    if(setting.sticky_bar_update_flag == 1){
        if(setting.full_page_sticky_bar_flag == "on"){
            fullpage_outerheight();

        } else {
            page_outerheight();
        }
    }
    $(".lp-sticky-bar__clone-wrap").mCustomScrollbar("update");
});

/*docoment ready*/

$(document).ready(function () {
    c_data_obj = getActiveElementObj();

    $.fn.digits = function(){
        return this.each(function(){
            $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
        })
    };

    $('.sticky-bar__v2 .custom-btn-toggle').on('click',function () {
        var funnel_sticky_status='';

        c_data_obj = getActiveElementObj();
        if (c_data_obj.sticky_updated){
            if(c_data_obj.sticky_status == 0){
                funnel_sticky_status = '(Inactive)';
            }else if(c_data_obj.pending_flag == 0){
                funnel_sticky_status = '(Pending Installation)';
            }else{
                funnel_sticky_status = '(Active)';
            }
        }

        $('.lp-sticky-bar__note').text(funnel_sticky_status);

        if(setting.full_page_sticky_bar_flag == "on" && (setting.third_party_website_flag == 0)){
            $(".fullpage__status").show();
            $(".defaultpage__status").hide();
        }else if(setting.full_page_sticky_bar_flag == "off" && setting.third_party_website_flag == 0 ){
            $(".defaultpage__status").show();
            $(".fullpage__status").hide();
        }else{
            $(".fullpage__status").hide();
            $(".defaultpage__status").hide();
        }

    });
    $('.bar_title').blur(function phonenumber(inputtxt) {
        var phoneregex = /\(?\d{3}(\) |[\-\.])\d{3}[\-\.]\d{4}/;
        var sticky_bar_say = $('.bar_title').val();
        c_data_obj = getActiveElementObj();
        c_data_obj.sticky_cta=sticky_bar_say;
        var compares = sticky_bar_say.match(phoneregex);
        if (compares!= null ){
            var phone_number = compares[0];
            var hrf = " <a href='tel:"+phone_number+"'>"+ phone_number+"</a>";
            var cta_text=$('.bar_title').val().replace(/\(?\d{3}(\) |[\-\.])\d{3}[\-\.]\d{4}/, hrf);
            $('.cta').html(cta_text);
            $('.bar_title_hidden').val(cta_text);
        }
    });
    //tooltip
    $('body').on('mouseleave' , '.lp-sticky-bar__original-link' ,function(){
        $(".sticky-bar__v2 .tooltip").hide();
    });

    jQuery(document).click(function(e) {
        var target = e.target;
        if (jQuery(target).parents('.lp-sticky-bar__original-link-wrap').length > 0) { }
        else{
            $(".sticky-bar__v2 .tooltip").hide();
        }
    });

    /*$('.custom_scroll').click(function () {
      $(this).niceScroll({
          cursorcolor:"#fff",
          cursorwidth: "10px",
          autohidemode:false,
          nativeparentscrolling: true,
          // cursorfixedheight: 100,
          sensitiverail: true,
          // smoothscroll: true,
          railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
          cursorborder: "2px solid #02abec",
      })
    });*/

    $('body').on('click','.lp-sticky-bar__original-link', function(){
        var last_child = $(".mCSB_container .lp-sticky-bar__share-wrap:last").attr("data-index");
        if ($(this).parents(".lp-sticky-bar__share-wrap").next(".lp-original__link-block").is(':hidden')){
            $(".lp-original__link-block").slideUp();
            $(this).parents(".lp-sticky-bar__share-wrap").next(".lp-original__link-block").slideDown();
            if($(".data__index").length == 3){
                $(".lp-sticky-bar__share-links").parents(".lp-sticky-bar__destination-bar").addClass("lp-sticky-bar__mrg-right");
            }
        }else {
            $(this).parents(".lp-sticky-bar__share-wrap").next(".lp-original__link-block").slideUp();
            if($(".data__index").length <= 3){
                $(".lp-sticky-bar__share-links").parents(".lp-sticky-bar__destination-bar").removeClass("lp-sticky-bar__mrg-right");
            }
        }

        third_party_obj = "";
        third_party_obj = c_data_obj.third_party_website[c_data_obj.sticky_id][$(this).parents(".lp-sticky-bar__share-wrap").attr("data-index")].sticky_bar_style;
        if(third_party_obj != ""){
            third_party_obj = JSON.parse(third_party_obj);
            third_party_sticky_popup(third_party_obj);
        }
        var hash =$(this).parents(".lp-sticky-bar__share-wrap").attr("data-sticky-hash");
        thrid_party_url_clicked ="";
        thrid_party_url_clicked = $(this).parents(".lp-sticky-bar__share-wrap").attr("data-sticky-url");
        $(".slug__url-text a").attr('href',  STICKY_BAR_THIRD_PARTY_DOMAIN+'/'+hash+"~"+thrid_party_url_clicked);
        $(".slug__url-text a").text("clix.ly/" +hash);
        $("#cta_url").val(thrid_party_url_clicked);
        setting.thrid_party_website_share_url = thrid_party_url_clicked;
        owl_refresh(400);
    });

    $('body').on('click','.lp-original-close-block', function(){
        $(this).closest(".lp-original__link-block").slideUp();
        owl_refresh(400);
    });

    $('body').on('click','.third_party_sticky_url_edit', function(){
        var str = $(this).attr("data-third-party-url");
        var words = str.split('~');
        setting.third_party_url_edit_hash = words[0];
        setting.third_party_url_edit = $(this).attr("data-third-party-url");
        $(".slug__url-text a").text("clix.ly/"+words[0]);
        $(".slug__url-text a").attr('href',  STICKY_BAR_THIRD_PARTY_DOMAIN+'/'+str);
        owl.trigger('to.owl.carousel', 0, 500);
        $("#cta_url").val(words[1]);
        $("#cta_url").select();
        $(".thrid_party_website_share_url ").val(words[0]);
        $('.thrid_party_website_share_url').attr("data-domain-url",STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+words[0]);
        $('.thrid_party_website_share_url').attr("data-sticky-url",words[1]);
    });

    $('body').on('click','.share-link__remove', function(){
        $(this).closest(".lp-sticky-bar__share-links").toggle();
        $(this).parents('.lp-sticky-bar__share-links').next(".share-link-remove__confirmation").toggle();
        owl_refresh(400);
    });

    $('body').on('click' , '.share-link-remove__no' ,function(){
        $(this).parents('.share-link-remove__confirmation').hide();
        $(this).parents('.lp-sticky-bar__share-wrap').find(".lp-sticky-bar__share-links").show();
        owl_refresh(400);
    });

    $('body').on('click' , '.share-link-remove__yes' ,function(){
        $third_party_website_id = $(this).parents('.lp-sticky-bar__form-group').attr('data-id');
        $third_party_website_index = $(this).parents('.lp-sticky-bar__form-group').attr('data-index');
        $.ajax({
            type : "POST",
            url : "/lp/popadmin/diactivethirdpartywebsite",
            data : {'id':$third_party_website_id,"funnel_id":c_data_obj.clients_leadpops_id,'_token':ajax_token},
            success : function(data) {
                c_data_obj.third_party_website[c_data_obj.sticky_id][$third_party_website_index] = '';
                c_data_obj.url_flag = "";
                setting.logo_image_path =  "";
                setting.background_image_path =  "" ;
                setting.number_of_share_links--;
                specific_3rd_party_url_render(c_data_obj);
            },
            cache : false,
            async : false
        });
        $(this).parents('.data__index').remove();
        if($(".data__index").length <= 3){
            $(".lp-sticky-bar__share-links").parents(".lp-sticky-bar__destination-bar").removeClass("lp-sticky-bar__mrg-right");
        }
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Your link has been deleted.' +
            '</div>';
        $(html).hide().appendTo(".msg").slideDown(700).delay(1500).slideUp(700 , function(){
            $(this).remove();
        });
        owl_refresh(400);
    });

    $( ".thrid_party_website_share_url" ).blur(function() {
        var $slug = '';
        var trimmed = $.trim($(this).val());
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
        replace(/-+/g, '-').
        replace(/^-|-$/g, '');
        $(this).val($slug.toLowerCase());
    });

    $(document).on('input','#cta_width',function(){
        setting.update_form = true;
        setting.cta_btn_horizontal_padding = $(this).val();
        $("#linkanimation").css({"padding-left": setting.cta_btn_horizontal_padding+"px" ,"padding-right":setting.cta_btn_horizontal_padding+"px" });
    });

    $(document).on('input','#cta_height',function(){
        setting.update_form = true;
        if($(".leadpops-wrap").height() > parseInt($('.ctalink').height())+ parseInt(10)) {
            setting.cta_btn_vertical_padding = $(this).val();
            $("#linkanimation").css({"padding-top": setting.cta_btn_vertical_padding+"px","padding-bottom":setting.cta_btn_vertical_padding+"px"});
        }else if($(".leadpops-wrap").height() > parseInt($(this).val()*2) +$("#linkanimation").height()+ (parseInt(10))) {
            setting.cta_btn_vertical_padding = $(this).val();
            $("#linkanimation").css({"padding-top": setting.cta_btn_vertical_padding+"px","padding-bottom":setting.cta_btn_vertical_padding+"px"});
        }
        $('#linkanimation p').filter(function(){return $(this).text().trim().length==0}).remove();
    });

    $(".thrid_party_website_share_url").keypress(function (event) {
        setting.update_form = true;
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13){
            var $slug = '';
            var trimmed = $.trim($(this).val());
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
            $(this).val($slug.toLowerCase());
            event.preventDefault();
            var third_party_url =  $(".thrid_party_website_share_url").attr("data-domain-url");
            var third_party_website =  $(".thrid_party_website_share_url").attr("data-sticky-url");
            third_party_url = third_party_url.replace("http://clix.ly/","");
            var slug_name = $(".thrid_party_website_share_url").val();
            var hash = setting.old_slug;
            $('.lp-sticky-bar__loader').show();
            $.ajax({
                type : "POST",
                url : "/lp/popadmin/savethirdpartyslug",
                data : {hash:third_party_url , client_id:c_data_obj.client_id ,hash : hash ,slug: slug_name,url: third_party_website,'_token':ajax_token},
                success : function(data) {
                    var obj = data;
                    obj = JSON.parse(obj);
                    if(obj.status == 'success'){
                        $(".thrid_party_website_share_url").attr("data-domain-url","http://clix.ly/"+obj.data+"");
                        if(setting.third_party_index == null){
                            var third_party_index = setting.third_party_index;
                        }else{
                            var third_party_index = $(".lp-sticky-bar__share-wrap").last().attr("data-index");
                        }
                        var third_id = c_data_obj.sticky_id;
                        c_data_obj.third_party_website[third_id][third_party_index].hash=obj.data;
                        var newurl = obj.data+"~"+third_party_website;
                        c_data_obj.third_party_website[third_id][third_party_index].third_party_url=newurl;
                        $(".slug__url-text a").attr('href', newurl);
                        $(".slug__url-text a").text("clix.ly/"+obj.data)
                        specific_3rd_party_url_render(c_data_obj);
                        set_obj_after_ajax();
                        set_defeult_steps();
                        owl_refresh(400);
                        $('#prev-sticky-bar').show();
                        setting.update_form = false;
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(obj.response);
                    }else{
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(obj.response , 'danger');
                    }
                },
                cache : false,
                async : false
            });
        }
    });

    $('body').on('click' , '.third-party-slag-name' ,function() {
        var third_party_url =  $(".thrid_party_website_share_url").attr("data-domain-url");
        var third_party_website =  $(".thrid_party_website_share_url").attr("data-sticky-url");
        third_party_url = third_party_url.replace("http://clix.ly/","");
        var slug_name = $(".thrid_party_website_share_url").val();
        var hash = setting.old_slug;
        if(setting.update_form == true){
            $('.lp-sticky-bar__loader').show();
            $.ajax({
                type : "POST",
                url : "/lp/popadmin/savethirdpartyslug",
                data : {hash:third_party_url , client_id:c_data_obj.client_id ,hash : hash ,slug: slug_name,url: third_party_website,'_token':ajax_token},
                success : function(data) {
                    var obj = data;
                    obj = JSON.parse(obj);
                    if(obj.status == 'success'){
                        $(".thrid_party_website_share_url").attr("data-domain-url","http://clix.ly/"+obj.data+"");
                        if(setting.third_party_index == null){
                            var third_party_index = setting.third_party_index;
                        }else{
                            var third_party_index = $(".lp-sticky-bar__share-wrap").last().attr("data-index");
                        }
                        var third_id = c_data_obj.sticky_id;
                        c_data_obj.third_party_website[third_id][third_party_index].hash=obj.data;
                        var newurl = obj.data+"~"+third_party_website;
                        c_data_obj.third_party_website[third_id][third_party_index].third_party_url=newurl;
                        $(".slug__url-text a").attr('href', newurl);
                        $(".slug__url-text a").text("clix.ly/"+obj.data);
                        specific_3rd_party_url_render(c_data_obj);
                        set_defeult_steps ();
                        set_obj_after_ajax ();
                        owl_refresh(400);
                        $('#prev-sticky-bar').show();
                        setting.update_form = false;
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(obj.response);
                    }else{
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(obj.response , 'danger');
                    }
                },
                cache : false,
                async : false
            });
        }
    });

    $('body').on('click' , '.lp-sticky-bar__original-link' ,function() {
        $third_party_website_id = $(this).parents('.lp-sticky-bar__form-group').attr('data-id');
        $third_party_website_index = $(this).parents('.lp-sticky-bar__form-group').attr('data-index');
        var third_party_webiste_hash = c_data_obj.third_party_website[c_data_obj.sticky_id][$third_party_website_index].hash;
        var third_party_webiste_sticky_url = c_data_obj.third_party_website[c_data_obj.sticky_id][$third_party_website_index].sticky_url;
        // $('.thrid_party_website_share_url').val(STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+third_party_webiste_hash);
        $('.thrid_party_website_share_url').val(third_party_webiste_hash);
        $('.thrid_party_website_share_url').attr("data-domain-url",STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+third_party_webiste_hash);
        $('.thrid_party_website_share_url').attr("data-sticky-url",third_party_webiste_sticky_url);
        owl_refresh(400);
    });

    $('body').on('click' , '#another-url-sticky-bar' ,function(){
        $("#another-url-sticky-bar").addClass('hide-another');
        $(".third-party__another-modal").addClass('show-another');
        $(".third-party__step").addClass('hide-another');
        $("#another_cta_url").val('');
        $("#another_cta_url").focus();
        owl_refresh(400);
    });

    $('body').on('click' , '#new-url-sticky-bar' ,function(){
        if($("#cta_url").val() == null || $("#cta_url").val() == ""  ){
            if(!$('#cta_url').hasClass("error")){
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
                $("#cta_url").addClass("error");
                $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please add your Sticky Bar website URL.</label>');
                owl_refresh(400);
            }
            return false;
        }
        if($("#cta_url").hasClass('error')){
            return false;
        }
        $(".step-1--normal").addClass('hide-another');
        $(".step-1--normal").removeClass('show-another');
        $(".step-1--third-party").addClass('show-another');
        $(".step-1--third-party").removeClass('hide-another');
        $("#new_cta_url").val('');
        $("#new_cta_url").focus();
        $("#prev-sticky-bar").show();
        owl_refresh(400);
    });

    $('body').on('click' , '.lp-sticky-bar__input-right-icon' ,function(){
        if(setting.third_party_website_flag == 1){
            var urlcopy = $('.thrid_party_website_share_url').attr("data-domain-url");
            var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
            urlcopy = urlcopy+"~"+sticky_url;
            urlcopy = urlcopy.replace(/['"]/,"");
            $(this).attr("href",urlcopy);
        }else{
            $(this).attr("href","http://"+c_data_obj.domain_name);
        }
    });

    $('body').on('click' , '.share-link__copy' ,function(){
        var sticky_url = $(this).parents('.lp-sticky-bar__share-wrap').attr("data-sticky-url");
        var sticky_hash = $(this).parents('.lp-sticky-bar__share-wrap').attr("data-sticky-hash");
        var  copytext = STICKY_BAR_THIRD_PARTY_DOMAIN+"/"+sticky_hash+"~"+sticky_url;
        copytext = copytext.replace(/['"]/,"");
        copyTextToClipboard(copytext);
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Sticky Bar has been copied.' +
            '</div>';
        $(html).hide().appendTo(".msg").slideDown(700).delay(1500).slideUp(700 , function(){
            $(this).remove();
        });
    });

    $(".color-box__btn-none").click(function (){
        setting.update_form = true;
        $(".color-overlay").css('background-color','transparent');
        $(".cta_background_color-overlay").fadeOut();
        $(".sticky-bar-code-overlay").text("None");
        $("#cta_background_color-overlay").addClass("color-box__none");
    });

    // sticky bar background color
    $(document).click(function(e) {
        $(".color-box__panel-wrapper").hide();
    });

    $(".color-box__panel-wrapper").click(function (e) {
        e.stopPropagation();
    });

    $("#cta_background_color").click(function () {
        event.stopPropagation();
        $(this).toggleClass('open');
        $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
        var notthis = $(".color-box__panel-wrapper.cta_background_color");
        $(".color-box__panel-wrapper").not(notthis).fadeOut();
        $(".color-box__panel-wrapper.cta_background_color").fadeToggle();
        var postion = $(this).offset();
        $(".color-box__panel-wrapper.cta_background_color").offset({top:postion.top+47, left:postion.left+1});

    });

    $("#cta_color").click(function () {
        event.stopPropagation();
        var window_height = $(window).height();
        var select_button = $(this).offset();
        var select_dropdown = $('.color-box__panel-wrapper').height();
        var select_total = select_button.top + select_dropdown;
        $(this).toggleClass('open');
        $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
        var notthis = $(".color-box__panel-wrapper.cta-text-Color");
        $(".color-box__panel-wrapper").not(notthis).fadeOut();
        $(".color-box__panel-wrapper.cta-text-Color").fadeToggle();
        if(window_height < select_total){
            $('.color-box__panel-wrapper').addClass("shadow-none");
            $(".color-box__panel-wrapper.cta-text-Color").offset({top:select_button.top-select_dropdown-22, left:select_button.left+1});
        }
        else {
            $('.color-box__panel-wrapper').removeClass("shadow-none");
            $(".color-box__panel-wrapper.cta-text-Color").offset({top:select_button.top+47, left:select_button.left+1});
        }
    });

    $("#cta_btn_background_color").click(function () {
        event.stopPropagation();
        var window_height = $(window).height();
        var select_button = $(this).offset();
        var select_dropdown = $('.color-box__panel-wrapper').height();
        var select_total = select_button.top + select_dropdown;
        $(this).toggleClass('open');
        $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
        var notthis = $(".color-box__panel-wrapper.cta_btn_background_color");
        $(".color-box__panel-wrapper").not(notthis).fadeOut();
        $(".color-box__panel-wrapper.cta_btn_background_color").fadeToggle();
        if(window_height < select_total){
            $('.color-box__panel-wrapper').addClass("shadow-none");
            $(".color-box__panel-wrapper.cta_btn_background_color").offset({top:select_button.top-select_dropdown-22, left:select_button.left+1});
        }
        else {
            $('.color-box__panel-wrapper').removeClass("shadow-none");
            $(".color-box__panel-wrapper.cta_btn_background_color").offset({top:select_button.top+47, left:select_button.left+1});
        }
    });

    $("#cta_btn_color").click(function () {
        event.stopPropagation();
        var window_height = $(window).height();
        var select_button = $(this).offset();
        var select_dropdown = $('.color-box__panel-wrapper').height();
        var select_total = select_button.top + select_dropdown;
        $(this).toggleClass('open');
        $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
        var notthis = $(".color-box__panel-wrapper.cta_btn_color");
        $(".color-box__panel-wrapper").not(notthis).fadeOut();
        $(".color-box__panel-wrapper.cta_btn_color").fadeToggle();
        if(window_height < select_total){
            $('.color-box__panel-wrapper').addClass("shadow-none");
            $(".color-box__panel-wrapper.cta_btn_color").offset({top:select_button.top-select_dropdown-23, left:select_button.left+1});
        }
        else {
            $('.color-box__panel-wrapper').removeClass("shadow-none");
            $(".color-box__panel-wrapper.cta_btn_color").offset({top:select_button.top+47, left:select_button.left+1});
        }
    });

    $("#cta_background_color-overlay").click(function () {
        event.stopPropagation();
        var window_height = $(window).height();
        var select_button = $(this).offset();
        var select_dropdown = $('.color-box__panel-wrapper.cta_background_color-overlay').height();
        var select_total = select_button.top + select_dropdown;
        $(this).toggleClass('open');
        $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
        var notthis = $(".color-box__panel-wrapper.cta_background_color-overlay");
        $(".color-box__panel-wrapper").not(notthis).fadeOut();
        $(".color-box__panel-wrapper.cta_background_color-overlay").fadeToggle();
        if(window_height < select_total){
            $('.color-box__panel-wrapper').addClass("shadow-none");
            $(".color-box__panel-wrapper.cta_background_color-overlay").offset({top:select_button.top-select_dropdown-23, left:select_button.left+1});
        }
        else {
            $('.color-box__panel-wrapper').removeClass("shadow-none");
            $(".color-box__panel-wrapper.cta_background_color-overlay").offset({top:select_button.top+47, left:select_button.left+1});
        }
    });

    $(".lp-sticky-bar__edit-url").click(function () {
        var input_condtion = $("input.thrid_party_website_share_url");
        $(this).hide();
        $(".lp-sticky-bar__copy-url").hide();
        setting.old_slug = $(".thrid_party_website_share_url").val();
        $(".lp-sticky-bar__edit-url-option").css('display','flex');
        $(input_condtion).prop("disabled", false );
        $(input_condtion).css('padding-right','148px');
        $(input_condtion).select();
    });

    $(".lp-sticky-bar__copy-url").click(function () {
        if(setting.third_party_website_flag == 1){
            var urlcopy = $('.thrid_party_website_share_url').attr("data-domain-url");
            urlcopy = urlcopy.replace(/['"]/,"");
            copyTextToClipboard(urlcopy);
        }else{
            copyTextToClipboard(c_data_obj.domain_name);
        }
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Your share link has been copied.' +
            '</div>';
        $(html).hide().appendTo(".msg").slideDown(500,function(){
            $(".lp-sticky-bar__copy-url").css("pointer-events","none")}).delay(1000).slideUp(500 , function(){
            $(".lp-sticky-bar__copy-url").css("pointer-events","auto");
            $(this).remove();
        });
    });

    $(".lp-sticky-bar__edit-cancel").click(function () {
        var input_condtion = $("input.thrid_party_website_share_url");
        $(input_condtion).prop( "disabled", true );
        $(input_condtion).css('padding-right','90px');
        $(".thrid_party_website_share_url").val(setting.old_slug);
        $(".lp-sticky-bar__edit-url-option").hide();
        $(".lp-sticky-bar__edit-url").show();
        $(".lp-sticky-bar__copy-url").show();
    });

    $("#cta_title_phone_number").blur(function () {
        setting.update_form=true;
    });

    $('#funnel_check').click(function () {
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideDown();
        if($('.ctalink').hasClass("hide")){
            $('.ctalink').show();
            $('.ctalink').removeClass("hide");
        }
        $(".no-button").css("padding-bottom","22px");
        owl_refresh(400);
    });

    $('#url_check').click(function () {
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.url_case-check').slideDown();
        if($('.ctalink').hasClass("hide")){
            $('.ctalink').show();
            $('.ctalink').removeClass("hide");
        }
        $(".no-button").css("padding-bottom","22px");
        $('.funnel_case-check').slideUp();
        owl_refresh(400);
    });

    $('#no_button').click(function () {
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.url_case-check').slideUp();
        $('.funnel_case-check').slideUp();
        $('.ctalink').hide();
        $('.ctalink').addClass("hide");
        $(".no-button").css("padding-bottom","0");
        owl_refresh(400);
    });

    $('#close_sticky').click(function () {
        $('.lp-sticky-bar__form-group_phone-number').slideUp();
        $('.url_case-check').slideUp();
        if($('.ctalink').hasClass("hide")){
            $('.ctalink').show();
            $('.ctalink').removeClass("hide");
        }
        $('.funnel_case-check').slideUp();
        $(".no-button").css("padding-bottom","0");
        owl_refresh(400);
    });

    $('#call_text_check').click(function() {
        setting.update_form=true;
        if($(this).is(':checked')){
            $("#cta_title_phone_number").inputmask({"mask": "(999) 999-9999"});
            var phonenumber = $("#cta_title_phone_number").val();
            $('.lp-sticky-bar__form-group_phone-number').slideDown();
            $('.url_case-check').slideUp();
            $('.funnel_case-check').slideUp();
            if($('.ctalink').hasClass("hide")){
                $('.ctalink').show();
                $('.ctalink').removeClass("hide");
            }
            $(".no-button").css("padding-bottom","22px");
            // $('.lp-sticky-bar__form-group_phone-number').addClass('lp-sticky-bar__form-group_phone-number_show');
            owl_refresh(400);
        }
        else {
            $('.lp-sticky-bar__form-group_phone-number').slideUp(function () {
                // $('.lp-sticky-bar__form-group_phone-number').removeClass('lp-sticky-bar__form-group_phone-number_show');
            });
            owl_refresh(400);
        }
    });

    $('.sorting').click(function(){
        $(".lp-original__link-block").hide();
        var sort = $(this).attr('data-sort');
        var type = $(this).attr('data-type');
        if(sort == 'asc') {
            $(this).attr('data-sort','desc');
            $(".sorting").not(this).removeAttr("data-sort");
        }else{
            $(this).attr('data-sort','asc');
            $(".sorting").not(this).removeAttr("data-sort");
        }
        c_data_obj.third_party_website[c_data_obj.sticky_id].sort(function(a, b) {
            if(type == 'url'){
                a = a.sticky_url.toLowerCase();
                b = b.sticky_url.toLowerCase();
            }else if(type == 'date'){
                a = new Date(a.created_date);
                b = new Date(b.created_date);
            } else{
                a = parseInt(a.clicks);
                b = parseInt(b.clicks);
            }
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
        specific_3rd_party_url_render(c_data_obj);
    });

    $('#advance-option-toggle').click(function (event) {
        event.preventDefault();
        $('.advance-option-box').slideToggle();
        $(this).find('i').toggleClass('rotate-icon');
        owl_refresh(400);
    });

    if($('#s-url').length > 0){
        setting.url_arr = $.parseJSON($('#s-url').val());
    }

    if(setting.url_arr[$('#cta_url')] != undefined && radio_status != '') {
        $('#duplicate_url').val('1');
    }

    $('[name="cta_icon"]').click(function(){
        if($(this).val() == 0){
            $('.sticky-hide').hide();
        }else{
            $('.sticky-hide').show();
        }
    });

    //step 3 start

    $('[name=lp-sticky-bar__full-page-checker]').click(function () {
        setting.update_form = true;
        if(c_data_obj.logo_image_replacement == "top"){
            if(setting.logo_bottom_spacing  == '0'){
                setting.logo_bottom_spacing = c_data_obj.logo_spacing;
            }
        }else{
           if(setting.logo_left_spacing  == '0'){
                setting.logo_left_spacing = c_data_obj.logo_spacing;
           }
        }
        if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page")){
            $(".lp-sticky-bar__wrapper").removeClass("lp-sticky-bar__full-page");
            setTimeout(function(){
                var result = $(window).innerHeight();
                var lp_stickbar_header = $(".leadpops-wrap").innerHeight();
                var height = result-lp_stickbar_header;
                $('.lp-sticky-bar__outer').css({'height':height});
                owl.trigger('refresh.owl.carousel');
            },10);
            setting.full_page_sticky_bar_flag = "off"
            if(setting.third_party_website_flag == 0){
                $(".defaultpage__status").show();
                $(".fullpage__status").hide();
            }else if(setting.third_party_website_flag == 2){
                $(".defaultpage__status").hide();
                $(".fullpage__status").hide();
            }
            if($(".lp-sticky-bar__wrapper").hasClass("cta__logo-above") == true){
                $(".cta__logo").css("left","");
                $(".cta__logo").css("bottom","-"+setting.logo_bottom_spacing+"px");
            }else{
                $(".cta__logo").css("bottom","");
                $(".cta__logo").css("left","-"+setting.logo_left_spacing+"px");
            }
        }
        else {
            $(".lp-sticky-bar__wrapper").addClass("lp-sticky-bar__full-page");
            setting.full_page_sticky_bar_flag = "on";
            setTimeout(function(){
                var window_h = $(window).height();
                $('.lp-sticky-bar__outer').css({'height':window_h});
                owl.trigger('refresh.owl.carousel');
            },10);
            if(setting.third_party_website_flag == 0){
                $(".defaultpage__status").hide();
                $(".fullpage__status").show();
            }else if(setting.third_party_website_flag == 2){
                $(".defaultpage__status").hide();
                $(".fullpage__status").hide();
            }

            if($(".lp-sticky-bar__wrapper").hasClass("cta__logo-above") == true){
                $(".cta__logo").css("left","");
                $(".cta__logo").css("bottom",setting.logo_bottom_spacing+"px");
            }else{
                $(".cta__logo").css("bottom","");
                $(".cta__logo").css("left","-"+setting.logo_left_spacing+"px");
            }
        }
    });

    $("#lp-sticky-bar__hide-checker").click(function () {
        if(setting.hide_animation == 0 ||  setting.hide_animation == null){
            setting.hide_animation = 1;
        }else {
            setting.hide_animation = 0;
        }
        setting.update_form = true;
        $(".lp-sticky-bar__when-hide-wrapper").slideToggle();
        $('.sticky-hide').toggle();
        owl_refresh(400);
    });

    $('#sticky-bar__how-big').change(function () {
        if(setting.sticky_bar_update_flag == 1){
            setting.update_form = true;
        }
        var  ratio =     $(this).val();
        if(parseInt($(".ctalink").height() + 20) < $(".leadpops-wrap").height()){
            var padding= 20;
            $('.leadpops-wrap').css({'min-height':ratio+"px","height":ratio+"px"});
            var result = $(window).innerHeight();
            var lp_stickbar_header = $(".leadpops-wrap").innerHeight();
            var height = result-lp_stickbar_header;
            $('.lp-sticky-bar__outer').css({'height':height});
            owl.trigger('refresh.owl.carousel');
            if($(".cta__logo").height() > parseInt( $(this).val()-30)){
                logopresize($(".cta__logo") ,parseInt( $(this).val()-30), parseInt( $(this).val()-30));
                $("#dropzone-logo-size").bootstrapSlider('setValue', $(".cta__logo").height(),true);

            }

        }else if(parseInt($(".ctalink").height() + 20) < ratio){
            var padding= 20;
            $('.leadpops-wrap').css({'min-height':ratio+"px","height":ratio+"px"});
            var result = $(window).innerHeight();
            var lp_stickbar_header = $(".leadpops-wrap").innerHeight();
            var height = result-lp_stickbar_header;
            if($(".cta__logo").height() < parseInt( $(this).val()-30)){
                logopresize($(".cta__logo") ,parseInt( $(this).val()-30), parseInt( $(this).val()-30));
                $("#dropzone-logo-size").bootstrapSlider('setValue', $(".cta__logo").height(),true);
            }
            $('.lp-sticky-bar__outer').css({'height':height});
            owl.trigger('refresh.owl.carousel');
        }
    });
    $('[name="where_button_goes"]').click(function () {
        setting.update_form = true;
    });

    $('#outside_url').keyup(function () {
        setting.update_form = true;
    });

    $('#outside_url').blur(function () {
        $(this).val($(this).val().replace(/\/$/, ''));
    });

    $('.lp-sticky-bar__when-hide-select').change(function () {
        if(setting.sticky_bar_update_flag == 1) {
            setting.update_form = true;
        }
        setting.when_to_hide = $(".lp-sticky-bar__when-hide-select").val();
    });

    // $('.zindex-dropdown__want-display').click(function () {
    //     setting.temp=1;
    // });

    $('.select__want-display').change(function () {
        if(setting.sticky_bar_update_flag == 1){
            setting.update_form = true;
        }
        setting.when_to_display  =  $(".select__want-display").val();
    });

    $('.select__want-placed').change(function () {
        if(setting.sticky_bar_update_flag == 1){
            setting.update_form = true;
        }
        setting.advance_sticky_location  =  $(".select__want-placed").val();
        if(setting.advance_sticky_location == 'stick-at-top' || setting.advance_sticky_location == 'top-disappear-on-scroll') {
            $("#pin_flag_top").prop('checked' , true);
            $('.leadpops-wrap').removeClass('sticky-position-bottom');
        }else{
            $("#pin_flag_bottom").prop('checked' , true);
            $('.leadpops-wrap').addClass('sticky-position-bottom');
        }
    });

    $('.select__want-animation').change(function () {
        if(setting.sticky_bar_update_flag == 1) {
            setting.update_form = true;
        }
        setting.cta_btn_animation = $(".select__want-animation").val();
    });

    //step 3 end
    // step 4 start

    $(".lp-sticky-bar__dropzone-tabs li > a").click(function () {
        owl_refresh(400);
    });

    $("#dropzone__logo-remove").click(function () {
        setting.update_form = true;
        $('.cta__logo').removeAttr("style");
        $(".dropzone__logo-image img").remove();
        $(".dropzone__logo-image").css("pointer-events","auto");
        $('.cta__logo').attr("src", "");
        $(".dropzone__logo-image").removeClass("dz-started");
        $(".dz-message").first().css("display","block");
        $("#logo-image .dropzone__wrapper").removeClass("dropzone__wrapper_after-added");
        $(".dropzone__control-wrapper_logo").slideUp();
        $(".lp-sticky-bar__wrapper").removeClass("logo-added");
        setting.logo_image_removed_flag = 1;
        setting.logo_image_added_flag = 0;
        c_data_obj.logo_image_replacement = 'left';
        c_data_obj.logo_image_size = 100;
        $("#dropzone__logo-image").removeClass("dropzone-error");
        $('.logo-error').remove();
        setTimeout(function(){
            owl.trigger('refresh.owl.carousel');
        },400);
    });

    $("#dropzone__background-remove").click(function () {
        setting.update_form = true;
        $('.leadpops-wrap').removeClass("has_background_image");
        $(".dropzone__background-image .background-preview").remove();
        $(".dropzone__background-image ").css("pointer-events","auto");
        $('.leadpops-wrap').css("background-image", "");
        $(".dropzone__background-image").removeClass("dz-started");
        $(".dz-message").last().css("display","block");
        $(".color-overlay").css("background-color","");
        $("#background-image .dropzone__wrapper").removeClass("dropzone__wrapper_after-added");
        $(".dropzone__control-wrapper_background").slideUp();
        c_data_obj.background_image_opacity = 0.60;
        c_data_obj.background_image_color_overlay = '00aef0';
        c_data_obj.background_image_size = 100;
        setting.background_image_removed_flag =1;
        setting.background_image_added_flag= 0;
        $("#dropzone__background-image").removeClass("dropzone-error");
        $('.bg-error').remove();
        owl_refresh(400);
    });

    // step 4 end

    $(".lp_instruction_box" ).on('click', function(){
        $('#instruction-modal').modal('show');
    });

    $(".stickyBarVideo" ).on('click', function(){
        $('#stickyBarVideo-modal').modal('show');
    });

    //    switch script tag

    $('#switch-script').change(function (e) {
        var hash = c_data_obj.sticky_js_file;
        $('.code-switch__caption').text('View Code without Script Tags');
        var val = 'a';
        if($(this).prop('checked')){
            $('.code-switch__caption').text('View Code without Script Tags'); //with
            val = 'f';
        }
        $('#sticky_script_type').val(val);
        c_data_obj.script_type = val;
        var file_name = 'https://dev2itclix.com/' +hash+".js";
        $('.lp-sticky-bar__loader').show();
        current_data_obj();
        $.ajax({
            type : "POST",
            url : "/lp/popadmin/updatestickycodetypev2",
            data :c_data_obj,
            datatype : 'json',
            success : function(data) {
                var obj = $.parseJSON(data);
                $('.lp-sticky-bar__loader').hide();
                if(obj.status == 'success'){
                    alert_message(obj.message);
                    c_data_obj.url_flag = "";
                    generate_code(file_name , val);
                }else{
                    alert_message(obj.message);
                    $('#switch-script').prop('checked' , false);
                }
            },
            cache : false,
            async : false
        });
    });

    $('.lp-sticky-bar__video').click(function () {
        $('#lp-video-modal').modal('show');
    });

    $('#close-video-modal').click(function(){
        $(this).modal('hide');
    });

    $('#lp-video-modal').on('hidden.bs.modal', function (e) {
        $('body').addClass('modal-open');
    });

    var value = 0;
    $('.lp-sticky-bar__toggle').click(function(e){
        e.stopPropagation();

        setting.active_flag = true;

        $("#sticky-bar-form").submit();
    });

    var owl = $('.owl-carousel');
    $(".sticky-bar-btn").click(function (e) {
        e.stopPropagation();
        var _this = $(this);
        showstickybarpopup(_this);
    });

    $(".sticky-bar-menu-link").click(function (e) {
        e.stopPropagation();
        var _this = $(this);
        showstickybarpopup(_this);
    });

    $('#another_cta_url').blur(function(){
        setting.update_form = true;
    });

    $('#new_cta_url').blur(function(){
        setting.update_form = true;
        is_website_support_iframe($(this).val());
    });

    $("#next-onther-sticky-bar").click(function () {
        if($('#another_cta_url').val() == ""){
            if(!$('#another_cta_url').hasClass("error")){
                $("#another_cta_url").removeClass("error");
                $("#another_cta_url-error").remove();
                $("#another_cta_url").addClass("error");
                $('#another_cta_url').after('<label id="another_cta_url-error" class="error" for="another_cta_url">Please enter a URL.</label>');
            }
            return;
        }else{
            $("#another_cta_url").removeClass("error");
            $("#another_cta_url-error").remove();
        }
        var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
        var url = $("#another_cta_url").val();
        if(url.match(regex) == null){
            if(!$("#another_cta_url").hasClass("error")) {
                $("#another_cta_url").removeClass("error");
                $("#another_cta_url-error").remove();
                $("#another_cta_url").addClass("error");
                $('#another_cta_url').after('<label id="another_cta_url-error" class="error" for="another_cta_url">Please enter a valid URL.</label>');
                owl_refresh(400);
            }
            return false;
        }else {
            $("#another_cta_url").removeClass("error");
            $("#another_cta_url-error").remove();
            owl_refresh(400);
        }
        current_data_obj();
        var another_third_party_cta_url = $('#another_cta_url').val();
        c_data_obj.sticky_url = another_third_party_cta_url;
        if(setting.update_form == true && !$('#another_cta_url').hasClass("error")){
            is_website_support_iframe(another_third_party_cta_url);
            $('.lp-sticky-bar__loader').show();
            $.ajax({
                type : "POST",
                url : "/lp/popadmin/savestickybarv2",
                data : c_data_obj,
                dataType: 'json',
                error: function(data){
                    $('.lp-sticky-bar__loader').hide();
                    alert_message(data.message, 'danger');
                },
                success : function(data) {
                    var obj = data;
                    if(obj.section == 'false'){
                        location.reload();
                    }else{
                        if(obj.status == 'success'){
                            var obj1 = JSON.parse(obj.sticky);
                            c_data_obj.sticky_id =obj1.sticky_id;
                            c_data_obj = obj1;
                            setting.insert_flag = $('#insert_flag').val(obj.hash);
                            setting.token = obj.hash;
                            var file_name = 'https://dev2itclix.com/' + obj.hah+".js";
                            var type = c_data_obj.script_type;
                            generate_code(file_name , type);
                            update_attributes(obj);
                            setactiveinactiveflag(obj);
                            specific_3rd_party_url_render(c_data_obj);
                            set_defeult_steps ();
                            set_obj_after_ajax ();
                            data_rander_after_ajax ();
                            setting.third_party_index = "";
                            owl_refresh(400);
                            $('#prev-sticky-bar').show();
                            c_data_obj.another_cta_url = "";
                            setting.update_form = false;
                            $("#another_cta_url").val('');
                            $('.lp-sticky-bar__loader').hide();
                            alert_message("New link has been added.");
                            var radio_status = $('.sticky-radio:checked').val();
                            // var domain_specific_arr = setting.url_arr[obj.sticky.sticky_url];
                            if(setting.inactive_funnel_url != ''  && radio_status != ''){ // change the previous funnel status
                                // $('[data-sticky_url="'+obj.sticky.sticky_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').attr('data-sticky_status' , '0');
                                // $('[data-sticky_url="'+obj.sticky.sticky_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').find('.funnel-sticky-status').text('(Inactive)');
                                // $('[data-sticky_funnel_url="'+setting.inactive_funnel_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').find('.funnel-sticky-status').text('(Inactive)');
                                // console.info('[data-sticky_funnel_url="'+setting.url_arr[obj.sticky.sticky_url]+'"]');
                            }

                        }else{
                            $('.lp-sticky-bar__loader').hide();
                            alert_message(obj.message , 'danger');
                        }
                    }
                },
                cache : false,
                async : false
            });
        }

    });
    $("#next-new-sticky-bar").click(function () {
        if($('#new_cta_url').val() == ""){
            if(!$('#new_cta_url').hasClass("error")){
                $("#new_cta_url").removeClass("error");
                $("#new_cta_url-error").remove();
                $("#new_cta_url").addClass("error");
                $('#new_cta_url').after('<label id="new_cta_url-error" class="error" for="new_cta_url">Please enter a URL.</label>');
            }
            return;
        }else{
            $("#new_cta_url").removeClass("error");
            $("#new_cta_url-error").remove();
        }
        var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
        var url = $("#new_cta_url").val();
        if(url.match(regex) == null){
            if(!$("#new_cta_url").hasClass("error")) {
                $("#new_cta_url").removeClass("error");
                $("#new_cta_url-error").remove();
                $("#new_cta_url").addClass("error");
                $('#new_cta_url').after('<label id="new_cta_url-error" class="error" for="new_cta_url">Please enter a valid URL.</label>');
                owl_refresh(400);
            }
            return false;
        }else {
            $("#new_cta_url").removeClass("error");
            $("#new_cta_url-error").remove();
            owl_refresh(400);
        }
        current_data_obj();
        var another_third_party_cta_url = $('#new_cta_url').val();
        c_data_obj.sticky_url = another_third_party_cta_url;
        if(setting.update_form == true && !$('#new_cta_url').hasClass("error")){
            $('.lp-sticky-bar__loader').show();
            is_website_support_iframe(another_third_party_cta_url);
            $.ajax({
                type : "POST",
                url : "/lp/popadmin/savestickybarv2",
                data : c_data_obj,
                dataType: 'json',
                error: function(data){
                    $('.lp-sticky-bar__loader').hide();
                    alert_message(data.message, 'danger');
                },
                success : function(data) {
                    var obj = data;
                    if(obj.section == 'false'){
                        location.reload();
                    }else{
                        if(obj.status == 'success'){
                            var obj1 = JSON.parse(obj.sticky);
                            c_data_obj.sticky_id =obj1.sticky_id;
                            c_data_obj = obj1;
                            setting.insert_flag = $('#insert_flag').val(obj.hash);
                            setting.token = obj.hash;
                            var file_name = 'https://dev2itclix.com/' + obj.hah+".js";
                            // var type = $(setting.element_id).attr("data-sticky_script_type");
                            var type = c_data_obj.script_type;
                            generate_code(file_name , type);
                            update_attributes(obj);
                            setactiveinactiveflag(obj);
                            specific_3rd_party_url_render(c_data_obj);
                            set_defeult_steps ();
                            set_obj_after_ajax ();
                            data_rander_after_ajax ();
                            setting.third_party_index = "";
                            owl_refresh(400);
                            $('#prev-sticky-bar').show();
                            c_data_obj.another_cta_url = "";
                            setting.update_form = false;
                            $("#new_cta_url").val('');
                            $('.lp-sticky-bar__loader').hide();
                            alert_message("New link has been added.");
                            var radio_status = $('.sticky-radio:checked').val();

                        }else{
                            $('.lp-sticky-bar__loader').hide();
                            alert_message(obj.message , 'danger');
                        }
                    }
                },
                cache : false,
                async : false
            });
        }
    });

    $("#close-sticky-bar").click(function () {
        setting.cta_text_html  = '<p style="font-size: 30px; color: #ffffff;" >I am your sticky bar and i am being awesome!</p>';
        setting.cta_btn_text_html = '<p style="font-size: 26px; color: #ffffff;" >Lets do it!</p>';
        setting.cta_btn_vertical_padding = "20px";
        setting.cta_btn_horizontal_padding ="53px";
        setting.sticky_url = "";
        setting.third_party_index = "";
        setting.website_change = 0;
        closestickypopup();
        hideUrlNotice();
        $('.cta__logo').removeAttr("style");
        $(".dropzone").remove();
        owl.trigger('to.owl.carousel', [0, 300]);
        $('.advance-option-box').hide();
        $('#advance-option-toggle').find('.fa').removeClass('rotate-icon');
        var validator = $( "#sticky-bar-form" ).validate();
        validator.resetForm();
        $(".step-1--third-party").removeClass("show-another");
        $(".step-1--third-party").addClass("hide-another");
        $(".step-1--normal").removeClass("hide-another");
        $( "#sticky-bar-form input").removeClass('error');
        clearForm('#sticky-bar-form');
        $('.lp-sticky-bar__modal').css({
            'opacity': '0'
        });
        $('body').css({'overflow':'unset'});
        $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').remove();
        $('#all_pages').prop('checked' , true);
        $(".lp__url-path").hide();
        setting.update_form = false;
    });

    $('.sticky-tooltip-body').tooltip({
        template: '<div class="tooltip show_full-url"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
    });

    $('.sticky-tooltip').tooltip();
    owl.owlCarousel({
        items: 1,
        loop: false,
        autoHeight:true,
        pause: "true",
        touchDrag: false,
        mouseDrag: false,
    });

    owl.on('changed.owl.carousel', function(event) {
        $('.lp-sticky-bar__modal').css({
            'opacity': '1',
            'transition':'all 0.6s ease'
        });
        $('.lp-owl-dot').removeClass( 'active' );
        $('.lp-owl-dot').eq(event.item.index).addClass('active');
        var ln = ($('.owl-item').length)-1;
        $('#continue-sticky-bar').show();
        $('#copy-sticky-bar').hide();
        $(".third-party__another-modal").hide();
        $("#another-url-sticky-bar").hide();
        if(event.item.index == ln){
            $('#continue-sticky-bar').hide();
            $('#copy-sticky-bar').focus();
        }
        if(event.item.index == 4){
            if (setting.third_party_website_flag == 2){
                $(".third-party__step").hide();
                $("#another-url-sticky-bar").hide();
                $(".lp-sticky-bar__own-page-website").hide();
                $(".funnel__step").show()
                $('#continue-sticky-bar').hide();
                $('#copy-sticky-bar').hide();
                $("#another-url-sticky-bar").hide();
                $('#continue-sticky-bar').hide();
                $('#copy-sticky-bar').hide();
            }
            else if(setting.third_party_website_flag == 1){
                $("#prev-sticky-bar").show();
                $(".third-party__step").show();
                $(".funnel__step").hide();
                $("#another-url-sticky-bar").show();
                // $(".slug__url-text").hide();
                $(".lp-sticky-bar__own-page-website").hide();
                $('#continue-sticky-bar').hide();
                $(".lp-sticky-bar__own-page-website").hide();
                $('#copy-sticky-bar').hide();
            }else {
                $(".third-party__step").hide();
                $("#another-url-sticky-bar").hide();
                $(".lp-sticky-bar__own-page-website").show();
                $('#continue-sticky-bar').hide();
                $(".funnel__step").hide();
                $('#copy-sticky-bar').show();
            }

            owl_refresh(400);

        }else{
        }
        if(event.item.index == 0){
            if(setting.third_party_website_flag == 1 && $(".step-1--normal").hasClass('hide-another')){
                $("#prev-sticky-bar").show();
                $('#prev-sticky-p-sticky-bar_clone db_savebar').hide();
                $("#another-url-sticky-bar").removeClass('hide-another');
                $(".third-party__another-modal").removeClass('show-another');
                $(".third-party__step").removeClass('hide-another');
            }else {
                $("#prev-sticky-bar").hide();
                $('#prev-sticky-p-sticky-bar_clone db_savebar').hide();
                $("#another-url-sticky-bar").removeClass('hide-another');
                $(".third-party__another-modal").removeClass('show-another');
                $(".third-party__step").removeClass('hide-another');
                $(".step-1--normal").removeClass('hide-another');
                $(".step-1--normal").addClass('show-another');
                $(".step-1--third-party").removeClass('show-another');
                $(".step-1--third-party").addClass('hide-another');
            }
        }
    });

    $('#prev-sticky-bar').click(function() {
        if(setting.third_party_website_flag == 1 && $(".step-1--normal").hasClass('hide-another')) {
            $(".step-1--normal").removeClass('hide-another');
            $(".step-1--normal").addClass('show-another');
            $(".step-1--third-party").removeClass('show-another');
            $(".step-1--third-party").addClass('hide-another');
            owl_refresh(400);
        }else{
            owl.trigger('prev.owl.carousel', [300]);
        }
    });

    $(document).click(function(event) {
        // console.info(event.target.class);
        if (!(event.target.class === 'lp-owl-dot')) {
            // console.info(setting.owl_index);
            setting.owl_index = '';
        }
    });

    $( '.lp-owl-dot').on( 'click', function(event) {
        $(".color-box__panel-wrapper").hide();
        if(setting.third_party_website_flag != 2){
            if(($("#cta_url").val() == "" || $("#cta_url").val() == "example.com") && $(".zindex-adding-stickybar").val() != 2){
                $("#cta_url").focus();
                if(!$("#cta_url").hasClass("error")){
                    $("#cta_url").removeClass("error");
                    $("#cta_url-error").remove();
                    $("#cta_url").addClass("error");
                    if($("#cta_url").val() == ""){
                        $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please add your Sticky Bar website URL.</label>');
                    }else{
                        $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please change the "example" domain.</label>');
                    }
                }
                return false;
            }else{
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
            }
            var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
            var url = $("#cta_url").val();
            if(url.match(regex) == null){
                $("#cta_url").focus();
                if(!$("#cta_url").hasClass("error") && $(".zindex-adding-stickybar").val() != 2) {
                    $("#cta_url").removeClass("error");
                    $("#cta_url-error").remove();
                    $("#cta_url").addClass("error");
                    $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please enter a valid URL.</label>');
                    owl_refresh(400);
                }
                return false;
            }else {
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
                owl_refresh(400);
            }
        }
        if($("#dropzone__logo-image").hasClass("dropzone-error")){
            return false;
        }
        if($("#cta_url").val() != ""){
            if($("#cta_url").hasClass("error")){
                return false;
            }
        }
        if($("#dropzone__logo-image").hasClass("dropzone-error")){
            return false;
        }
        if($("#dropzone__background-image").hasClass("dropzone-error")){
            return false;
        }


        if($(this).hasClass('disabled')){
            return;
        }
        setting.active_flag = false;
        if(setting.update_form != true) {
            $file_name='';
            if(setting.token != ''){
                $file_name = 'https://dev2itclix.com/' + setting.token + '.js';
            }
            // var lp_script_type = $(setting.element_id).attr('data-sticky_script_type');
            c_data_obj = getActiveElementObj();
            var lp_script_type = c_data_obj.script_type;
            generate_code($file_name, lp_script_type);
            owl.trigger('to.owl.carousel', [$(this).index(), 300]);
            $('.owl-dot').removeClass('active');
            $(this).addClass('active');
            if ($(this).index() == 0) {
                $('#prev-sticky-bar').hide();
            } else {
                $('#prev-sticky-bar').show();
            }
        }else{
            $("#sticky-bar-form").submit();
        }

        setting.owl_index = $(this).index();
        // console.info(setting.owl_index);
        event.stopPropagation();
    });

    $( ".bar_title" ).keyup(function() {
        setting.update_form = true;
        $('.lp_froala__sticky-bar-text .fr-element.fr-view > p').text($(this).val());
        $('.bar_title_hidden').val($(this).val());
        // process_input();
        $('.lp_froala__sticky-bar-text span.fr-placeholder').hide();

    });

    $('#cta_title').keyup(function(){
        setting.update_form = true;
        $('.lp_froala__sticky-bar-button .fr-element.fr-view > p').text($(this).val());
        $('.lp_froala__sticky-bar-button span.fr-placeholder').hide();
    });

    $('#cta_url').keyup(function(){
        setting.update_form = true;
    });

    $('#continue-sticky-bar').click(function(){
        setting.active_flag = false;
        hideUrlNotice();
        if($("#cta_url").hasClass('error') ){
            return false;
        }
        if(($("#cta_url").val() == null || $("#cta_url").val() == "") && $(".zindex-adding-stickybar").val() != 2){
            $("#cta_url").focus();
            if(!$("#cta_url").hasClass("error")) {
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
                $("#cta_url").addClass("error");
                $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please add your Sticky Bar website URL.</label>');
            }
            owl_refresh(400);
            return false;
        }else {
            $("#cta_url").removeClass("error");

            $("#cta_url-error").remove();
        }
        if($("#stickybar__pixel_code").val() != ""){
            if($("#stickybar__pixel_code").hasClass("error")){
                return false;
            }
        }
        if($("#dropzone__logo-image").hasClass("dropzone-error")){
            return false;
        }
        if($("#dropzone__background-image").hasClass("dropzone-error")){
            return false;

        }
        if($("#cta_url").val() != ""){
            if($("#cta_url").hasClass("error")){
                $("#cta_url").focus();
                return false;
            }
        }
        if(setting.update_form){
            $("#sticky-bar-form").submit();
        }else{
            owl.trigger('next.owl.carousel', [300]);
            $file_name = '';
            if(setting.token != ''){
                $file_name = 'https://dev2itclix.com/' + setting.token + '.js';
            }
            // var type = $(setting.element_id).attr("data-sticky_script_type");
            c_data_obj = getActiveElementObj();
            var type = c_data_obj.script_type;
            generate_code($file_name , type);
            $('#prev-sticky-bar').show();
        }

    });

    var $form = $("#sticky-bar-form"),
        $successMsg = $(".alert");
    $.validator.addMethod("equals", function(value, element) {
        return this.optional(element) || value.match('^((?!example).)*$');
    }, "change the domain name.");
    $.validator.addMethod("phonenumber_digits", function(value, element) {
        value = value.replace(/\_/g, '');
        var length= value.length;
        if($('#call_text_check').is(':checked')){
            if(length == 14)
            {
                return true;
            }
        }
    }, "Please enter a valid phone number.");
    $.validator.addMethod("cus_url", function(value, element) {

        if(value.substr(0,7) != 'http://' && value.substr(0,8) != 'https://'){
            value = 'http://' + value;
        }
        if(value.substr(value.length-1, 1) != '/'){
            value = value + '/';
        }
        owl_refresh(400);
        return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,7}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Not valid url.");
    $form.validate({
        rules: {
            another_cta_url: {
                cus_url: true
            },
            new_cta_url: {
                cus_url: true
            },
            cta_title_phone_number:{
                required: true,
                phonenumber_digits:true
            },
            outside_url:{
                required: true,
                cus_url:true
            },
            cta_url: {
                cus_url: true,
                equals: true
            },
            pages:{
                required: true
            }
        },
        messages: {
            cta_title_phone_number:{
                required: "Please enter your phone number.",
            },
            outside_url:{
                required: "Please enter a URL.",
                cus_url:"Please enter a valid URL."
            },
            cta_url: {
                cus_url: "Please enter a valid URL.",
                equals: 'Please change the "example" domain.'
            },
            another_cta_url: {
                cus_url: "Please enter a valid URL."
            },
            new_cta_url: {
                cus_url: "Please enter a valid URL."
            },
            pages: {
                required: "This field is required."
            }
        },
        submitHandler: function() {
            if(($("#cta_url").val() == "" || $("#cta_url").val() == null)&& $(".zindex-adding-stickybar").val() != 2){
                return false;
            }
            var old_url = '';
            if (c_data_obj.sticky_url == null) {
                c_data_obj.sticky_url = setting.sticky_url;
            }

            if (setting.active_flag) {
                var __this = $('#toggle-status');
                if (__this.prop('checked')) {
                    value = 0;
                    $('#sticky_status').val(value);
                    $('#toggle-status').bootstrapToggle('off')
                } else {
                    value = 1;
                    $('#sticky_status').val(value);
                    $('#toggle-status').bootstrapToggle('on')
                }
            }
            c_data_obj = getActiveElementObj();
            var old_url = c_data_obj.sticky_url;
            var new_url = $('#cta_url').val();
            if (old_url.toLowerCase() !== new_url.toLowerCase()) {
                c_data_obj.pending_flag = 0;
                $('#pending_flag').val(0);
            }
            if (setting.update_form == true) {
                current_data_obj();
               if(has_error == 0) {
                    $('.lp-sticky-bar__loader').show();
                    if ($(".zindex-adding-stickybar").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "/lp/popadmin/checkfunneldomainv2",
                            data: {'id': c_data_obj.sticky_id, 'domain': $("#cta_url").val(),'_token':ajax_token},
                            success: function (data) {
                                var obj = $.parseJSON(data);
                                if (obj.status == 'error') {
                                    setting.inactive_funnel_url = obj.funnel_url;
                                    var message = 'URL you are adding is already set up with funnel "' + obj.funnel_url + '".';
                                    var html = '<div class="alert alert-danger lp-sticky-bar__alert">\n' +
                                        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                                        '  <strong> Error! </strong>' + message +
                                        '</div>';
                                    $('#duplicate_url').val('1');
                                    $("#cta_url").addClass("error");
                                    $('#toggle-status').bootstrapToggle('off');
                                    $('.lp-sticky-bar__loader').hide();
                                    if (setting.lp_stop) {
                                        setting.lp_stop = false;
                                        c_data_obj.url_flag = "";
                                        $(html).hide().appendTo(".msg").slideDown(500).delay(50000).slideUp(500, function () {
                                            $(this).remove();
                                            setting.lp_stop = true;
                                        });
                                    }
                                    setting.update_form = false;
                                    has_error= 1;
                                    return;
                                } else {
                                    $("#cta_url").removeClass("error");
                                    $('.lp-sticky-bar__loader').hide();
                                    hideUrlNotice();
                                    $('#duplicate_url').val('0');
                                }
                            },
                            cache: false,
                            async: false
                        });
                    }else if ($(".zindex-adding-stickybar").val() == 1){
                        is_website_support_iframe($("#cta_url").val());
                    }
                    if (!$("#cta_url").hasClass("error")) {
                        $.ajax({
                            type: "POST",
                            url: "/lp/popadmin/savestickybarv2",
                            data: c_data_obj,
                            dataType: 'json',
                            error: function(data){
                                $('.lp-sticky-bar__loader').hide();
                                alert_message(data.message, 'danger');
                            },
                            success: function (data) {
                                var obj = data;
                                if(obj.section == 'false'){
                                    location.reload();
                                }else{
                                    if (obj.status == 'success') {
                                        var obj1 = JSON.parse(obj.sticky);
                                        c_data_obj.sticky_id = obj1.sticky_id;
                                        c_data_obj = obj1;
                                        funnel_data[funnel_index] = c_data_obj;
                                        setting.insert_flag = $('#insert_flag').val(obj.hash);
                                        setting.token = obj.hash;
                                        var file_name = 'https://dev2itclix.com/' + obj.hash + ".js";
                                        var type = c_data_obj.script_type;
                                        generate_code(file_name, type);
                                        update_attributes(obj);
                                        if(setting.active_flag ==  false){
                                            if (setting.owl_index !== "") {
                                                owl.trigger('to.owl.carousel', setting.owl_index, 500);
                                            } else {
                                                owl.trigger('next.owl.carousel', [300]);
                                            }
                                        }
                                        setting.third_party_index = "";
                                        setactiveinactiveflag(obj);
                                        specific_3rd_party_url_render(c_data_obj);
                                        set_defeult_steps ();
                                        set_obj_after_ajax ();
                                        data_rander_after_ajax ();
                                        owl_refresh(400);
                                        $('#prev-sticky-bar').show();
                                        setting.update_form = false;
                                        var radio_status = $('.sticky-radio:checked').val();
                                        $('.lp-sticky-bar__loader').hide();
                                        alert_message(obj.message);
                                    } else {
                                        $('.lp-sticky-bar__loader').hide();
                                        alert_message(data.message, 'danger');
                                    }
                                }
                            },
                            cache: false,
                            async: true
                        });

                    }

                }else {
                    $('.lp-sticky-bar__loader').hide();
                    has_error = 0;
                }
            }
        }
    });

    $('.share-with-pinterest').click(function () {
        var windowProperties = "toolbar=no,menubar=no,scrollbars=no,statusbar=no,height=" + 250 + ",width=" + 500 + ",left=" + 150 + ",top=" + 150;
        var url = "http://www.pinterest.com/pin/create/button?";
        var domain_url = $('.thrid_party_website_share_url').attr("data-domain-url");
        var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
        domain_url= domain_url+"~"+sticky_url;
        domain_url = domain_url.replace(/['"]/,"");
        url = url+"url="+domain_url+"&description=Check%awesome%Sticky%Bar";
        url = $.trim(url);
        var popwin = window.open(url, 'linkedin', windowProperties);
        popwin.focus();
    });

    $('.share-with-linkedin').click(function () {
        var windowProperties = "toolbar=no,menubar=no,scrollbars=no,statusbar=no,height=" + 250 + ",width=" + 500 + ",left=" + 150 + ",top=" + 150;
        var url = "https://www.linkedin.com/shareArticle?mini=true&";
        var domain_url = $('.thrid_party_website_share_url').attr("data-domain-url");
        var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
        domain_url= domain_url+"~"+sticky_url;
        domain_url = domain_url.replace(/['"]/,"");
        url = url+"url="+domain_url+"&description=Check%awesome%Sticky%Bar";
        url = $.trim(url);
        var popwin = window.open(url, 'linkedin', windowProperties);
        popwin.focus();
    });

    // $('.share-with-mail').click(function () {
    //     e.preventDefault();
    //     var url=$("meta[property='og:url']").attr("content");
    //     var emailTo=$("#user_email").val();
    //     var emailCC="sal@leadpops.com";
    //     var emailSub="Check out your Sticky Bar";
    //     var emailBody="Hey! Check out this awesome Sticky Bar --";
    //     emailBody+='\r\n'+url;
    //     //location.href = "mailto:"+emailTo+'?cc='+emailCC+'&subject='+emailSub+'&body='+encodeURIComponent(emailBody);
    //     var mailto = "mailto:"+emailTo+'?subject='+emailSub+'&body='+encodeURIComponent(emailBody);
    //     window.open(
    //         mailto,
    //         '_blank' // <- This is what makes it open in a new window.
    //     );
    // });

    $('.share-with-twitter').click(function () {
        var windowProperties = "toolbar=no,menubar=no,scrollbars=no,statusbar=no,height=" + 250 + ",width=" + 500 + ",left=" + 150 + ",top=" + 150;
        var url = "https://twitter.com/intent/tweet?";
        var domain_url = $('.thrid_party_website_share_url').attr("data-domain-url");
        var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
        domain_url= domain_url+"~"+sticky_url;
        domain_url = domain_url.replace(/['"]/,"");
        url = url+"url="+domain_url+"&description=Check%awesome%Sticky%Bar";
        url = $.trim(url);
        var popwin = window.open(url, 'twitter', windowProperties);
        popwin.focus();
    });

    $('body').on('blur','#cta_url',function(){
        // for not allowed website
        for(var i = 0 ; i < not_allowed_website.length; i++ ){
            var website =not_allowed_website[i].toLowerCase();
            if (new RegExp("\\b"+website+"\\b").test($(this).val().toLowerCase())) {
                // found
                if(!$("#cta_url").hasClass("error")) {
                    $("#cta_url-error-website").remove();
                    $("#cta_url").removeClass("error");
                    $("#cta_url").addClass("error");
                    $('#cta_url').after('<label id="cta_url-error-website" class="error" for="cta_url">Please change the website URL.</label>');
                    owl_refresh(400);
                }
                return false;

            }else {
                // not found
                $("#cta_url-error-website").remove();
                $("#cta_url").removeClass("error");
            }
        }
        // ShowUrlNotice($(this));
        target = $(this).val($(this).val().replace(/\/$/, ''));
        if($(this).val() == "" || $(this).val() == 'example.com'){
            if($("#cta_url").val() == ""){
                if(!$("#cta_url").hasClass("error")) {
                    $("#cta_url").removeClass("error");
                    $("#cta_url-error").remove();
                    $("#cta_url").addClass("error");
                    $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please add your Sticky Bar website URL.</label>');
                    owl_refresh(400);
                }
            }else{
                if(!$("#cta_url").hasClass("error")) {
                    $("#cta_url").removeClass("error");
                    $("#cta_url-error").remove();
                    $("#cta_url").addClass("error");
                    $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please change the "example" domain.</label>');
                    owl_refresh(400);
                }
            }
            return false;
        }else{
            $("#cta_url").removeClass("error");
            $("#cta_url-error").remove();
            owl_refresh(400);
        }

        var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
        var url = $("#cta_url").val();
        if(url.match(regex) == null && $(".zindex-adding-stickybar").val() != 2){
            if(!$("#cta_url").hasClass("error")) {
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
                $("#cta_url").addClass("error");
                $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please enter a valid URL.</label>');
                owl_refresh(400);
            }
            return false;
        }else {
            $("#cta_url").removeClass("error");
            $("#cta_url-error").remove();
            owl_refresh(400);
        }
        // console.info('kas-slash:'+ target);
        current_data_obj();
        if(setting.third_party_website_flag==1){
            is_website_support_iframe($("#cta_url").val());
        }else if(has_error == 0) {
            if($(".zindex-adding-stickybar").val() == 0) {
                $('.lp-sticky-bar__loader').show();
                $.ajax({
                    type: "POST",
                    url: "/lp/popadmin/checkfunneldomainv2",
                    data: {'id': c_data_obj.sticky_id, 'domain': $("#cta_url").val(),'_token':ajax_token},
                    success: function (data) {
                        var obj = $.parseJSON(data);
                        if (obj.status == 'error') {
                            setting.inactive_funnel_url = obj.funnel_url;
                            var message = 'URL you are adding is already set up with funnel "' + obj.funnel_url + '".';
                            var html = '<div class="alert alert-danger lp-sticky-bar__alert">\n' +
                                '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                                '  <strong> Error! </strong>' + message +
                                '</div>';
                            $('#duplicate_url').val('1');
                            $("#cta_url").addClass("error");
                            $('#toggle-status').bootstrapToggle('off');
                            $('.lp-sticky-bar__loader').hide();
                            if (setting.lp_stop) {
                                setting.lp_stop = false;
                                c_data_obj.url_flag = "";
                                $(html).hide().appendTo(".msg").slideDown(500).delay(50000).slideUp(500, function () {
                                    $(this).remove();
                                    setting.lp_stop = true;
                                });
                            }
                            has_error= 1;
                            setting.update_form = false;
                            return;
                        } else {
                            $("#cta_url").removeClass("error");
                            $('.lp-sticky-bar__loader').hide();
                            hideUrlNotice();
                            $('#duplicate_url').val('0');
                        }
                    },
                    cache: false,
                    async: false
                });
            }
        }else{
            has_error = 0;
        }
    });

    $("#stickybar__pixel_code").blur(function() {
        var regex = /<script\b[^>]*>([\s\S]*?)<\/script>/;
        setting.update_form = true;
        if ($(this).val() == null || $(this).val() == ""){
            //error
            owl_refresh(400);
        }else{
            var value_of_pixel_code = $(this).val();
            var value_of_pixel = value_of_pixel_code.match(regex);
            if(value_of_pixel == null){
                //error
                $(this).removeClass("error");
                $("#stickybar__pixel_code-error").remove();
                $(this).addClass("error");
                $('#stickybar__pixel_code').after('<label id="stickybar__pixel_code-error" class="error" for="stickybar__pixel_code">Please enter with valid code.</label>');
                owl_refresh(400);
            }else{
                var regex_google_pixel = /googletagmanager\.com|gtag\s*\(/gm;
                var regex_google_pixel_result = value_of_pixel_code.match(regex_google_pixel);
                var regex_facebook_pixel = /googletagmanager\.com|gtag\s*\(/gm;
                var regex_facebook_pixel_result = value_of_pixel_code.match(regex_facebook_pixel);
                if(regex_google_pixel_result ==  null){
                    if(regex_facebook_pixel_result ==  null){
                        //error
                        $(this).removeClass("error");
                        $("#stickybar__pixel_code-error").remove();
                        $(this).addClass("error");
                        $('#stickybar__pixel_code').after('<label id="stickybar__pixel_code-error" class="error" for="stickybar__pixel_code">Please enter with valid code.</label>');
                        owl_refresh(400);
                        return false;
                    }
                }
                if(regex_facebook_pixel_result ==  null){
                    if(regex_google_pixel_result ==  null){
                        //error
                        $(this).removeClass("error");
                        $("#stickybar__pixel_code-error").remove();
                        $(this).addClass("error");
                        $('#stickybar__pixel_code').after('<label id="stickybar__pixel_code-error" class="error" for="stickybar__pixel_code">Please enter with valid code.</label>');
                        owl_refresh(400);
                        return false;
                    }
                }
               $(this).removeClass("error");
                $("#stickybar__pixel_code-error").remove();
                // check for google analysis
                owl_refresh(400);
            }
        }
    });

    $('#cta_url').keypress(function(event){
        // e.preventDefault();
        var keyCode = event.keyCode || event.which;
        if (keyCode == 9) {
            event.preventDefault();
            $('#continue-sticky-bar').focus();
        }else if (keyCode == 13){
            if($(this).val() == "" || $(this).val() == 'example.com'){
                if($("#cta_url").val() == ""){
                    if(!$('#cta_url').hasClass("error")){
                        $("#cta_url").removeClass("error");
                        $("#cta_url-error").remove();
                        $("#cta_url").addClass("error");
                        $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please add your Sticky Bar website URL.</label>');
                        owl_refresh(400);
                    }
                }else{
                    if(!$('#cta_url').hasClass("error")){
                        $("#cta_url").removeClass("error");
                        $("#cta_url-error").remove();
                        $("#cta_url").addClass("error");
                        $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please change the "example" domain.</label>');
                        owl_refresh(400);
                    }
                }
                owl_refresh(400);
                return;
            }else{
                $("#cta_url").removeClass("error");
                $("#cta_url-error").remove();
                owl_refresh(400);
            }
            setting.active_flag = false;
            hideUrlNotice();
            if(setting.update_form == true){
                $("#sticky-bar-form").submit();
            }else{
                owl.trigger('next.owl.carousel', [300]);
                $file_name = '';
                if(setting.token != ''){
                    $file_name = 'https://dev2itclix.com/' + setting.token + '.js';
                }
                // var type = $(setting.element_id).attr("data-sticky_script_type");
                c_data_obj = getActiveElementObj();
                var type = c_data_obj.script_type;
                generate_code($file_name , type);
                $('#prev-sticky-bar').show();
            }
        }
    });

    $('#another_cta_url').keypress(function(event){
        setting.update_form = true;
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            event.preventDefault();
            var value = $(this).val();
            value = value.replace(/\s/g, "");
            $("#another_cta_url").val(value);
            if($(this).val() == "" || $(this).val() == 'example.com'){
                if($("#another_cta_url").val() == ""){
                    if(!$("#another_cta_url").hasClass("error")){
                        $("#another_cta_url").removeClass("error");
                        $("#another_cta_url-error").remove();
                        $("#another_cta_url").addClass("error");
                        $('#another_cta_url').after('<label id="another_cta_url-error" class="error" for="another_cta_url">Please add your Sticky Bar website URL.</label>');
                    }
                }else{
                    if(!$("#another_cta_url").hasClass("error")) {
                        $("#another_cta_url").removeClass("error");
                        $("#another_cta_url-error").remove();
                        $("#another_cta_url").addClass("error");
                        $('#another_cta_url').after('<label id="another_cta_url-error" class="error" for="another_cta_url">Please change the "example" domain.</label>');
                    }
                }
                return;
            }else if($(this).val() != "" && $(this).val() != 'example.com'){
                $("#another_cta_url").removeClass("error");
                $("#another_cta_url-error").remove();
            }
            var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
            var url = $(this).val();
            if(url.match(regex) == null){
                if(!$("#another_cta_url").hasClass("error")) {
                    $("#another_cta_url").removeClass("error");
                    $("#another_cta_url-error").remove();
                    $("#another_cta_url").addClass("error");
                    $('#another_cta_url').after('<label id="another_cta_url-error" class="error" for="another_cta_url">Please enter a valid URL.</label>');
                    owl_refresh(400);
                }
                return;
            }else {
                $("#another_cta_url").removeClass("error");
                $("#another_cta_url-error").remove();
                owl_refresh(400);
            }
            current_data_obj();
            var another_third_party_cta_url = $('#another_cta_url').val();
            c_data_obj.sticky_url = another_third_party_cta_url;
            if(setting.update_form == true && !$('#another_cta_url').hasClass("error")){
                is_website_support_iframe(another_third_party_cta_url);
                $('.lp-sticky-bar__loader').show();
                $.ajax({
                    type : "POST",
                    url : "/lp/popadmin/savestickybarv2",
                    data : c_data_obj,
                    dataType: 'json',
                    error: function(data){
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(data.message, 'danger');
                    },
                    success : function(data) {
                        var obj = data;
                        if(obj.section == 'false'){
                            location.reload();
                        }else{
                            if(obj.status == 'success'){
                                var obj1 = JSON.parse(obj.sticky);
                                c_data_obj.sticky_id =obj1.sticky_id;
                                c_data_obj = obj1;
                                setting.insert_flag = $('#insert_flag').val(obj.hash);
                                setting.token = obj.hash;
                                $("#another_cta_url").val('');
                                var file_name = 'https://dev2itclix.com/' + obj.hash+".js";
                                // var type = $(setting.element_id).attr("data-sticky_script_type");
                                var type = c_data_obj.script_type;
                                generate_code(file_name , type);
                                // console.info(obj);
                                update_attributes(obj);
                                setactiveinactiveflag(obj)
                                set_defeult_steps ();
                                set_obj_after_ajax ();
                                data_rander_after_ajax ();
                                setting.third_party_index = "";
                                specific_3rd_party_url_render(c_data_obj);
                                owl_refresh(400);
                                $('#prev-sticky-bar').show();
                                var radio_status = $('.sticky-radio:checked').val();
                                setting.update_form = false;
                                $('.lp-sticky-bar__loader').hide();
                                alert_message("New Link has been add.");

                            }else{
                                $('.lp-sticky-bar__loader').hide();
                                alert_message(obj.message , 'danger');
                            }}
                    },
                    cache : false,
                    async : false
                });
            }

        }
    });

    $('#new_cta_url').keypress(function(event){
        setting.update_form = true;
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            event.preventDefault();
            var value = $(this).val();
            value = value.replace(/\s/g, "");
            $("#new_cta_url").val(value);
            if($(this).val() == "" || $(this).val() == 'example.com'){
                if($("#new_cta_url").val() == ""){
                    if(!$("#new_cta_url").hasClass("error")){
                        $("#new_cta_url").removeClass("error");
                        $("#new_cta_url-error").remove();
                        $("#new_cta_url").addClass("error");
                        $('#new_cta_url').after('<label id="new_cta_url-error" class="error" for="new_cta_url">Please add your Sticky Bar website URL.</label>');
                    }
                }else{
                    if(!$("#new_cta_url").hasClass("error")) {
                        $("#new_cta_url").removeClass("error");
                        $("#new_cta_url-error").remove();
                        $("#new_cta_url").addClass("error");
                        $('#new_cta_url').after('<label id="new_cta_url-error" class="error" for="new_cta_url">Please change the "example" domain.</label>');
                    }
                }
                return;
            }else if($(this).val() != "" && $(this).val() != 'example.com'){
                $("#new_cta_url").removeClass("error");
                $("#new_cta_url-error").remove();
            }
            var regex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
            var url = $(this).val();
            if(url.match(regex) == null){
                if(!$("#new_cta_url").hasClass("error")) {
                    $("#new_cta_url").removeClass("error");
                    $("#new_cta_url-error").remove();
                    $("#new_cta_url").addClass("error");
                    $('#new_cta_url').after('<label id="new_cta_url-error" class="error" for="new_cta_url">Please enter a valid URL.</label>');
                    owl_refresh(400);
                }
                return;
            }else {
                $("#new_cta_url").removeClass("error");
                $("#new_cta_url-error").remove();
                owl_refresh(400);
            }
            current_data_obj();
            var another_third_party_cta_url = $('#new_cta_url').val();
            c_data_obj.sticky_url = another_third_party_cta_url;
            if(setting.update_form == true && !$('#new_cta_url').hasClass("error")){
                is_website_support_iframe(another_third_party_cta_url);
                $('.lp-sticky-bar__loader').show();
                $.ajax({
                    type : "POST",
                    url : "/lp/popadmin/savestickybarv2",
                    data : c_data_obj,
                    dataType: 'json',
                    error: function(data){
                        $('.lp-sticky-bar__loader').hide();
                        alert_message(data.message, 'danger');
                    },
                    success : function(data) {
                        var obj = data;
                        if(obj.section == 'false'){
                            location.reload();
                        }else{
                            if(obj.status == 'success'){
                                var obj1 = JSON.parse(obj.sticky);
                                c_data_obj.sticky_id =obj1.sticky_id;
                                c_data_obj = obj1;
                                setting.insert_flag = $('#insert_flag').val(obj.hash);
                                setting.token = obj.hash;
                                $("#prev-sticky-bar").hide();
                                var file_name = 'https://dev2itclix.com/' + obj.hash+".js";
                                // var type = $(setting.element_id).attr("data-sticky_script_type");
                                var type = c_data_obj.script_type;
                                generate_code(file_name , type);
                                // console.info(obj);
                                update_attributes(obj);
                                setactiveinactiveflag(obj);
                                specific_3rd_party_url_render(c_data_obj);
                                set_defeult_steps ();
                                set_obj_after_ajax ();
                                data_rander_after_ajax ();
                                owl_refresh(400);
                                $('#prev-sticky-bar').show();
                                var radio_status = $('.sticky-radio:checked').val();
                                setting.update_form = false;
                                $('.lp-sticky-bar__loader').hide();
                                alert_message("New Link has been add.");

                            }else{
                                $('.lp-sticky-bar__loader').hide();
                                alert_message(obj.message , 'danger');
                            }}
                    },
                    cache : false,
                    async : false
                });
            }

        }
    });

    function copyToClipboard(element) {
        // var script_flag = $(setting.element_id).attr("data-sticky_script_type");
        c_data_obj = getActiveElementObj();
        var script_flag = c_data_obj.script_type;
        var $temp = $("<textarea>");
        var brRegex = /<br\s*[\/]?>/gi;
        if(script_flag == 'a'){
            var script = $(element).text().replace(brRegex, "\r\n");
        }else{
            var script = $(element).html().replace(brRegex, "\r\n");
        }
        $("body").append($temp);
        $temp.val($.trim(script)).select();
        document.execCommand("copy");
        $temp.remove();
    }
    function copyTextToClipboard(text) {
        var $temp = $("<textarea>");
        var brRegex = /<br\s*[\/]?>/gi;

        text = text.replace(brRegex, "\r\n");

        $("body").append($temp);
        $temp.val($.trim(text)).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $(".lp-sticky-bar__btn_copy-link").click(function () {
        if(setting.third_party_website_flag == 1){

            var urlcopy = $('.thrid_party_website_share_url').attr("data-domain-url");
            var sticky_url = $('.thrid_party_website_share_url').attr("data-sticky-url");
            urlcopy = urlcopy+"~"+sticky_url;
            urlcopy = urlcopy.replace(/['"]/,"");
            copyTextToClipboard(urlcopy);
        }else{
            copyTextToClipboard(c_data_obj.domain_name);
        }
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Your share link has been copied.' +
            '</div>';
        $(html).hide().appendTo(".msg").slideDown(500,function(){
            $(".lp-sticky-bar__btn_copy-link").css("pointer-events","none")}).delay(1000).slideUp(500 , function(){
            $(".lp-sticky-bar__btn_copy-link").css("pointer-events","auto");
            $(this).remove();
        });
    });

//    copy the code
    $('#copy-sticky-bar').click(function(){
        copyToClipboard($('#copy_code'));
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Sticky Bar code has been copied.' +
            '</div>';
        $(html).hide().appendTo(".msg").slideDown(500).delay(1000).slideUp(500 , function(){
            $(this).remove();
        });
    });

    //  Manage specific Pages JS
    $('.all-pages').change(function(){
        owl_refresh(400);
        // update_form = true;
        setting.update_form = true;

        if($(this).val() != '/'){
            hideUrlNotice();
            $(".lp__url-path").css('display','inline-block')
            // $('.lp-sticky-bar_page').show();
        }else{
            ShowUrlNotice($('#cta_url'));
            $(".lp__url-path").hide();
        }
    });

    $('#pin_flag_top, #pin_flag_bottom, #pin_size_full, #pin_size_slim, #pin_size_medium, #pin_cta_show, #pin_cta_hide, .lp-sticky-bar__toggle').change(function(){
        setting.update_form = true;
    });
    $('.lp-sticky-bar_page').on('click' , function(){
        owl_refresh(400);
        if($('#cta_url').val() != "example.com"){
            if(!$('#cta_url').hasClass('error')){
                if($('#sticky-home-page').hasClass('sticky-home-page')){
                    $('#sticky-home-page').prop('checked' , true);
                }
                $('.lp-prefix').text($('#cta_url').val());
                $('.lp-prefix.lp-input-prefix').text($('#cta_url').val());
                $('.lp-sticky-bar__outer_pages').fadeIn('fast');
                $('.lp-sticky-bar__outer_builder').hide();
                setting.add_flag = true;
            }
        }else{
            $("#cta_url").removeClass("error");
            $("#cta_url-error").remove();
            $('#cta_url').addClass('error');
            $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please change the "example" domain.</label>');
        }

    });

    $('#sticky-home-page').change(function(){
        if($(this).prop('checked')){
            $(this).addClass('sticky-home-page');
        } else{
            $(this).removeClass('sticky-home-page');
        }
    });

    $('#close_sticky_page').click(function(){
        owl.trigger('to.owl.carousel', [0, 300]);
        $('.lp-sticky-bar__clone-wrap .db_remove').show().removeClass('db_remove');
        $('.lp-sticky-bar__clone-wrap .db_save').remove();
        $('.sticky-home-page').prop('checked' , false);
        $('#sticky-home-page').removeClass('.sticky-home-page');
        $('.lp-sticky-bar__outer_builder').fadeIn('fast');
        $('.lp-sticky-bar__outer_pages').fadeOut('fast');
    });

    $('.close-sticky-bar_pages').click(function(){
        $('.lp-sticky-bar__clone-wrap .db_remove').show().removeClass('db_remove');
        $('.lp-sticky-bar__clone-wrap .db_save').remove();
        $('.sticky-home-page').prop('checked' , false);
        $('#sticky-home-page').removeClass('.sticky-home-page');
        $('.lp-sticky-bar__outer_builder').fadeIn('fast');
        $('.lp-sticky-bar__outer_pages').fadeOut('fast');
        $("#close-sticky-bar").trigger('click');
    });

    $('body').on('click','#add', function(e){
        if(setting.add_flag){
            if($(".lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input").val() != ""){
                var field = $('.copy').html();
                $('.add-more').before(field);
                setting.add_flag = false;
            }else{
                $(".lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input").addClass('error');
            }
        }else{
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input').each(function(){
                if(!$(this).hasClass("error")){
                    if($(this).val() == ''){
                        $(this).addClass('error');
                        $(this).next().show();
                    }
                    return;
                }

            });
        }

        $('.lp-sticky-bar_clone input').keyup(function(){
            if($(this).val() !== ''){
                url = $(this).val();
                var char = url.charAt(0);
                if(char == '/' || char == '?'){
                    setting.add_flag = true;  // Prevent to add/save new element if it's false
                    $(this).removeClass('error');
                    $(this).next().text('This field is required.').hide();
                }
            }else{
                $(this).addClass('error');
                $(this).next().show();
            }
        });
        specific_page_validation();
    });

    $('body').on('click','#remove', function(e){
        $(this).closest(".lp-sticky-bar_clone").toggle();
        $(this).parents('.lp-sticky-bar_clone').next(".lp-sticky-bar__confirmation-block").toggle();
    });

    $(document).on('click' , '.no' ,function(){
        $(this).parents('.lp-sticky-bar__confirmation-block').hide();
        $(this).parents('.lp-sticky-page-wrap').find('.lp-sticky-bar_clone').show();
    });

    $(document).on('click' , '.yes' , function(){
        setting.add_flag = true;
        $(this).parents('.lp-sticky-page-wrap').slideUp(function(){
            $(this).remove();
        });
    });

    $(document).on('click' , '#third-party__previoue-link' , function(){
        third_party_share_url_update(third_party_obj);
        specific_3rd_party_url_render(c_data_obj);
        $(".sorting").first().attr('data-sort','desc');
        owl.trigger('to.owl.carousel', 4, 500);
        $(window).scrollTop(500000);
    });

    $(document).on('click' , '.lp-sticky-bar__original-link' , function(){
        setting.third_party_index =  $(this).parents('.lp-sticky-bar__form-group').attr('data-index');
    });

    $(document).on('click' , '.lp__edit-icon sticky-tooltip' , function(){
        setting.third_party_index =  $(this).parents('.lp-sticky-bar__form-group').attr('data-index');
    });

    $('#save-sticky-bar_page').click(function(){
        var sp_page_list = [];
        $("[name='pages[]']").each(function(){
            var val = $(this).val();
            if($(this).hasClass('checkbox-flag')){
                if($(this).prop("checked") !== true){
                    return;
                }
            }
            if(val != ''){
                sp_page_list.push(val);
            }
        });
        sp_page_list = sp_page_list.join('~');
        c_data_obj.sticky_url_pathname = sp_page_list;
        setting.update_form = true;
        $('.db_remove').remove();
        if(setting.add_flag){
            $("#sticky-bar-form").submit();
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').removeClass('db_save');
        }else{
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input').each(function(){
                if($(this).val() == ''){
                    $(this).addClass('error');
                    $(this).next().show();
                }
            });
        }
    });

    $('#bs-slider-bar').bootstrapSlider().on('change', function(){
        var zindex = $(this).val();
        if(zindex > 1000){
            zindex = zindex - 1;
        }
        $('#zindex-label').text(zindex);
        $('#zindex-label').digits();
        $('#zindex').val(zindex);
        return zindex;
    });

    $('#sticky-bar__how-big').bootstrapSlider();
    $('#sticky-bar__shadow').bootstrapSlider();
    $('#dropzone-logo-size').bootstrapSlider();
    $('#dropzone-logo-space').bootstrapSlider();
    $('#dropzone-color-opacity').bootstrapSlider();
    $('#dropzone-image-size').bootstrapSlider();

    $('#dropzone-logo-space').change(function () {
        setting.update_form = true;
        if($(".select__logo-placement").val() == 'top'){
            $(".cta__logo").css("left","");
            if(parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()) < 0){
                $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
            }else{
                $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().top - $(".cta__logo").height()));
            }
            if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
                $(".cta__logo").css("bottom",$(this).val()+"px");
            }else{
                $(".cta__logo").css("bottom","-"+$(this).val()+"px");
            }
            setting.logo_bottom_spacing = $(this).val();
        }else {
            $(".cta__logo").css("bottom","");
            if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
                if(parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width() - $("#sticky-bar-form").width()) < 0 ){
                    $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
                }else{
                    $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width() - $("#sticky-bar-form").width() ));
                }
                $(".cta__logo").css("left","-"+$(this).val()+"px");
            }else{
                if(parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()) < 0 ){
                    $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max', 100);
                }else{
                    $("#dropzone-logo-space").bootstrapSlider('setAttribute', 'max',parseInt($(".lp_froala__sticky-bar-text").offset().left - $(".cta__logo").width()));
                }
                $(".cta__logo").css("left","-"+$(this).val()+"px");
            }
            setting.logo_left_spacing = $(this).val();
        }
    });

    $("#dropzone-image-size").change(function () {
        setting.update_form= true;
        var image_size = $(this).val();
        $(".leadpops-wrap").css("background-size",image_size+"%");
    });

    $("#dropzone-color-opacity").change(function () {
        setting.update_form= true;
        var opacity_val = $(this).val();
        $(".color-overlay").css('opacity',opacity_val);
    });

    $("#sticky-bar__shadow").change(function () {
        setting.update_form= true;
        setting.cta_box_shadow = $(this).val();
        $(".leadpops-wrap").css("box-shadow","0 0  "+$(this).val()+"px #444")
    });

    $('#dropzone-logo-size').change(function () {
        setting.update_form= true;
        var logo_size = $(this).val();
        if(logo_size > $("#linkanimation").height()){
            logopresize($(".cta__logo") , logo_size , logo_size );
        }
    });

    var adding_stickbar = [
        { id: 0, text: '<div class="adding-stickbar">My Own Website/Page <span>(I can add script to the source code)</span></div>' },
        // { id: 1, text: '<div class="adding-stickbar adding-stickbar--third_party">3rd Party Website/Page <span>(I cannot access the source code)</span><div id="clixly_logo" class="clixly_logo"><span class="clixly_img"><img src='+site.baseUrl+"/"+site.lpAssetsPath+"/adminimages/powered-by-clixly.svg"+'></span></div></div>' },
        { id: 1, text: '<div class="adding-stickbar adding-stickbar--third_party">3rd Party Website/Page <span>(I cannot access the source code)</span><div id="clixly_logo" class="clixly_logo"><span class="clixly_img"><img src=""></span></div></div>' },
        { id: 2, text: '<div class="adding-stickbar">This Funnel <span style="overflow:inherit">(I'+"'"+'m putting it on THIS Funnel)</span> </div>' }];

    $(".zindex-adding-stickybar").select2({
        data: adding_stickbar,
        selectionTitleAttribute: false,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $(".select2-adding-stickybar"),
        dropdownPosition: 'below'
    });

  /*  $(".zindex-adding-stickybar").on("select2:open", function () {
        var offset_top = $('.zindex-adding-stickybar').offset().top+28;
        $('.select2-adding-stickybar .select2-container--open ').eq(1).css({'top': offset_top+'px','left':'0'});
    });*/

    $(".zindex-adding-stickybar").on("select2:close", function () {
        $(".clickable_tooltip").hide();
    });

    $(".select2-adding-stickybar").click(function() {
        $(".sticky-tooltip").tooltip();
    });

    $('body').on('mouseover' , '.clixly_logo' ,function() {
        var offset = $(this).offset();
        $(".clickable_tooltip").css({"left":parseInt(offset.left-35)+"px","top": parseInt(offset.top-35)+"px","opacity":"1"});
        $(".clickable_tooltip").show();
    });

    $('body').on('mouseout' , '#clickable_tooltip' ,function(e) {
        if (e.offsetY < 0) {
            $('#clickable_tooltip').hide();
        }
        if((e.offsetX < 0 || e.offsetX > 150 ) && e.offsetX != 0  ){
            $('#clickable_tooltip').hide();
        }
    });

    $('body').on('mouseout' , '.clixly_logo' ,function(e) {
        if (e.offsetY > 0) {
            $('#clickable_tooltip').hide();
        }
    });

    $(".select__want-display").select2({
        dropdownParent: $(".zindex-dropdown__want-display"),
        dropdownPosition: 'below'
    });

    $(".select__want-display").on("select2:open", function () {
       /* var offset_top = $('.zindex-dropdown__want-display').offset().top+28;
        $('.zindex-dropdown__want-display .select2-container--open ').eq(1).css({'top': offset_top+'px','left':'0'});*/
        $('.select2-results__options').niceScroll({
            cursorcolor:"#fff",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #02abec"
        });
    });

    $(".lp-sticky-bar__when-hide-select").select2({
        dropdownParent: $(".lp-sticky-bar__when-hide-select-parent"),
        dropdownPosition: 'below'
    });

 /*   $(".lp-sticky-bar__when-hide-select").on("select2:open", function () {
        var offset_top = $('.lp-sticky-bar__when-hide-select-parent').offset().top+28;
        $('.lp-sticky-bar__when-hide-select-parent .select2-container--open ').eq(1).css({'top': offset_top+'px','left':'0'});
    });*/

    $(".select__want-placed").select2({
        dropdownParent: $(".zindex-dropdown__want-placed"),
        dropdownPosition: 'below'
    });

    $(".select__want-animation").select2({
        dropdownParent: $(".zindex-dropdown__want-animation"),
        dropdownPosition: 'above'
    });

    $(".select__want-animation").on("select2:open", function () {
  /*      var offset_top = $('.zindex-dropdown__want-animation').offset().top+28;
        $('.zindex-dropdown__want-animation .select2-container--open ').eq(1).css({'top': offset_top+'px','left':'0'});*/
        $('.select2-results__options').niceScroll({
            cursorcolor:"#fff",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #02abec"
        });
        if($('[name=lp-sticky-bar__full-page-checker]:checked').val() !== undefined && $('[name=lp-sticky-bar__full-page-checker]:checked').val() != 'off'){
            setting.owl_height = $('.owl-height').height();
            $('.owl-height').height(setting.owl_height+150);
        }
    });

    $(".select__want-animation").on("select2:close", function() {
        if($('[name=lp-sticky-bar__full-page-checker]:checked').val() !== undefined && $('[name=lp-sticky-bar__full-page-checker]:checked').val() != 'off'){
            $('.owl-height').height(setting.owl_height);
        }
    });

    $(".select__want-animation").change(function () {
        setting.update_form = true;
    });

    $(".select__want-placed").on("select2:open", function () {
        /*var offset_top = $('.zindex-dropdown__want-placed').offset().top+28;
        $('.zindex-dropdown__want-placed .select2-container--open ').eq(1).css({'top': offset_top+'px','left':'0'});*/
        $('.select2-results__options').niceScroll({
            cursorcolor:"#fff",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #02abec"
        });
    });

    $(".zindex-dropdown__want-placed").click(function () {
        if ($(this).hasClass("non-clixly-option")){
        }else{
            $('.select2-results__options').niceScroll({
                cursorcolor:"#fff",
                cursorwidth: "10px",
                autohidemode:false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec"
            });
        }
    });

    $(".lp-sticky-bar__when-hide-select-parent").click(function () {
        $('.select2-results__options').niceScroll({
            cursorcolor:"#fff",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #02abec"
        });
    });

    $(".select__logo-placement").select2({
        dropdownParent: $(".zindex-select__logo-placement"),
        dropdownPosition: 'below'
    });

    $(".select__logo-placement").on("select2:open", function () {
        /*var offset_top = $('.zindex-select__logo-placement').offset().top+28;
        $('.zindex-select__logo-placement .select2-container--open ').eq(1).css({'top':  offset_top +'px','left':'0'});*/
    });

    $(".select2-adding-stickybar, .select__logo-placement, .select__want-placed, .lp-sticky-bar__when-hide-select").on("select2:open", function() {
        $(window).trigger('resize');
    });

    $(".select__logo-placement").change(function () {
        if ($(this).val() == "top"){
            if(c_data_obj.logo_image_replacement == "top"){
                if(setting.logo_bottom_spacing  == '0'){
                    setting.logo_bottom_spacing = c_data_obj.logo_spacing;
                }
            }
            $(".cta__logo").css("left","");
            if($(".lp-sticky-bar__wrapper").hasClass("lp-sticky-bar__full-page") == true){
                $(".cta__logo").css("bottom",setting.logo_bottom_spacing +"px");
            }else{
                $(".cta__logo").css("bottom","-"+setting.logo_bottom_spacing +"px");
            }
            $("#dropzone-logo-space").bootstrapSlider('setValue', setting.logo_bottom_spacing,true);
            $('.lp-sticky-bar__wrapper').addClass("cta__logo-above");
        } else {
            if(c_data_obj.logo_image_replacement == "left"){
                if(setting.logo_left_spacing  == '0'){
                    setting.logo_left_spacing = c_data_obj.logo_spacing;
                }
            }
            $(".cta__logo").css("bottom","");
            $(".cta__logo").css("left","-"+setting.logo_left_spacing+"px");
            $('.lp-sticky-bar__wrapper').removeClass("cta__logo-above");
            $("#dropzone-logo-space").bootstrapSlider('setValue', setting.logo_left_spacing,true);
            $('.leadpops-wrap').height(c_data_obj.sticky_size);
        }
        if(setting.sticky_bar_update_flag == 1){
            setting.update_form = true;
            // $('.lp-sticky-bar__wrapper').toggleClass("cta__logo-above");
            $(".lp-sticky-bar__outer").mCustomScrollbar("update");
        }
        if ($('#lp-sticky-bar__full-page-checker').is(':checked')) {
            fullpage_outerheight();
        }else {
            page_outerheight();
        }
    });

    $(".select__want-animation").change(function () {
        var cta_button = $("#linkanimation");
        var animation_type = $(this).val();
        if(animation_type== "None"){
            $(cta_button).addClass("no_animation");
        } else{
            $(cta_button).removeClass("no_animation");
        }
        if(animation_type== "Wobble"){
            $(cta_button).addClass("wobble_animation");
        } else {
            $(cta_button).removeClass("wobble_animation");
        }
        if(animation_type == "Pulse"){
            $(cta_button).addClass("pulse_animation");
        } else {
            $(cta_button).removeClass("pulse_animation");
        }
        if(animation_type == "Radioactive"){
            $(cta_button).addClass("radio-active_animation");
            var bg_btn_clr = "#"+c_data_obj.cta_btn_background_color;
            $(".radio__active-animation").remove();
            $('head').append('<style class="radio__active-animation" type="text/css">#linkanimation.radio-active_animation:before , #linkanimation.radio-active_animation:after {background-color:'+bg_btn_clr +'}</style>');
        } else {
            $(cta_button).removeClass("radio-active_animation");
            $(".radio__active-animation").remove();
        }
    });

    $(".select2-adding-stickybar").change(function () {
        $('.select2-selection__rendered').removeAttr('title');
        setting.change_flag = 0;
        setting.third_party_website_flag = $(".zindex-adding-stickybar").val();
        if (setting.third_party_website_flag == 2 ){
            $("#new-url-sticky-bar").hide();
            $('.select__want-placed').html("");
            $(".select__want-placed").select2('destroy');
            $('.select__want-placed').html(setting.new_placed_select2_html);
            $(".select__want-placed").select2({
                dropdownParent: $(".zindex-dropdown__want-placed"),
                dropdownPosition: 'below'
            });
            $('.select__want-display').html("");
            $(".select__want-display").select2('destroy');
            $('.select__want-display').html(setting.new_display_select2_html);
            $(".select__want-display").select2({
                dropdownParent: $(".zindex-dropdown__want-display"),
                dropdownPosition: 'below'
            });
            $('.lp-sticky-bar__input-right-icon').attr("href","http://"+c_data_obj.domain_name);
            $(".funnel_domian").val(c_data_obj.domain_name);
            $(".lp-sticky__d-none").show();
            $(".lp-sticky-bar-pages").hide();
            $(".slug__url-text").hide();
            $("#third-party__previoue-link").hide();
            $(".lp-sticky-bar__own-page-website").hide();
            $('.sticky_url__wrapper').slideUp();
            $(".fullpage__status").hide();
            $(".defaultpage__status").hide();
            owl_refresh(400);

        }else if(setting.third_party_website_flag == 1) {
            if(c_data_obj.third_party_website == ""){
                $("#third-party__previoue-link").hide();
            }else{
                $("#third-party__previoue-link").show();
            }
            $("#new-url-sticky-bar").show();
            $(".lp-sticky-bar__note").hide();
            $('.select__want-placed').html("");
            $(".select__want-placed").select2('destroy');
            $('.select__want-placed').html(setting.new_placed_select2_html);
            $(".select__want-placed").select2({
                dropdownParent: $(".zindex-dropdown__want-placed"),
                dropdownPosition: 'below'
            });

            $('.select__want-display').html("");
            $(".select__want-display").select2('destroy');
            $('.select__want-display').html(setting.new_display_select2_html);
            $(".select__want-display").select2({
                dropdownParent: $(".zindex-dropdown__want-display"),
                dropdownPosition: 'below'
            });
            $(".lp-sticky__d-none").hide();
            $(".lp-sticky-bar-pages").hide();
            if(c_data_obj.third_party_website != "" && c_data_obj.third_party_website != null){
                $(".slug__url-text").show();
            }
            $(".lp-sticky-bar__own-page-website").show();
            $('.sticky_url__wrapper').slideDown();
            owl_refresh(400);
        }else{
            $('.select__want-placed').html("");
            $(".select__want-placed").select2('destroy');
            $('.select__want-placed').html(setting.placed_select2_html);
            $(".select__want-placed").select2({
                dropdownParent: $(".zindex-dropdown__want-placed"),
                dropdownPosition: 'below'
            });
            $('.select__want-display').html("");
            $(".select__want-display").select2('destroy');
            $('.select__want-display').html(setting.display_select2_html);
            $(".select__want-display").select2({
                dropdownParent: $(".zindex-dropdown__want-display"),
                dropdownPosition: 'below'
            });
            $(".lp-sticky__d-none").show();
            $(".lp-sticky-bar-pages").show();
            $(".slug__url-text").hide();
            $("#third-party__previoue-link").hide();
            $(".lp-sticky-bar__own-page-website").hide();
            $('.sticky_url__wrapper').slideDown();
            $("#new-url-sticky-bar").hide();
            $(".fullpage__status").hide();
            $(".defaultpage__status").hide();
            owl_refresh(400);

        }

        setting.update_form = true;
        if(setting.sticky_bar_update_flag == 1){
            if (c_data_obj.third_party_website != "" && setting.last_thrid_party_website_share_url_style == "" ){
                third_party_share_url_update();
            }
            setting.website_change = 1;
            setting.change_flag = 1;
            if(c_data_obj.last_selection_of_website == "null" && $(".zindex-adding-stickybar").val() == 1 && c_data_obj.third_party_website.length == 0 ){
                third_party_sticky_popup(third_party_setting)
            }else if(c_data_obj.last_selection_of_website == "null" && $(".zindex-adding-stickybar").val() == 0 && c_data_obj.third_party_website.length == 0 ){
                third_party_sticky_popup(c_data_obj)
            }else if(c_data_obj.last_selection_of_website == "null" && $(".zindex-adding-stickybar").val() == 2 && c_data_obj.third_party_website.length == 0 ){
                third_party_sticky_popup(third_party_setting)
            }else  if(c_data_obj.last_selection_of_website == "third_party" && $(".zindex-adding-stickybar").val() == 1){
                third_party_sticky_popup(JSON.parse(setting.last_thrid_party_website_share_url_style));
            }else if(c_data_obj.last_selection_of_website == "third_party" && $(".zindex-adding-stickybar").val() == 0){
                third_party_sticky_popup(third_party_setting)
            }else if(c_data_obj.last_selection_of_website == "own_side" && $(".zindex-adding-stickybar").val() == 0 || $(".zindex-adding-stickybar").val() == 2 ){
                if(setting.logo_image_path != "" && setting.logo_image_path != STICKY_BAR_IMAGES_PATH && setting.logo_image_path!= "/"+STICKY_BAR_IMAGES_PATH){
                    c_data_obj.logo_image_path =  setting.logo_image_path ;
                }
                if(setting.background_image_path != "" && c_data_obj.background_image_path != "" && c_data_obj.background_image_path != null) {
                    c_data_obj.background_image_path =  setting.background_image_path ;
                }
                third_party_sticky_popup(c_data_obj)
            }else if(c_data_obj.last_selection_of_website == "own_side" && $(".zindex-adding-stickybar").val() == 1){
                if(c_data_obj.third_party_website != "" && c_data_obj.third_party_website != null){
                    setting.logo_image_path =  c_data_obj.logo_image_path ;
                    setting.background_image_path =  c_data_obj.background_image_path ;
                    third_party_sticky_popup(JSON.parse(setting.last_thrid_party_website_share_url_style));
                }else{
                    setting.logo_image_path =  c_data_obj.logo_image_path ;
                    setting.background_image_path =  c_data_obj.background_image_path ;
                    c_data_obj.logo_image_path = "";
                    c_data_obj.background_image_path = "";
                    third_party_sticky_popup(third_party_setting)
                }
            }
        }
    });

    $(".zindex-company").select2({
        dropdownParent: $(".zindex-dropdown"),
        dropdownPosition: 'below'
    });

    $('[name="zindex_type"]').change(function(){
        var zindex_option = $(this).val();
        setting.update_form = true;

        if(zindex_option == 1){
            $('.zindex-custom-hide').slideUp();
            $('.zindex-company-hide').slideUp();
            $('#zindex').val('1000000');
        }else if(zindex_option == 2){
            $('.zindex-custom-hide').slideDown();
            $('.zindex-company-hide').slideUp();
            $('#zindex').val($('#zindex-label').text());
        }else if(zindex_option == 3){
            $('.zindex-custom-hide').slideUp();
            $('.zindex-company-hide').slideDown();
            $('#zindex').val('1000');
        }
        owl_refresh(400);
    });

    $('[name="zindex_company"]').change(function () {
        if(setting.campany_name == 1){
            $('#zindex').val($(this).val());
        }
        setting.campany_name = 1;
    });
});
