
import $ from '@/jQueryCache';
import $_ from 'jquery';
import {select} from '@components/CtaFields/Reducer';
import { validateUrl, validateUrlPath } from '@/utils';
import { notify } from '@/utils'

export default class FormValidator{

    constructor(state){
        this.state = state;
        this.valid = true;
    }
    
    isValid(){
        return this.validate()
    }    

    validate(){
        this.valid = true;

        this.validateCtaTextField();
        this.validatePhoneField();
        this.validateCtaBtnTextField();
        this.validateWebsiteUrl();
        this.validateAllPathFields();

        return this.valid
    }

    validateCtaTextField(){
        const $ctaTextWrap = $('.sticky-cta-text-wrap');
        
        const text = $('#sticky-text').val();

        const $errorMessage = $ctaTextWrap.find('.error-message');
        
        if(!text){
            
            $errorMessage.text('This field is required.');
            $ctaTextWrap.addClass('has-error');
            this.valid = false;
        
        } else {

            $ctaTextWrap.removeClass('has-error');
        
        }
    }

    validatePhoneField(){
        
        const enabled = $('#phone-number_checker').prop('checked');

        if(!enabled){
            return
        }

        const phone = $('#sticky-phone-number').val();

        const phoneRegex = /\(\d{3}\) \d{3}-\d{4}/

        const $errorMessage = $('.number-slide error-message');
        
        if(!phone){
            
            $errorMessage.text('This field is required.');
            this.valid = false

        } else if(!phoneRegex.test(phone)){
            
            $errorMessage.text('Please enter a valid phone number.');
            this.valid = false;
        
        }
        
        const $phoneFieldWrap = $('.number-slide .sticky-side__field-wrap');

        if(!this.valid){
            $phoneFieldWrap.addClass('has-error');
        } else {
            $phoneFieldWrap.removeClass('has-error');
        }
    }

    validateCtaBtnTextField(){
        const $ctaBtnTextWrap = $('.sticky-cta-btn-wrap');
            
        const text = $('#sticky-btn').val();

        const $errorMessage = $ctaBtnTextWrap.find('.error-message');
        
        if(!text){
            
            $errorMessage.text('This field is required.');
            $ctaBtnTextWrap.addClass('has-error');
            this.valid = false;
        
        } else {

            $ctaBtnTextWrap.removeClass('has-error');
        
        }
    }

    validateWebsiteUrl(){

        const url = $('#url').val();

        const $urlFieldWrap = $('.sticky-wesbite-url');

        const $errorMessage = $urlFieldWrap.find('.error-message');

        const isValid = validateUrl(url);

        if(!url){
            
            $errorMessage.text('This field is required.');
            $urlFieldWrap.addClass('has-error');
            this.valid = false;
        
        } else if(!isValid){

            $errorMessage.text('Please enter a valid URL.');
            $urlFieldWrap.addClass('has-error');
            this.valid = false

        } else if(url.indexOf('example') > -1){
            
            $errorMessage.text('Please change the "example" domain');
            $urlFieldWrap.addClass('has-error');
            this.valid = false

            notify.error('Please change the domain example.com');
            
        } else if(! $('.sticky-popup-wrap').hasClass('sticky-incompatible-website-error')) {
            
            $urlFieldWrap.removeClass('has-error');
            
        }
    }

    validateAllPathFields(){

        if( ! $('#specific-pages-option').prop('checked') ){ 
            return
        }
        
        const self = this

        $_('.url-fields-wrap .input-url-path').each(function (){
            
            if( !self.validatePathField( $(this) ) ){
                self.valid = false
            }

        })

    }

    validatePathField(element){

        const $element = $(element);

        const $urlField = $element.parents('.url-add-field');

        const $errorMessage = $urlField.find('.error-message');
                        
        const value = $element.val();
        const valid = validateUrlPath(value);

        if(!value){

            $errorMessage.text('This field is required.');
            $urlField.addClass('has-error');
            return false
            
        } else if (!valid){
            
            $errorMessage.text('Please enter a valid url.');
            $urlField.addClass('has-error');
            return false
            
        } else {
            
            $urlField.removeClass('has-error');
            
        }
        
        return true
    }
}