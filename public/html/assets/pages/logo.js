var WIDTH = '';
var MAX_WIDTH = 540;
var PAD = 15;
var HEIGHT = '';
$(document).ready(function(){

    $(".lp-image__input").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function() {
        readURL(this);
    });

    $(".upload-drag__file").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function () {
        readCombURL(this);
    });

    function readCombURL(input) {
        var this_input = input;
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $(this_input).parents(".comb__col").find('.file__extension').slideDown("slow");
                $(this_input).parents(".comb__col").find('.file__size').slideUp("slow");
            }
            else if (file.size > 4000000) {
                $(this_input).parents(".comb__col").find('.file__size').slideDown("slow");
                $(this_input).parents(".comb__col").find('.file__extension').slideUp("slow");

            }
            else {
                $(this_input).parents(".comb__col").find('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        $(this_input).parents(".comb__col").find('.file__imgsize').slideUp("slow");
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step1").hide();
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('src', e.target.result );
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('alt', file.name );
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2").show();

                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $('.file__extension').slideDown("slow");
                $('.file__size').slideUp("slow");
                $(".file-name").text("");
                $(".file-name").hide();
            }
            else if (file.size > 4000000) {
                $('.file__size').slideDown("slow");
                $('.file__extension').slideUp("slow");
                $(".file-name").text("");
                $(".file-name").hide();
            }
            else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        $('.file__imgsize').slideUp("slow");
                        $(".file-name").text("");
                        $(".file-name").text(file.name);
                        $(".file-name").show();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $(".del-logo").click(function () {
        $(this).closest("div.col").remove();
    });

    // Create dummy image to get real size and set height width on load
    $(window).on('load',function(){
        var path = $("#currentdropimagelogo").attr('src');
        if(path!=""){
            set_logo_dimension(path);
        }
    });


    // $("#logo").on("change",function(e){
    //     var filename=e.target.files[0].name;
    //     var filesize=e.target.files[0].size/1024/1024;
    //     if(filesize > 3) {
    //         alert('The size of image is too large, please try a smaller image.');
    //         return;
    //     }
    //     if(filename.length > 18){
    //         filename = filename.substring(0,18);
    //         filename +="...";
    //     }
    //
    //
    //     /*var html='<input type="button" class="btn btn-file" id="uploadlogo" value="Upload Logo">';
    //     $(this).parents().find("#logouploadwrap").find("#uploadlogo").remove();
    //     $(this).parents().find("#logouploadwrap").append(html);*/
    //     $(this).parents().find("#logonamesel").text("");
    //     $(this).parents().find("#logonamesel").text(filename);
    //     $(this).parents().find("#logonamesel").show();
    //     uploadlogo();
    // });

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

    // function readURL(input) {
    //     $image = $(input).data("image");
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             $("img."+$image).attr('src', e.target.result);
    //         }
    //         reader.onloadend = function() {
    //             var $_imagestyle = Math.round($("img."+$image).width()) + "~" + Math.round($("img."+$image).height());
    //             $("#"+$image+"-style").val($_imagestyle);
    //             WIDTH = Math.round($("img."+$image).width());
    //             HEIGHT = Math.round($("img."+$image).height());
    //             console.info(WIDTH);
    //             console.info(HEIGHT);
    //         };
    //         reader.readAsDataURL(input.files[0]);
    //     }
    //
    // }

    $("#comb-logo-wrapper input").change(function() {
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
            // Create dummy image to get real size and set height width
            set_logo_dimension(path);
            if(rel == 'client') {
                $('#logo_source').val('client');
            }else if (rel == 'stock')  {
                $('#logo_source').val('default');
            }
            $('#logo_id').val(id);
            var dimage = path.indexOf("/clients/");
            //$(this).find("img").remove();
            $('#droppable-photos-container-logo .logo-default-img img').remove('');
            if(dimage == -1 ) {
                $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
                //$(this).append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
            }else {
                $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
                //$(this).append('<img src="'+path+'" id="currentdropimagelogo" class="abc" border="0" >');
            }
            changelogo();
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
    var client_id = $('#client_id').val();
    var cur_hash=$("#current_hash").val();
    $.ajax( {
        type : "POST",
        url: site.baseUrl+site.lpPath+'/popadmin/deletelogo',
        data : "logo_id=" + logoid + "&client_id=" + client_id + "&key=" + $('#key').val(),
        success : function(d) {
            window.location.href = site.baseUrl+site.lpPath+'/popadmin/logo/'+cur_hash;
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
    }else if( cnt == 3 ) {
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


function uploadlogo() {
    var cnt = $('#logocnt').val();
    /*console.log(cnt);
    return;*/
    if ($('#logo').val() == "") {
        alert("Please select a logo.");
        return;
    }else if( cnt == 3 ) {
        $("#logonamesel").text("");
        alert('Maximum of three logos uploaded at one time.Delete one logo then upload its replacement.');
        return;
    }else {
        $('#fuploadload').submit();
    }
}
function changelogo() {
    var client_id = $("#client_id").val();
    var cur_hash=$("#current_hash").val();
    /*if ($("#bgimage_active").val() == 'y' && client_id == 1348) {
        alert("match background color to logo, or keep photo background?");
    }else{*/
    var colorThief = new ColorThief();
    //var image = $("#droppable-photos-container-logo img")[0];
    //var image = $("#droppable-photos-container-logo .logo-default-img img");
    var image = $("#droppable-photos-container-logo .logo-default-img").find("img")[0];


    var tred, tgreen, tblue = "";
    var palette = new Array();

    palette = colorThief.getPalette(image, 6, 10);
    // console.info(palette);
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
    /*console.log(str);
    return;*/
    // var newaction=site.baseUrl+site.lpPath+'/popadmin/changelplogo/'+cur_hash;
    //
    // $('#fuploadload').attr("action",newaction);
    // $("#fuploadload").attr("method", "post");
    // $('#fuploadload').submit();
    /*}*/

}

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");

if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
{
    $("label img").on("click", function() {
        $("#" + $(this).parents("label").attr("for")).click();
    });
}


