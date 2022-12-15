
import $ from '@/jQueryCache';
import $_ from 'jquery';
import ViewComponent from '@/ViewComponent';

export default class SettingsPanel extends ViewComponent {

    init() {
        this.updateStateOnInputs();
    }

    updateStateOnInputs(){

        const $element = this.$element;

        let map = this.getDataToInputMap();

        for(let attr in map){
            const val = $element.attr(attr);
            if(val !== undefined && val.length && val != 'null'){
                $(map[attr]).val(val)
            }
        }

        map = this.getDataToRadioMap();

        for(let attr in map){
            const value = $element.attr(attr);

            $(`${map[attr]}[value='${value}']`).prop('checked', true);
        }

        this.updateStackOrderTypeSlide();
        this.updateSpecificPages();
        this.updateUrlWebsiteOption();
        this.updateCtaText();
        this.updateCtaBtnText();
        this.updateFunnelUrl();
        this.updatePhoneEnableOption();
        this.updateLocationOption();
        this.updateSizeOption();
        this.updateSticyStatusOption();

        this.updateCarousal();
    }


    getDataToInputMap() {
        return {
            'data-id' : '#client_leadpops_id',
            'data-sticky_js_file' : '#insert_flag',
            'data-sticky_status' : '#sticky_status',
            'data-pending_flag' : '#pending_flag',
            'data-sticky_script_type' : '#sticky_script_type',
            'data-sticky_url' : '#url',
            'data-sticky_phone_number' : '[name="cta_title_phone_number"]',
            'data-sticky_zindex' : '[name="zindex"]',
        }
    }
    
    getDataToRadioMap(){
        return {
            'data-sticky_location' : '[name="pin_flag"]',
            'data-sticky_show_cta' : '[name=cta_icon]',
            'data-sticky_size' : '[name=size]',
            'data-sticky_zindex_type' : '[name=zindex_type]',
        }
    }

    updateStackOrderTypeSlide(){

        const type = this.$element.attr('data-sticky_zindex_type');
        const zIndex = this.$element.attr('data-sticky_zindex');

        const $option = $(`.sb-radio-options input[type=radio][value='${type}']`);

        if(type == '3'){
            $('#sticky-website-zindex').val(zIndex)
        }

        const id = $option.attr('data-title');

        $('.list-tab-item').slideUp();

        $(`#${id}`).slideDown();

        this.updateCarousal();
    }

    updateUrlWebsiteOption(){
        const $element = this.$element;

        const websiteFlagAttr = $element.attr('data-sticky_website_flag')

        const onSpecificpages = websiteFlagAttr === '' || websiteFlagAttr === '0'

        if(onSpecificpages){
            $('#specific-pages-option').prop('checked', true);
            $('.switcher-area .slide').slideDown();
        } else {
            $('#all-pages-flag').prop('checked', true);
            $('.switcher-area .slide').slideUp();
        }
    }

    updateCtaText(){
        const $element = this.$element;

        let ctaText = $element.attr('data-sticky_cta');
        let defaultCtaText = $element.attr('data-v_sticky_cta');

        defaultCtaText = typeof defaultCtaText === 'string' && defaultCtaText.length && defaultCtaText != 'null' ? defaultCtaText : site.stickyBarDefaultText;

        ctaText = typeof ctaText === 'string' && ctaText.length && ctaText != 'null' ? ctaText : defaultCtaText;

        $('[name=bar_title]').val(ctaText);
        
        $('#sticky-bar__p').html(ctaText);
    }
    
    updateFunnelUrl(){
        const $element = this.$element;

        let funnelUrl = $element.attr('data-sticky_funnel_url');

        funnelUrl = typeof funnelUrl === 'string' && funnelUrl.length && funnelUrl != 'null' ? funnelUrl : $element.attr('data-field');

        $('#site').val(funnelUrl.toLowerCase());
    }

    updateCtaBtnText(){
        const $element = this.$element;

        let ctaBtnText = $element.attr('data-sticky_button');

        ctaBtnText = typeof ctaBtnText === 'string' && ctaBtnText.length && ctaBtnText != 'null' ? ctaBtnText : $element.attr('data-v_sticky_button');

        $('[name=cta_title]').val(ctaBtnText);

        $('#sticky-bar__btn').html(ctaBtnText);
    }

    updatePhoneEnableOption(){
        const $element = this.$element;

        const isPhoneChecked = !!parseInt($element.attr('data-sticky_phone_number_checked'));

        $('#phone-number_checker').prop('checked', isPhoneChecked)

        if(isPhoneChecked){
            $('.number-slide').slideDown(() => {
                $('.number-slide input').focus().get(0).setSelectionRange(1,1)
            });
        } else {
            $('.number-slide').slideUp()
        }
    }

    updateLocationOption(){
        const $element = this.$element;

        const stickyLocation = $element.attr('data-sticky_location') || 't';

        if(stickyLocation == 't'){
            $('.sticky-bar').removeClass('fixed-bottom');
            $('.sticky-content').removeClass('bottom-align');
        } else {
            $('.sticky-bar').addClass('fixed-bottom');
            $('.sticky-content').addClass('bottom-align');
        }
    }

    updateSizeOption(){
        const $element = this.$element;

        const stickySize = $element.attr('data-sticky_size') || 'f';

        if (stickySize == 'f') {
            $('.sticky-bar').removeClass('sticky-slim sticky-medium');
            $('.sticky-content').removeClass('content-slim content-medium');
        }
        else if (stickySize == 'm') {
            $('.sticky-bar').removeClass('sticky-slim');
            $('.sticky-bar').addClass('sticky-medium');
            $('.sticky-content').removeClass('content-slim').addClass('content-medium'); 
        }
        else if (stickySize == 's') {
            $('.sticky-bar').removeClass('sticky-medium');
            $('.sticky-bar').addClass('sticky-slim');
            $('.sticky-content').removeClass('content-medium').addClass('content-slim');
        }
    }

    updateSticyStatusOption(){
        const $element = this.$element;

        const stickyStatus = !!parseInt($element.attr('data-sticky_status'));

        $('#sticky-activate-btn').prop('checked', stickyStatus);
    }

    updateCarousal(){
        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }

    updateSpecificPages(){
        const $element = this.$element;

        let pages = $element.attr('data-sticky_page_path') || '';

        pages = pages == 'null' ? '' : pages;

        if(pages == '' || pages == '~'){
            return
        }

        pages = pages.split('~');

        const self = this;

        $('.url-fields-wrap').html('')

        pages.forEach((path) => {
            
            if(path == '/'){
                $('#sticky-homepage-path-checkbox').prop('checked', true);
            } else {

                const html = self.getNewFieldHtml();

                const $field = $_(html);

                $field.find('input').val(path);

                $('.url-fields-wrap').append($field);
            }
        })
    }


    getNewFieldHtml() {
        return `<div class="url-add-field">
                    <div class="field">
                        <label><i class="ico-link"></i></label>
                        <input class="form-control input-url-path" name="pages[]" type="text" placeholder="/url-path-goes-here">
                        <a href="#" class="close-field"><i class="ico-cross"></i></a>
                        <span class="error-message">Please Enter a valid Path</span>
                    </div>
                    <div class="url-message">
                        <span class="text">Are you sure you want to delete this path?</span>
                        <ul class="url-option">
                            <li><a href="#" class="remove-url">YES</a></li>
                            <li><a href="#" class="active-url">NO</a></li>
                        </ul>
                    </div>
                </div>`
    }
}