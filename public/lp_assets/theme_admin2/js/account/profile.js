(function ($) {
    var module = {
        init: function(){
            if( $('input[name=textcell]:checked').val() == 'y'){
                $(".text_cell_carrier").slideDown();
            }else{
                $(".text_cell_carrier").slideUp();
            }

            $('input[name=textcell]').change(function(e){
                if($(this).val() == 'y')
                    $(".text_cell_carrier").slideDown();
                else
                    $(".text_cell_carrier").slideUp();

            });

            //module.formSubmit();
        },
        formSubmit: function(){
            $(".acc-submit-btn").click(function(e){
                if(module.formValidate()){
                    $('#fcontactinfo').submit();
                }else{
                    module.formError();
                }
            });
        },
        formValidate: function(){
            var is_valid = true;
            //LP-TODO: Develop the validation logic here
            return is_valid;
        },
        formSuccess: function(){

        },
        formError: function(){

        }
    }

    $(document).ready(function() {
        module.init();
        selector = $('#cell_phone');
        var im = new Inputmask("(999) 999-9999");
        im.mask(selector);
        $('#cell_phone').keyup(function(e){
            console.log(e.keyCode);
            if(e.keyCode == 8)
            {
                return true;
            }
            /*console.log($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))*/
            if(e.keyCode > 36 && e.keyCode < 41)
            {
                return true;
            }
            if ((e.keyCode > 47 && e.keyCode <58) || (e.keyCode < 106 && e.keyCode > 95))
            {
                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'($1) $2-$3'))
                //this.value = this.value.replace(/(\d{3})\-?/g,'$1-');
                return true;
            }
            //this.value = this.value.replace(/[^\-0-9]/g,'');
            this.value = this.value.replace(/[\-\(\)\W]/g,'');
        });


    });

})(jQuery);
