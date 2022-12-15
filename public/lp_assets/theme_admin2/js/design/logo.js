var WIDTH = '';
var MAX_WIDTH = 540;
var PAD = 15;
var HEIGHT = '';
$(document).ready(function(){

    // Create dummy image to get real size and set height width on load
    $(window).on('load',function(){
        var path = $("#currentdropimagelogo").attr('src');
        if(path!=""){
            // set_logo_dimension(path);
        }
    });


    $("#logo").on("change",function(e){
        var filename=e.target.files[0].name;
        var filesize=e.target.files[0].size/1024/1024;
        var filetype = e.target.files[0].type;
        if(filesize > 1) {
            $("#logo").val("");
            alert('The size of image is too large, please try a smaller image.');
            return;
        }
        if(filename.length > 18){
            filename = filename.substring(0,18);
            filename +="...";
        }
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            $("#logo").val("");
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            return false;
        }

        $(this).parents().find("#logonamesel").text("");
        $(this).parents().find("#logonamesel").text(filename);
        $(this).parents().find("#logonamesel").show();


        var reader = new FileReader();
        reader.onload = function (e) {
            readImage(e.target.result, true);
        };

        reader.readAsDataURL(e.target.files[0]);

        //readImage(e.target.files[0]);
    });

 $slider1 = $('#ex1').bootstrapSlider({
    formatter: function(value) {
        _width = value;
        if ($('.pre-image').attr('src').indexOf("upload-image.png") < 0 && $('.pre-image').attr('src') != '' && $('.post-image').attr('src') != '') {
            $('.pre-image').css('width',_width+'px');
        }
        var $_imagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
        var pre_width = Math.round($('.pre-image').width());
        var post_width = MAX_WIDTH - pre_width;
        if (value > 270) {
            $('.post-image').width(post_width);
            var $_postimagestyle = $('.post-image').css("width") + "~" + $('.post-image').css("height");
            $("#post-image-style").val($_postimagestyle);
            // $("#ex2").slider('setValue', post_width, true);
            // $("#ex2").slider('refresh');
        }
        $("#pre-image-style").val($_imagestyle);
        return value +'px';
    },
    min: 40,
    step: 10,
    max: 400,
    value: Math.round($('.pre-image').width()),
    // value: 350,
    tooltip_position:'bottom'
});


 $slider2 = $('#ex2').bootstrapSlider({
    formatter: function(value) {
        _width = value;
        if ($('.post-image').attr('src').indexOf("upload-image.png") < 0 && $('.post-image').attr('src') != '' && $('.post-image').attr('src') != '') {
            $('.post-image').css('width',_width+'px');
        }


        var $_imagestyle = Math.round($('.post-image').width()) + "~" + Math.round($('.post-image').height());
        var post_width = Math.round($('.post-image').width());
        var pre_width = MAX_WIDTH - post_width;
        if (value > 270) {
            $('.pre-image').width(pre_width);


            var $_preimagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
            $("#pre-image-style").val($_preimagestyle);
        }
        $("#post-image-style").val($_imagestyle);
        return value +'px';
    },
    min: 40,
    step: 10,
    max: 400,
    value: Math.round($('.post-image').width()),
    tooltip_position:'bottom'
});


setTimeout(function(){
      $slider1.on('change', function(event) {
        var a = event.value.newValue;
        var b = event.value.oldValue;

        var pre_width = Math.round($('.pre-image').width());
        var post_width = MAX_WIDTH - pre_width;
        if (a > 270) {
            //$slider2.slider('setValue', post_width, true);
            var ex2 = $('#ex2').bootstrapSlider();
            $('#ex2').bootstrapSlider('setValue', post_width);
            //$slider2.slider('refresh');
        }

        var src1_img_h = Math.round($('.pre-image').height());
        var src2_img_h = Math.round($('.post-image').height());
        HIGHT = src1_img_h - (PAD*2);
        if(src2_img_h > src1_img_h){
            HIGHT = src2_img_h - (PAD*2);
        }
        $(".image-divider").css("height",HIGHT);

    });
},200);


setTimeout(function(){
      $slider2.on('change', function(event) {
        var a = event.value.newValue;
        var b = event.value.oldValue;

        var post_width = Math.round($('.post-image').width());
        var pre_width = MAX_WIDTH - post_width;
        if (a > 270) {
            //$slider2.slider('setValue', post_width, true);
            var ex1 = $('#ex1').bootstrapSlider();
            $('#ex1').bootstrapSlider('setValue', pre_width);
            //$slider2.slider('refresh');
        }

        var src1_img_h = Math.round($('.pre-image').height());
        var src2_img_h = Math.round($('.post-image').height());
        HIGHT = src1_img_h  - (PAD*2);
        if(src2_img_h > src1_img_h){
            HIGHT = src2_img_h - (PAD*2);
        }
        $(".image-divider").css("height",HIGHT);

        console.log(a);
    });
},200);



// $('#ex2').bootstrapSlider({
//     formatter: function(value) {
//         $('#background_size').val(value);
//         $('#previewbox').css('background-size', value+'%');
//         return value +'%';
//     },
//     min: 1,
//     max: 100,
//     value: $('#background_size').val(),
//     tooltip_position:'bottom'
// });


$("body").on("click","#uploadlogo",function(){
	uploadlogo();
});

function readURL(input) {
  $image = $(input).data("image");
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $("img."+$image).attr('src', e.target.result);
    }
    reader.onloadend = function() {
      var $_imagestyle = Math.round($("img."+$image).width()) + "~" + Math.round($("img."+$image).height());
      $("#"+$image+"-style").val($_imagestyle);
      WIDTH = Math.round($("img."+$image).width());
      HEIGHT = Math.round($("img."+$image).height());
      console.info(WIDTH);
      console.info(HEIGHT);
    };
    reader.readAsDataURL(input.files[0]);
  }

}

var defaultImageUrl = $("img.pre-image").attr("src");
$( "#comb-logo-wrapper").on( "change","input" , function(e) {
    var filetype = e.target.files[0].type;
    var filesize = e.target.files[0].size/1024/1024;
    if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
    }else {
        alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
        $("img." + $(this).attr("name")).attr("src", defaultImageUrl);
        $(this).val("");
        return false;
    }
    if(filesize > 1) {
        alert('The size of image is too large, please try a smaller image.');
        $("img." + $(this).attr("name")).attr("src", defaultImageUrl);
        $(this).val("");
        return;
    }
  readURL(this);
});

$("#lp-default-logo .logo-default-img img").dblclick(function() {
    var path = $(this).attr('src');
    var id = $(this).attr('id');
    $('#droppable-photos-container-logo .logo-default-img img').remove('');
    $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
    set_logo_dimension(path);
    $('#logo_source').val('default');
    $('#logo_id').val(id);
    changelogo();
});
$("div[id^='lp-cur-logo-'] img").dblclick(function() {
    var path = $(this).attr('src');
    var id = $(this).attr('id');
    $('#droppable-photos-container-logo .logo-default-img img').remove('');
    $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
    set_logo_dimension(path);
    $('#logo_source').val('client');
    $('#logo_id').val(id);
    changelogo();
});

$(".img-content-logo").draggable({
	helper: "clone",
	appendTo: 'body'
});

$("#droppable-photos-container-logo .logo-default-img").droppable({
    accept: ".img-content-logo",
    drop: function(ev, ui) {
        var path = ui.draggable.find('img').attr('src');
        var id = ui.draggable.find('img').attr('id');
        var rel = ui.draggable.find('img').attr('rel');
        var swatch = ui.draggable.find('img').attr('data-swatches');

        $("#swatches").val(swatch);

        if(swatch != ""){
            // Create dummy image to get real size and set height width
            set_logo_dimension(path);
        }

        if(rel == 'client') {
            $('#logo_source').val('client');
        } else if (rel == 'stock')  {
            $('#logo_source').val('default');
        }
        $('#logo_id').val(id);

        var dimage = path.indexOf("/clients/");
        $('#droppable-photos-container-logo .logo-default-img img').remove('');
        if(dimage == -1 ) {
            $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
        } else {
            $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
        }

        if(swatch !== ""){
            changelogo();
        }
        else{
            download_image_and_create_swatches(path);
        }

    }
});


});
function set_logo_dimension(path){


    $("#temporary_image").attr("src", path).on('load',function(){
        var realWidth = this.width;
        var realHeight = this.height;
        var W = 400;
        var H = 120;
        var src_w = this.width;
        var src_h = this.height;
        var _w = '';
        var _h ='';
        if(src_w > W){
             _w = W;
             _h = (_w * src_h)/src_w;
            if(_h>H){
                _h = H;
                _w = (_h * src_w)/src_h;
            }
        }else if(src_h > H){
            _h = H;
            _w = (_h * src_w)/src_h;
            if(_w>W) {
                _w = W;
                _h = (_w * src_h)/src_w;
            }
        }
        else {
            _w = src_w;
            _h =src_h ;


        }
        $('#currentdropimagelogo').css({
            'width': _w,
            'height':_h
        });



    });

}
function deletelogo(logoid) {
    var del_logo_url =  $('#'+logoid).attr("src");
    var current_logo_url =  $('#currentdropimagelogo').attr('src');
    if (del_logo_url == current_logo_url){
        $('#currentdropimagelogo').attr('src' , $('.lp-default-logo .logo-default-img img').attr('src'));
        $('#currentdropimagelogo').css('width' , $('.lp-default-logo .logo-default-img img').css('width'));
        $('#currentdropimagelogo').attr('height' , $('.lp-default-logo .logo-default-img img').css('height'));
        $('#logo_id').val($('.lp-default-logo .logo-default-img img').attr('id'));
        $('#logo_source').val('default');
    }
    var client_id = $('#client_id').val();
    var cur_hash=$("#current_hash").val();
    $.ajax( {
        type : "POST",
        url: site.baseUrl+site.lpPath+'/popadmin/deletelogo',
        data : "logo_id=" + logoid + "&client_id=" + client_id + "&key=" + $('#key').val()+'&_token='+ajax_token,
        success : function(d) {
            if (del_logo_url == current_logo_url){
                changelogo();
            }else{
                window.location.href = site.baseUrl+site.lpPath+'/popadmin/logo/'+cur_hash;
            }
        }
    });
}

function combinelogos() {
    var cnt = $('#logocnt').val();
    /*console.log(cnt);
    return;*/
    if ($('.pre-image').attr('src').indexOf("upload-image.png") > 0 || $('.post-image').attr('src').indexOf("upload-image.png") > 0 || $('.pre-image').attr('src') == '' || $('.post-image').attr('src') == '') {
        alert("Please select a logo.");
        return;
    }else if( cnt >= 3 ) {
        $("#logonamesel").text("");
        alert('Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.');
        return;
    }else {
        $("#uploadlogotype").val('combine');
        $('#fuploadload').submit();
    }

}


function swaplogos() {
    console.info("swaplogos");
    var cnt = $('#logocnt').val();
    /*console.log(cnt);
    return;*/

    if ($('.pre-image').attr('src').indexOf("upload-image.png") > 0 || $('.post-image').attr('src').indexOf("upload-image.png") > 0 || $('.pre-image').attr('src') == '' || $('.post-image').attr('src') == '') {
        alert("Please select a logo.");
        return;
    }else {
        var pre_src = $('.pre-image').attr('src');
        var post_src = $('.post-image').attr('src');
        $('.pre-image').attr('src',post_src);
        $('.post-image').attr('src',pre_src);
    }

}

function readImage(url, is_upload_form) {
    var img = new Image();
    img.addEventListener("load", function() {

        var colorThief = new ColorThief();
        var tred, tgreen, tblue = "";
        var palette = [];
        palette = colorThief.getPalette(this, 6, 10);

        var str = "";
        var first = 1;
        for (i=0; i < palette.length; i++) {
            tred = palette[i][0];
            tgreen = palette[i][1];
            tblue = palette[i][2];
            str += tred+"-"+tgreen+"-"+tblue;
            if(i<(palette.length-1)){
                str += "#";
            }
        }

        console.log(str);
        $("#swatches").val(str);

        if(is_upload_form){
            uploadlogo();
        } else {
            changelogo();
        }

    });
    img.src = url;
}

function uploadlogo() {
    var cnt = $('#logocnt').val();
    /*console.log(cnt);
    return;*/
    if ($('#logo').val() == "") {
    	alert("Please select a logo.");
    	return;
    }else if( cnt >= 3 ) {
        $("#logonamesel").text("");
    	alert('Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.');
    	return;
    }else {
        $('#fuploadload').submit();
    }
}

function changelogo__2() {
    var client_id = $("#client_id").val();
    var cur_hash = $("#current_hash").val();
    var image = $("#droppable-photos-container-logo .logo-default-img").find("img")[0];

    $.ajax( {
        type : "POST",
        url : "/lp/ajax/download_rs_image",
        data : "image_link=" + image.src +'&_token='+ajax_token,
        dataType: "json",
        error: function (e, s){
            console.error(e);
            console.error(s);
        },
        success : function(d) {
            //$("#currentdropimagelogo").attr("src", site.baseUrl +"/"+ d.file);
            console.log("Local Path", site.baseUrl +"/"+ d.file);
            $('#droppable-photos-container-logo .logo-default-img').html('<img src="'+(site.baseUrl +"/"+ d.file)+'" id="currentdropimagelogo" class="abcd" >');

            var image = $("#droppable-photos-container-logo .logo-default-img").find("img")[0];

            var colorThief = new ColorThief();
            var tred, tgreen, tblue = "";
            var palette = new Array();

            palette = colorThief.getPalette(image, 6, 10);
            var str = "";
            var first = 1;
            for (i=0; i < palette.length; i++) {
                tred = palette[i][0];
                tgreen = palette[i][1];
                tblue = palette[i][2];
                str += tred+"-"+tgreen+"-"+tblue;
                if(i<(palette.length-1)){
                    str += "#";
                }
            }

            $("#swatches").val(str);
            var newaction=site.baseUrl+site.lpPath+'/popadmin/changelplogo/'+cur_hash;

            $('#fuploadload').attr("action",newaction);
            $("#fuploadload").attr("method", "post");
            $('#fuploadload').submit();
        }
    });
}

function changelogo() {
	var client_id = $("#client_id").val();
	var cur_hash=$("#current_hash").val();

    var newaction=site.baseUrl+site.lpPath+'/popadmin/changelplogo/'+cur_hash;

    $('#fuploadload').attr("action",newaction);
    $("#fuploadload").attr("method", "post");
    $('#fuploadload').submit();
}

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");

if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
{
    $("label img").on("click", function() {
        $("#" + $(this).parents("label").attr("for")).click();
    });
}


function download_image_and_create_swatches(path){
    $.ajax( {
        type : "POST",
        url : "/lp/ajax/download_rs_image",
        data : "image_link=" + path +'&_token='+ajax_token+'&global=1',
        dataType: "json",
        error: function (e, s){
            console.error(e);
            console.error(s);
        },
        success : function(d) {
            readImage(site.baseUrl +"/"+ d.file, false);
        }
    });
}
