    (function ($) {
    var EmailFire = {

        bindVerticalsEvent: function () {
            $('.verticals').click(function () {
                var _this = $(this);
                $(".verticals").removeClass('selected');
                _this.addClass('selected');
                EmailFire.resetCheckboxes();
                $.ajax({
                    url: "getsubs",
                    type: "POST",
                    dataType: 'text',
                    data : "vertical=" + _this.data('value'),
                    success: function (data) {
                        //console.info(data);
                        $(".funneltext").html('');
                        $(".funneltext").html('Select Funnel');
                        //$(".funnels ul").empty();
                        $(".subverticaltext").html('');
                        $(".subverticaltext").html('Select Sub-Vertical');
                        $(".sub-vertical ul").empty();
                        $(".sub-vertical ul").append(data);
                        leadPops_DropDown.bindEvent();
                        EmailFire.bindSubVerticalsEvent();
                    },
                    error: function () {
                        alert("failure");
                    }
                });
            });
        },
        bindSubVerticalsEvent: function () {
            $('.subverticalitem').click(function () {
                var _this = $(this);
                $(".subverticalitem").removeClass('selected');
                _this.addClass('selected');
                EmailFire.resetCheckboxes();
                $.ajax({
                    url: "getfunnels",
                    type: "POST",
                    dataType: 'text',
                    data : "vertical=" + $('.vertical-list li.selected').data('value') + "&subvertical_group_id=" + _this.data('value'),
                    success: function (data) {
                        //console.info(data);
                        $(".funneltext").html('');
                        $(".funneltext").html('Select Funnel');
                        $(".funnels ul").empty();
                        $(".funnels ul").append(data);
                        leadPops_DropDown.bindEvent();
                        EmailFire.bindFunnelEvent();
                    },
                    error: function () {
                        //alert("failure");
                    }
                });
            });
        },
        bindFunnelEvent: function () {
            $('.funnelslist').click(function () {
                var _this = $(this);
                $(".funnelslist").removeClass('selected');
                _this.addClass('selected');
                EmailFire.resetCheckboxes();
                $.ajax({
                    url: "getfunnelcurrentgroups",
                    dataType: 'json',
                    type: "POST",
                    data : "funnelurl=" + $('.funnel-list li.selected').data('value'),
                    success: function (data) {
                        $.each(data, function (index, el) {
                            jQuery("#emmacheckboxes input[type=checkbox]."+el).prop("checked", true);
                        });
                    },
                    error: function () {
                        alert("failure");
                    },
                    cache : false,
                    async : false
                });
            });
        },
        bindSaveEvent:function () {
            $('#saveemma').click(function () {


                var valv = jQuery(".vertical-list .selected").data('value');

                var vals = jQuery(".sub-vertical .selected").data('value');

                var funnelurl = jQuery(".funnels .selected").data('value');
                //alert(vals);

                if (typeof valv !== "undefined" && typeof vals != "undefined" && typeof funnelurl != "undefined") {
                    var emmagroups = $("#emmacheckboxes input:checkbox:checked").map(function(){
                        return $(this).val();
                    }).get();

                    var emmagroupstring = emmagroups.join("~").toString();
                    var emmaaccountid = jQuery("#emmaaccountid").val();
                    var client_id = jQuery("#client_id").val();



                    $.ajax( {
                        type : "POST",
                        url : "savefunnelgroups",
                        data : "emmaaccountid=" + emmaaccountid + "&client_id=" + client_id  + "&emmagroups=" + emmagroupstring + "&funnelurl=" + funnelurl + "&vertical=" + valv + "&subvertical=" + vals ,
                        success : function(data) {
                            var obj = jQuery.parseJSON(data);
                            $("#status").html(obj.status);
                            $("#message").html(obj.message);
                            $("#success-alert").removeClass('hidden');
                        },
                        cache : false,
                        async : false
                    });
                }
                else {
                    alert("Please select vertical, sub-vertical and funnel");
                }


            });
        },
        bindSelectProductEvent:function () {
            $('.email_fire').click(function () {
                var _this = $(this);

                if(_this.data('value')==0){
                    $('#emailfiremodel').modal('show');
                    return false;
                }
                else {
                    //window.location.href = _this.attr('href');
                    if(_this.attr('data-redirect')==1){
                        window.location.href = _this.attr('href');
                    } else if(_this.hasClass('email_firelogin-box')){
                        $('#emailfire').modal('show');
                        return false;
                    }
                }
            });
        },
        resetCheckboxes: function () {
            $('#emmacheckboxes input[type=checkbox]').prop("checked", false);
        },
        submitProcess: function(){

        },
        formValidate: function(){
            var is_valid = true;

            return is_valid;
        },
        formSuccess: function(){

        },
        formError: function(){

        },

    };
    $(document).ready(function() {
        leadPops_DropDown.bindEvent();
        EmailFire.bindVerticalsEvent();
        EmailFire.bindSaveEvent();
        EmailFire.bindSelectProductEvent();

    });
})(jQuery);

var leadPops_DropDown = {
    bindEvent: function (elm) {
        if(elm===undefined){
            elm = $('.lp-dropdown .dropdown-list li');
        }
        elm.click(function () {
            leadPops_DropDown.itemSelect($(this));
        });
    },
    itemSelect: function (_this) {
        var _lp_dropdown = _this.closest('.lp-dropdown');
        _lp_dropdown.find('.verText').text(_this.text().trim());

    }
};



