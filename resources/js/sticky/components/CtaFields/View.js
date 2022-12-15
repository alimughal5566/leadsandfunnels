import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';
import {actions, select} from './Reducer';
import { validateUrl } from '@/utils';


export default class CtaFields extends ViewComponent {

    init() {
        this.phoneFieldInit();
    }

    initEvents(){
        $('.sticky-popup-wrap').on('change', '.checker-number-wrap input[type="checkbox"]', this.callback(this.onPhoneToggle));
        
        $('#sticky-text').on('input paste', this.callback(this.resetCtaTextError))
        
        $('#sticky-phone-number').on('input paste', this.callback(this.resetPhoneError))

        $('#sticky-btn').on('input paste', this.callback(this.resetCtaBtnTextError))
        
        $('#url').on('input paste', this.callback(this.resetWebsiteUrlError))

        $('#sticky-text, #sticky-phone-number, #sticky-btn, #url').on('change input paste', this.onFieldsChange);

        this.subscribe(this.renderPhoneField, select.phoneEnabled)
    }

    resetCtaTextError(e){
        const $ctaTextWrap = $('.sticky-cta-text-wrap');
        $ctaTextWrap.removeClass('has-error');
    }

    resetCtaBtnTextError(e){
        const $ctaBtnTextWrap = $('.sticky-cta-btn-wrap');
        $ctaBtnTextWrap.removeClass('has-error');
    }


    phoneFieldInit() {
        $('#sticky-phone-number').inputmask('(999) 999-9999');
    }

    onFieldsChange(){
        $(document).trigger('lp:sticky:stateChanged');
    }

    resetPhoneError(e){
        const $phoneWrap = $('.number-slide .sticky-side__field-wrap');
        $phoneWrap.removeClass('has-error');
    }

    resetWebsiteUrlError(e){
        const $urlFieldWrap = $('.sticky-wesbite-url');
        $urlFieldWrap.removeClass('has-error');  
    }

    onPhoneToggle(event, {dispatch}) {

        if(this.checked){
            dispatch(actions.enablePhoneNumber());
        } else {
            dispatch(actions.disablePhoneNumber());
        }
    }

    renderPhoneField(value){

        if( parseInt(value) ){
            $('.number-slide').slideDown(() => {
                $('.number-slide input').focus().get(0).setSelectionRange(1,1)
            });
        } else {
            $('.number-slide').slideUp()
        }

        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }

}