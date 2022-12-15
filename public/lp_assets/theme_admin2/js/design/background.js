
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('#colorpicker').ColorPicker({
		flat: true,
        width: 277,
        height: 277,
        outer_height: 300,
        outer_width: 390,
        onChange: function (cal, hex, rgb) {
			$('#col-code').html('#'+hex);
			$('#col-prev').css('background-color' , '#'+hex);
        }
	});


	var tempswatches;
	var timeout = "";
	$("#success-alert").hide();
	$( "body" ).on( "change",".bgimg-overlay-btn" , function() {
		var lp_key=$(this).data('lpkeys');
		backgroundoptionstoggle(lp_key);
		setpreviewsetting();
	});
	//$( "body" ).on( "click","#bkactive,#bkinactive,.collapse-bg-img" , function() {
	$( "body" ).on( "click","#bkactive,#bkinactive" , function() {
		//console.log("yes it is click")
		var lp_key=$(this).data('lpkeys');
		var bk_active=$(this).data('bkactive');
		//backgroundoptionstoggle(lp_key,bk_active);
	});

	////Background-overlay////

    $( "body" ).on( "change","#overlay_active_btn1" , function() {

			var color = "#fff";
            var value=0;
            if($(this).is(":checked")){
                color = $("#colorSelector").css('backgroundColor');
                value=$('#ex1').val();
            }
	        $("#preview-overlay").css("background-color", color);
	        $("#preview-overlay").css('opacity', value/100);
    });


    //color picker
	//
    $('.colorSelector').ColorPicker({
        color: "#FFFFFF",
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector').css('backgroundColor', '#' + hex);
			$("#background-overlay").val('#'+hex);
			setpreviewsetting();
        }
    });

    //Slider
    //

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
        	$('#overlay_color_opacity').val(value);
        	if ($('#overlay_active_btn').is(":checked")){
	        	$("#preview-overlay").css('opacity', value/100);
			}
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#overlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
	$('#ex3').bootstrapSlider({
		formatter: function(value) {
			return   value +'%';
		},
		min: 1,
		max: 100,
		value: 20,
		tooltip: 'always',
		tooltip_position:'bottom'
	});

	$( "body" ).on( "change","input:file" , function(e) {
		e.preventDefault();
        var filetype = this.files[0].type;
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            jQuery("#bg-img-action-btn").hide();
            jQuery(this).parent("#bd-img-browse").removeClass("hide");
            jQuery('#previewbox').css('background-image', 'url("")');
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            jQuery('#background_name').val('');
            jQuery("#bg-option-image-url").val('');
            return false;
        }
        var filesize=this.files[0].size/1024/1024;
        if(filesize < 2) {
            jQuery("#bg-img-action-btn").show();
            jQuery(this).parent("#bd-img-browse").addClass("hide");
            readURL(this);
            setpreviewsetting();
        }else {
            jQuery("#bg-img-action-btn").hide();
            jQuery(this).parent("#bd-img-browse").removeClass("hide");
            jQuery('#previewbox').css('background-image', 'url("")');
            alert('The size of image is too large, please try a smaller image.');
            console.log('The size ('+filesize+') of image is too large, please try a smaller image.');
            jQuery('#background_name').val('');
            jQuery("#bg-option-image-url").val('');
        }

        return;
     });
	function setpreviewsetting(){
		$('#previewbox').css({'background-repeat':$('#background-repeat').val(),'background-position':$('#background-position').val(),'background-size':$('#background_size').val()});
		var color = "#fff";
        var value=0;
        if($('#overlay_active_btn').is(":checked")){
            color = $("#colorSelector").css('backgroundColor');
            //$("#background-overlay").val('#'+hex);
            value=$('#ex1').val();
        }
        $("#preview-overlay").css("background-color", color);
        $("#preview-overlay").css('opacity', value/100);
	}
	$("#bg-img-change").on("click",function(e){
		e.preventDefault();
		$('input:file').trigger('click');
		return;
	});
	$("#bg-img-remove").on("click",function(e){
		e.preventDefault();
		$("#bg-option-image-url").val("");
		$("#background_name").val("");
		$("#bg-img-action-btn").hide();
		$('#previewbox').css('background-image', "none");
        $("#preview-overlay").css('background-color','inherit');
        $("#preview-overlay").css('opacity', '1');
		$("#bd-img-browse").removeClass('hide');
		return;
	});
	$('#background-repeat').on('change', function(e) {
		e.preventDefault();
		$('#previewbox').css('background-repeat', this.value);
	});
	$('#background-position').on('change', function(e) {
		e.preventDefault();
		$('#previewbox').css('background-position', this.value);
	});
	$('#background_size').on('change', function(e) {
		e.preventDefault();
		$('#previewbox').css('background-size', this.value);
	});

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#previewbox').css('background-image', 'url(' + e.target.result + ')');
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}


    $('#ex2').bootstrapSlider({
        formatter: function(value) {
        	console.log(value);
            $('#background_size').val(value);
            $('#previewbox').css('background-size', value+'%');
            return value +'%';
        },
        min: 1,
        max: 100,
        value: $('#background_size').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    setupicseditor();

	if ($("#bg-option-image-url").val() !='') {
		$("#bd-img-browse").addClass('hide');
		$("#bg-img-action-btn").show();
		var previewcss={
			'background-image':'url(' + $("#bg-option-image-url").val() + ')',
			'background-repeat':$("#bg-image-data-info").data('background-repeat'),
			'background-position':$("#bg-image-data-info").data('background-position'),
			'background-size':$("#bg-image-data-info").data('background-size')
		}
        $("#background-repeat").val($("#bg-image-data-info").data('background-repeat')).change();
        $("#background-position").val($("#bg-image-data-info").data('background-position')).change();
        $("#background_size").val($("#bg-image-data-info").data('background-size')).change();
		var previewcssoverlay={
			'background-color':$("#background-overlay").val(),
			'opacity':$('#overlay_color_opacity').val()/100
		}
		$('#previewbox').css(previewcss);
    	if ($('#overlay_active_btn').is(":checked")){
			$('#preview-overlay').css(previewcssoverlay);
		}

	}

	jQuery("#bgimgapply").on('click',function(e){
		e.preventDefault();
		var target_element="";
		target_element=$(".collapse-bg-img:not(.collapsed)").data("targetele");
		$(".alert").hide();

		switch (target_element) {
            case 'pulllogocolor':
            	updatebackground();
            break;
            case 'backgroundimage':
				if (jQuery('#background_name').val() == '' && $("#bg-option-image-url").val() =='') {
                    errormessage("Please select the Background Image.");
                    return;
                }
				$('#updatebackgroundimage').submit();
            break;
	       }
      });
});
function errormessage(textval){
    $("#alert-danger").find('span').html(textval);
    $("#alert-danger").fadeIn("slow");
    goToByScroll("alert-danger");
    return false;
}
//jQuery(window).load(function () {
jQuery(window).on('load',function(){

    var background_type_vale=$("#background_type_vale").val();
    if(background_type_vale=="1"){

        // $("#bkinactive").trigger("click");
        var _selector = $("#bkinactive").attr('href');
        $(_selector).addClass('in');
        $("#bkactive").addClass('collapsed');

    }
    else {
        // $("#bkactive").trigger("click");
        var _selector = $("#bkactive").attr('href');
        $(_selector).addClass('in');
        $("#bkinactive").addClass('collapsed');

	}
    /*var b_size=$('#backgroundsize').val();
    $('#previewbox').css('background-size', b_size);*/
    var color= $('#background-overlay').val();
    if(color!=""){
    	color=color;
	}else {
        color='#ffffff';
	}
    if($('#background-overlay').val())
    $('.colorpicker_color').css('background-color', color);
    $('.colorpicker_new_color').css('background-color', color);



});
function setupicseditor(){
	var tempswatches=Array();
	var client_id = jQuery("#client_id").val();
	var funneldata = jQuery("#funneldata").val();
	jQuery.ajax( {
	        type : "POST",
	        data : "client_id=" + client_id+"&funneldata=" +funneldata+'&_token='+ajax_token,
	        url: site.baseUrl+site.lpPath+'/popadmin/getinitialswatches',
	        success : function(data) {
	           tempswatches = jQuery.parseJSON(data);
	        },
	        cache : false,
	        async:false,
	});
	var icsgeOpts = {
	    interface : ['gradient',"swatches"],
	    startingGradient : false,
	    targetCssOutput : 'all',
	    targetElement : jQuery('.gradient'),
	    defaultGradient : tempswatches[0],
	    //defaultCssSwatches : tempswatches,
	    targetInputElement : jQuery('.gradient-result')
	}

	if(tempswatches.length > 0){
		icsgeOpts.defaultCssSwatches=tempswatches;
	}
    jQuery('#ics-gradient-editor-1').icsge(icsgeOpts);
}
	localStorage.clear(); // get rid of possible previous swatches
	$(window).on('load', function () {

    });

	function hideColorThief(e) {
	    e.preventDefault();
	    $("#ics-gradient-editor-1-div").hide();
	}

	function componentToHex(c) {
	    var hex = c.toString(16);
	    return hex.length == 1 ? "0" + hex : hex;
	}


	function rgbToHex(r, g, b, a) {
	    red = 255,
	    green = 255,
	    blue = 255;
	    var alpha = 1-a;
	    var x = Math.round((a * (r / 255) + (alpha * (red / 255))) * 255);
	    var y = Math.round((a * (g / 255) + (alpha * (green / 255))) * 255);
	    var z = Math.round((a * (b / 255) + (alpha * (blue / 255))) * 255);

	    return "#" + componentToHex(x) + componentToHex(y) + componentToHex(z);
	}

    function updatebackground() {
        //$("#leadpopovery").show();
        $("#mask").show();

        var background = $("#the-gradient").val();
        var start = parseInt(background.indexOf("###") + 6);
        var end = parseInt(background.indexOf("@@@") - 3);
        var testFontColor = background.slice(start,end);
        var regExp = /\(([^)]+)\)/;
        var fontcolor = "";

        // console.log(testFontColor);
        try {
            var matches = regExp.exec(testFontColor);
            var rgba = matches[1].split(",");
            var red = rgba[0].trim();
            var green = rgba[1].trim();
            var blue = rgba[2].trim();
            var alpha = rgba[3].trim();
            fontcolor = rgbToHex(red,green,blue,alpha);
        }
        catch(err) {
            var loc =  testFontColor.indexOf("#");
            var tempstr = testFontColor.substring(loc);
            fontcolor = tempstr.trim();
        }


        var darkerfontcolor = fontcolor;//tinycolor(fontcolor).darken(50).toHexString();

        var swatchnumber    = jQuery("#swatchnumber").val();
        var data = "background=" + encodeURIComponent($("#the-gradient").val());
        data = data + "&gradient=" + encodeURIComponent($(".gradient").attr("style"));
        data = data + "&fontcolor=" + darkerfontcolor;
        data = data + "&client_id=" + jQuery("#client_id").val();
        data = data + "&range=thedomain"
        //data = data + "&action=" + jQuery("input[name=addremove]:checked").val();
        // MN
        data = data + "&action=addBackgroundColors";
        data = data + "&swatchnumber=" + swatchnumber;
        data = data + "&funneldata=" + jQuery("#funneldata").val();
        data = data + "&background_type=" + jQuery("#background_type").val();
        data = data + "&_token="+ajax_token;
        // console.log(data);
        jQuery.ajax( {
                type : "POST",
                data : data,
                url: site.baseUrl+site.lpPath+'/popadmin/updatebackgroundcolors',
                success : function(ret) {
			        //$("#leadpopovery").hide();
			        $("#mask").hide();
			        goToByScroll("success-alert");
                	$("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
		                $(this).slideUp(500);
		            });
              	}

        });
    }


	function backgroundoptionstoggle(lpkeys,bkactive = null) {
		var client_id = $('#client_id').val();
		var akeys = lpkeys.split("~");
		var vertical_id = akeys[0];
		var subvertical_id = akeys[1];
		var leadpop_id = akeys[2];
		var version_seq = akeys[3];
		var thelink =  akeys[4];
		$.ajax({
			type : "POST",
			url: site.baseUrl+site.lpPath+'/popadmin/backgroundoptionstoggle',
			data : {client_id:client_id,vertical_id:vertical_id,subvertical_id:subvertical_id,leadpop_id:leadpop_id,version_seq:version_seq,thelink:thelink,bkactive:bkactive,_token:ajax_token},
			success : function(d) {
				var change = d.split("~");
				var imgId = change[0];
				var active = change[1];
			}
		});
	}
