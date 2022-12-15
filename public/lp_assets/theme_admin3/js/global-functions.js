/**
 * Created by Jazib on 13/07/17.
 */
window.mzac_lp_and = 'mzac_lp_and'
window.mzac_lp_comma = 'mzac_lp_comma'
window.mzac_lp_less = 'mzac_lp_less'
window.mzac_lp_greater = 'mzac_lp_greater';
$(document).ready(function(){
    ///// Menu Active First Li Trigger auto on change///
    $( "body" ).on( "click",".link" , function() {
        $(this).data("id");
        $('.' + $(this).data("id") + ' ul li').first().find("a").trigger("click");;
    });
});
function checkIfNumber( val ) {
    if (val.length==0)  { return "0"; } else {return val;}
}

function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
    var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
    return newnumber;
}

function validateFieldUsername(field, attr) {

    var val = attr.split("~");
    if (val[0] == 'required' && val[1] == 'email') // required...entry is email
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            if (validateEmail($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                var email = $('#' + field).val();
                $.ajax( {
                    type : "POST",
                    url : "/checkUniqueEmail.php",
                    data : "email=" + email,
                    success : function(data) {
                        //  alert(data);
                        if (data == 1) {
                            $('#' + field).next("img").attr('src',	'/images/complete.png');
                            return true;
                        } else if (data == 0) {
                            $('#' + field).next("img").attr('src',	'/images/incomplete.png');
                            return false;
                        }
                    },
                    cache : false,
                    async : false
                });
//				$('#' + field).next("img").attr('src', '/images/complete.png');
//				return true;
            }
        }
    }

}

function validateField(field, attr) {

    var val = attr.split("~");

    if (val[0] == 'required' && val[1] == 'select') {
        if ($('#' + field).val() == '-1') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'required' && val[1] == 'fullname') {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            var fullname = $('#' + field).val();
            var afn = fullname.split(' ');
            //   alert(afn.length);
            if (afn.length < 2) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            }
            else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }

    if (val[0] == 'required' && val[1] == 'textarea') {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'required' && val[1] == 'password') {
        if ($('#' + field).val() == '' || $('#' + field).val().length < 5) {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'none' && val[1] == 'password') {
        if ($('#' + field).val() != '' && $('#' + field).val().length < 5) {

            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {

            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'none' && val[1] == 'cpassword') {
        if ($('#password').val() != ''	&& $('#' + field).val() != $('#password').val()) {
            $('#password').next("img").attr('src', '/images/incomplete.png');
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'required' && val[1] == 'login') // required...entry is login
    {

        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }

    if (val[0] == 'required' && val[1] == 'email') // required...entry is email
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            if (validateEmail($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }

    if (val[0] == 'none' && val[1] == 'email') // required...entry is email
    {
        if ($('#' + field).val() != '') {
            if (validateEmail($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }


    if (val[0] == 'required' && val[1] == 'none') // entry required...any data
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }


    if (val[0] == 'required' && val[1] == 'phone') // required...entry is phone
    {

        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            if (validatePhone($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }

    if (val[0] == 'none' && val[1] == 'phone') // empty OK...entry is phone
    {

        if ($('#' + field).val() != '') {
            if (validatePhone($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        } else if ($('#' + field).val() == '') {
            $('#' + field).attr('src', '/images/complete.png');
            return true;
        }
    }
    if (val[0] == 'none' && val[1] == 'phone') // empty OK...entry is phone
    {

        if ($('#' + field).val() != '') {
            if (validatePhone($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        } else if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/complete.png');
            return true;
        }
    }
    if (val[0] == 'required' && val[1] == 'ssn') // empty OK...entry is phone
    {
        if ($('#' + field).val() != '') {
            if (validateSsn($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        } else if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        }
    }

    if (val[0] == 'required' && val[1] == 'cvv') //
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            if (validateCvv($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }

    if (val[0] == 'required' && val[1] == 'zip') //
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/incomplete.png');
            return false;
        } else if ($('#' + field).val() != '') {
            if (validateZip($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }

    if (val[0] == 'none' && val[1] == 'zip') // empty OK...entry is zip
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/blank.jpg');
            return true;
        } else if ($('#' + field).val() != '') {
            if (validateZip($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }
    if (val[0] == 'none' && val[1] == 'number') // empty OK...entry is phone
    {
        if ($('#' + field).val() == '') {
            $('#' + field).next("img").attr('src', '/images/blank.jpg');
            return true;
        } else if ($('#' + field).val() != '') {
            if (validateNumber($('#' + field).val()) == true) {
                $('#' + field).next("img").attr('src', '/images/incomplete.png');
                return false;
            } else {
                $('#' + field).next("img").attr('src', '/images/complete.png');
                return true;
            }
        }
    }
}

function validateCvv(fld) {
    var error = false;
    var stripped = fld.replace(/[\(\)\.\-\ ]/g, '');
    if (isNaN(parseInt(stripped))) {
        error = true;
    } else if (!(stripped.length == 4 || stripped.length == 3)) {
        error = true;
    }
    return error;
}

function validatePhone(fld) {
    var error = false;
    var stripped = fld.replace(/[\(\)\.\-\ ]/g, '');
    if (isNaN(parseInt(stripped))) {
        error = true;
    } else if (!(stripped.length == 10)) {
        error = true;
    }
    return error;
}

function validateEmail(fld) {
    var error = false;
    var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(fld)) {
        error = true;
    }
    return error;
}

function validateSsn(fld) {
    var error = false;
    var stripped = fld.replace(/[\-\ ]/g, '');
    if (isNaN(parseInt(stripped))) {
        error = true;
    } else if (!(stripped.length == 9)) {
        error = true;
    }
    return error;
}

function validateZip(fld) {
    var error = false;
    var stripped = fld.replace(/[\-\ ]/g, '');
    if (isNaN(parseInt(stripped))) {
        error = true;
    } else if (!((stripped.length == 5) || (stripped.length == 9))) {
        error = true;
    }
    return error;
}

function validateNumber(fld) {
    var error = false;
    if (isNaN(parseInt(fld))) {
        error = true;
    }
    return error;
}

function getfileName(myFile){
    var file = myFile.files[0];
    var filename = file.name;
    jQuery(".inputfile").siblings('span').html(filename);
}

//global change
function globalGetfileName(myFile){
    var file = myFile.files[0];
    console.info(file);
    var filename = file.name;
    jQuery("span.inputfilename").html(filename);
}

function globalGetImagefileName(myFile){
    var file = myFile.files[0];
    console.info(file);
    var filename = file.name;
    jQuery("span.inputimagefilename").html(filename);
}

function validateRadio(field, attr) {

    var val = attr.split("~");
    if (val[0] == 'required' && val[1] == 'radio') // required...entry is email
    {
        var test = $('input:radio[name=' + field + ']:checked').val();
        // alert(test);
        var theid = '';
        theid = '#' + field + 'td';
        if (typeof test == 'undefined') {
            $(theid).css('background-color', '#ff6666');
            return false;
        } else {
            $(theid).css('background-color', '#ffffff');
            return true;
        }
    }

}

function checkthemall() {
    if($('#selactionall').is(':checked')) {
        $( "input:checkbox[id^=selaction]").each(function() {
            if($(this).attr('id') != 'selactionall') {
                console.log("ass");
                $(this).prop('checked',true);
            }
        });
    }
    else {
        $( "input:checkbox[id^=selaction]").each(function() {
            if($(this).attr('id') != 'selactionall') {
                console.log("gas");
                $(this).prop('checked',false);
            }
        });
    }
}

function domainNameValid(nname) {

    var arr = new Array(
        '.com','.net','.org','.biz','.coop','.info','.museum','.name',
        '.pro','.edu','.gov','.int','.mil','.ac','.ad','.ae','.af','.ag',
        '.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw',
        '.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bm',
        '.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.ca','.cc',
        '.cd','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr',
        '.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz',
        '.ec','.ee','.eg','.eh','.er','.es','.et','.fi','.fj','.fk','.fm',
        '.fo','.fr','.ga','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm',
        '.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gv','.gy','.hk','.hm',
        '.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq',
        '.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki',
        '.km','.kn','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li',
        '.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.md','.mg',
        '.mh','.mk','.ml','.mm','.mn','.mo','.mp','.mq','.mr','.ms','.mt',
        '.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng',
        '.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf',
        '.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py',
        '.qa','.re','.ro','.rw','.ru','.sa','.sb','.sc','.sd','.se','.sg',
        '.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.sv',
        '.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tm','.tn',
        '.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um',
        '.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.ws',
        '.wf','.ye','.yt','.yu','.za','.zm','.zw','.xyz','.solutions',
        '.online','.lock','.rocks','.mortgage','.today','.team','.group','.loans','.club','.vip','.app','.shop');

    var mai = nname;
    var val = true;

    var dot = mai.lastIndexOf(".");
    var dname = mai.substring(0,dot);
    var ext = mai.substring(dot,mai.length);

    if(dot>2 && dot<57)
    {
        for(var i=0; i<arr.length; i++)
        {
            if(ext == arr[i])
            {
                val = true;
                break;
            }
            else
            {
                val = false;
            }
        }
        if(val == false)
        {
//                     alert("Your domain extension "+ext+" is not correct");
            return false;
        }
        else
        {
            for(var j=0; j<dname.length; j++)
            {
                var dh = dname.charAt(j);
                var hh = dh.charCodeAt(0);
                if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123) || hh==45 || hh==46)
                {
                    if((j==0 || j==dname.length-1) && hh == 45)
                    {
                        //            alert("Domain name should not begin are end with '-'");
                        return false;
                    }
                }
                else	{
//                             alert("Your domain name should not have special characters");
                    return false;
                }
            }
        }
    }
    else
    {
        return false;
    }
    return true;
}

// This is a functions that scrolls to #{blah}link
function goToByScroll(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
      // Scroll
    if(id != "" && id !== undefined){
        if( $("#"+id).offset() !== undefined) {
            $('html,body').animate({
                    scrollTop: $("#" + id).offset().top - 100
                },
                'slow');
        }
    }
}


var notification = {
    error: function(container, msg){
        var text = $("<div></div>").html(msg).addClass('alert alert-danger');
        $(container).css({"display":"block"});
        $(container).html(text);
        //console.log($(container)[0].outerHTML);
        $(container).find('.alert').fadeTo(3000, 500).slideUp(500, function(){
            $(container).find('.alert').slideUp(500);
        });
    },
    success: function(container, msg){
        var text = $("<div></div>").html(msg).addClass('alert alert-success');
        $(container).css({"display":"block"});
        $(container).html(text)

        $(container).find('.alert').fadeTo(3000, 500).slideUp(500, function(){
            $(container).find('.alert').slideUp(500);
        });
    },
    info: function(container, msg){
        var text = $("<div></div>").html(msg).addClass('alert alert-info');
        $(container).css({"display":"block"});
        $(container).html(text)

        $(container).find('.alert').fadeTo(3000, 500).slideUp(500, function(){
            $(container).find('.alert').slideUp(500);
        });
    },
    loading: function(container, msg){
        if(!msg){
            msg = "Processing..."
        }
        var text = $("<div></div>").html("<img src="+site.baseUrl+site.lpAssetsPath+ "/adminimages/ajax-loader_1.gif/> "+msg).addClass('alert alert-success');
        $(container).css({"display":"block"});
        $(container).html(text)
    }
}

$(window).on('load', function() {
    $(".alert").each(function(){
        if($(this).is(":visible")){
            $(this).fadeTo(3000, 500).slideUp(500, function(){
                $(this).slideUp(500);
            });
        }
    });


});

/**
 * HTML special character decode
 * @param string
 * @returns {*}
 */
function parseHTML (string) {
    // var str = $.parseHTML(string);
    // return str[0].textContent;

    // INFO: removing html parsing for now, because it was one of the reasons with
    // slow page loads
    // TODO: implement alternative for html parsing
    return string
}

/**
 * funnel name and tags search some special characters with special define string
 * @param str
 * @returns {string|*[]|*}
 */
function strReplace(str){
    if(str) {
        if (jQuery.isArray(str)) {
            selected_tag_list = new Array();
            jQuery.each(str,function (k,v){
                v = v.replace(/&/g, mzac_lp_and);
                v = v.replace(/,/g,mzac_lp_comma);
                v = v.replace(/</g,mzac_lp_less);
                v = v.replace(/>/g,mzac_lp_greater);
                selected_tag_list.push(v);
            });
            return selected_tag_list;
        } else {
            str = str.replace(/&/g, mzac_lp_and);
            str = str.replace(/,/g,mzac_lp_comma);
            str = str.replace(/</g,mzac_lp_less);
            str = str.replace(/>/g,mzac_lp_greater);
            return str;
        }
    }else{
        return '';
    }
}
function strReplaceOrg(str){
    if(str) {
        if (jQuery.isArray(str)) {
            selected_tag_list = new Array();
            jQuery.each(str,function (k,v){
                v = v.replace(/mzac_lp_and/g, '&');
                v = v.replace(/mzac_lp_comma/g, ',');
                v = v.replace(/mzac_lp_less/g, '<');
                v = v.replace(/mzac_lp_greater/g, '>');
                selected_tag_list.push(parseHTML(v));
            });
            return selected_tag_list;
        }else {
            str = str.replace(/mzac_lp_and/g, '&');
            str = str.replace(/mzac_lp_comma/g, ',');
            str = str.replace(/mzac_lp_less/g, '<');
            str = str.replace(/mzac_lp_greater/g, '>');
            return parseHTML(str);
        }
    }else{
        return '';
    }
}
