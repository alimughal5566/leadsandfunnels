$(document).ready(function(){
    // Create dummy image to get real size and set height width on load
    $(window).on('load',function(){
        var path = $("#currentdropimagelogo").attr('src');
        if(path!=""){
            set_logo_dimension(path);
        }
    });
    window.save = 0;
	$("#globallogo").on("change",function(e){
		var filename = e.target.files[0].name;
		var filetype = e.target.files[0].type;
        var filesize = e.target.files[0].size/1024/1024;
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            $(this).val("");
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            return false;
        }
        if(filesize > 1) {
            $(this).val("");
            alert('The size of image is too large, please try a smaller image.');
            return;
        }
		if(filename.length > 18){
			filename = filename.substring(0,18);
			filename +="...";
		}
		$(this).parents().find("#logonamesel").text("");
		$(this).parents().find("#logonamesel").text(filename);
		$(this).parents().find("#logonamesel").show();

		uploadlogo();
	});
	$("body").on("click","#uploadlogo",function(){
		uploadlogo();
	});
	$("#lp-default-logo .logo-default-img img").dblclick(function(e) {
	    var path = $(this).attr('src');
	    var id = $(this).attr('id');
	    $('#droppable-photos-container-logo .logo-default-img img').remove('');
	    $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
        set_logo_dimension(path);
	    $('#logo_source').val('default');
	    $('#useme_logo').val('n');
	    $('#usedefault_logo').val('y');
	    $('#logo_id').val(id);
	    //savegloballogo(e,$(this),true);
	});
	$("div[id^='lp-cur-logo'] img").dblclick(function(e) {
	//$("div.img-content-logo img").dblclick(function() {
	    var path = $(this).attr('src');
	    var id = $(this).attr('id');
	    $('#droppable-photos-container-logo .logo-default-img img').remove('');
	    $('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
        set_logo_dimension(path);
	    $('#logo_source').val('client');
	    $('#logo_id').val(id);
	    $('#useme_logo').val('y');
	    $('#usedefault_logo').val('n');
	    //savegloballogo(e,$(this),true);

	});

	$(".globallogo").on("click",function(e){
        e.preventDefault();
        var logoid=$(this).data("logoid");
        var ele=this;

        $('#deletegloballogo').modal({
	 		show: true,
	        backdrop: 'static',
	        keyboard: true
        }).one('click', '#deletethegloballogo', function(e) {
            $('#deletegloballogo').modal("hide");
            deletelogoglobal(logoid,ele);
    	});
    });


	$(".img-content-logo").draggable({
		helper: "clone",
		appendTo: "body"
	});

	$("#droppable-photos-container-logo .logo-default-img").droppable({
	    accept: ".img-content-logo",
	    drop: function(ev, ui) {

	    	var dragEv = ev;
	    	var dragElem = $(this);

	        var path = ui.draggable.find('img').attr('src');
	        var id = ui.draggable.find('img').attr('id');
	        var rel = ui.draggable.find('img').attr('rel');
            var swatch = ui.draggable.find('img').attr('data-swatches');
            $("#swatches").val(swatch);
            if(swatch != ""){
                set_logo_dimension(path);
            }
	        if(rel == 'client') {
	            $('#logo_source').val('client');
        	    $('#useme_logo').val('y');
	    		$('#usedefault_logo').val('n');
	        }
	        else if (rel == 'stock')  {
	            $('#logo_source').val('default');
	            $('#useme_logo').val('n');
	    		$('#usedefault_logo').val('y');
	        }
	        $('#logo_id').val(id);

	        var dimage = path.indexOf("/clients/");
	    	$('#droppable-photos-container-logo .logo-default-img img').remove('');
	        if(dimage == -1 ) {
	        	$('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
	        }
	        else {
	        	$('#droppable-photos-container-logo .logo-default-img').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
	        }

            if(swatch == ""){
            	download_image_and_create_swatches(path, dragEv, dragElem);
            }
	    }
	});
	setTimeout(function () {

        if($("#backgroundsize").val() != ""){
            $("#background_size").val($("#backgroundsize").val()).trigger('change');
        }
    },400)
});

function set_logo_dimension (path){
    $("#temporary_image").attr("src", path).on('load',function(){
        var realWidth = this.width;
        var realHeight = this.height;
        var W = 334;
        var H = 229;
        /*var W = 500;
        var H = 282;*/
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
function uploadlogo() {
    var cnt = $('#globallogocnt').val();
    if ($('#globallogo').val() == "") {
    	alert("Please select a logo.");
    	return;
    }else if( cnt >= 3 ) {
    	$("#logonamesel").text("");
    	alert('Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.');
    	return;
    }else {
    	$('#uploadgloballogo').submit();
    	return;
		var form = $('#uploadgloballogo')[0];

		var data = new FormData(form);
		$(".logooverlay").text("Please wait upload file");
		$(".logooverlay").show();

		$.ajax( {
			type: "POST",
	        enctype: 'multipart/form-data',
	        processData: false,  // Important!
	        contentType: false,
	        cache: false,
			url: site.baseUrl+site.lpPath+'/global/uploadgloballogo',
			data : data,
		success : function(d) {
			console.log(d);
			$(".logooverlay").hide();
		}
	});

    }
}
function savegloballogo(event,el,logocall=false) {
    event.preventDefault();
    var image = $("#droppable-photos-container-logo .logo-default-img img");

    if (image.attr('src') == "" || image.length == 0) {
        errormessage("Please Select Logo.");
        return;
    }

    if ($("#lpkey_logo").val() == '') {
        errormessage("Please Select Funnel From List.");
        return false;
    };
    $("#savelogo").attr('disabled','disabled');
    if($("#swatches").val() == '') {
        download_image_and_create_swatches(image.attr('src'), '.logo-default-img ui-droppable', '');
    }else{
        if(save == 0) {
            $('#uploadgloballogo').submit();
        }
        window.save = 1;
    }

}

function deletelogoglobal(logoid,element) {
	$("#mask").show();
	var client_id = $('#client_id').val();
	$.ajax( {
		type : "POST",
		url: site.baseUrl+site.lpPath+'/global/deletelogoglobal',
		data : "logo_id=" + logoid + "&client_id=" + client_id+'&_token='+ajax_token,
		success : function(d) {
            $("#mask").hide();
            goToByScroll("success-alert");
            $("#success-alert").find('span').text("logo has been Deleted");
            $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                $(this).slideUp(500);
            });
            if($('#globallogocnt').val() == 1){
                $("#currentdropimagelogo").remove();
                $('.logo-main-wrapper').append('<div class="bluetextheadleft">\n' +
                    '  <br />\n' +
                    'To upload a logo:<br /><br />\n' +
                    '1. Click "Browse" to select your logo, then click "Upload."<br /><br />\n' +
                    '2. Next, simply drag and drop your logo into the box that <br />\n' +
                    'says "Current Logo", then click "Save New Logo."<br />\n' +
                    '</div>')
            }
            $('#globallogocnt').val($('#globallogocnt').val()-1);
            $(element).parent().siblings('#droppablePhotosLogo').parent().remove();
		}
	});
}

function download_image_and_create_swatches(rs_link, dragEvent, dragElem){
    $.ajax( {
        type : "POST",
        url : "/lp/ajax/download_rs_image",
        data : "image_link=" + rs_link +'&_token='+ajax_token+'&global=1',
        dataType: "json",
        error: function (e, s){
            console.error(e);
            console.error(s);
        },
        success : function(d) {
            $("#temp_logo").val(d.file);
            readImage(site.baseUrl +"/"+ d.file, dragEvent, dragElem, rs_link);
        }
    });
}

function readImage(url, dragEvent, dragElem, rs_link) {
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
        $("#swatches").val(str);
        $("#globalswatches").val(str);
        changelogo(rs_link, dragEvent, dragElem);

    });
    img.src = url;
}

function changelogo(url, dragEvent, dragElem) {
    var client_id = $("#client_id").val();
    var logosavetype = $(dragEvent).attr("id");
    logosavetype="savelogo";
    $('#logosavetype').val(logosavetype);

    $("#image_url").val(url);
    if(dragElem == '') {
        if(save == 0) {
            $('#uploadgloballogo').submit();
        }
        window.save = 1;
    }
}
