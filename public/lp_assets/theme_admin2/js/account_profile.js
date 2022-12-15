(function ($) {
    $(document).ready(function () {
        $(".acc-submit-btn").click(function (e) {
            $.ajax( {
                type : "POST",
                url : "/deletelogo.php",
                data : "logo_id=" + logoid + "&client_id=" + client_id + "&key=" + $('#key').val(),
                success : function(d) {
                    window.location.href = '/popadmin/logoedit';
                },
                cache : false,
                async : false
            });
        })
    });
})(jQuery);
