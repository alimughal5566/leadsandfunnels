
import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';
import {actions, select} from './Reducer';
import {debounce} from 'lodash';
import {numberWithCommas} from '@/utils';


export default class StackOrder extends ViewComponent {

    init() {
        this.selectInit();
        this.rangeSliderInit();
    }

    initEvents(){
        $('.sticky-popup-wrap').on('change', '.sb-radio-options input[type="radio"]', this.callback(this.onStackOrderTypeChange))
        $('.sticky-popup-wrap').on('change', '#sticky-website-zindex', this.callback(this.onWebsiteZindexSelectChange))
        $('#ex1').on('slide', debounce(this.callback(this.onZindexSlide), 400))

        this.subscribe(this.renderStackOrderOptionType, select.stackOrderType)
        this.subscribe(this.updateZindexValueOnOptionChange, select.stackOrderType)
        this.subscribe(this.updateZindexInputOnChange, select.zIndex)
    }

    selectInit() {

        $('.select-holder__slide').slideUp();
        $('.select-holder .select-holder__opener').click(function(e) {
            e.preventDefault();
            var _self = $(this);
            _self.parent().toggleClass('select-active');
            _self.next().slideToggle();
        });

        $('.list-options__link').click(function(e){
            e.preventDefault();
            var _self = $(this);
            var clickedItem = _self.html();
            _self.parents('.select-holder__slide').slideUp();
            _self.parents('.select-holder').find('.select-holder__opener').html(clickedItem);
        });

        $(document).on("click", function(e) {
            if ($(e.target).is('.select-holder__opener'))  return false;
            else {
                $('.select-holder').removeClass('select-active');
                $('.select-holder__slide').slideUp();
            }
        });

        let amIclosing = false;
        
        $('#sticky-website-zindex').select2({
            minimumResultsForSearch: -1,
            dropdownParent: $(".provider-select-parent"),
            width: '100%'
        }).on('select2:openning', function() {
            $('.provider-select-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            $('.provider-select-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                $('.provider-select-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            $('.provider-select-parent .select2-dropdown').hide();
            $('.provider-select-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            $('.provider-select-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                $('.provider-select-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    $('#sticky-website-zindex').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            $('.provider-select-parent .select2-selection__rendered').show();
            $('.provider-select-parent .select2-results__options').css('pointer-events', 'auto');
        });
    }

    rangeSliderInit(){

        const $valBox = $('#slider-val');

        $('#ex1').bootstrapSlider({
            formatter: function(value) {
                $valBox.html(numberWithCommas(value))
            },
            value: $('#zindex').val()
        });

        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }

    onZindexSlide(e, {dispatch}){
        dispatch(actions.setZindex( $(this).val() ))
    }

    onStackOrderTypeChange(e, {dispatch}){
        const val = $(this).val();

        dispatch(actions.setStackOrderType(val));
    }

    renderStackOrderOptionType(type){
        const $option = $(`.sb-radio-options input[type=radio][value='${type}']`);

        const id = $option.attr('data-title');

        $('.list-tab-item').slideUp();

        $(`#${id}`).slideDown();

        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }

    onWebsiteZindexSelectChange(e, {dispatch}){
        dispatch(actions.setZindex( $(this).val() ))
    }

    updateZindexValueOnOptionChange(type, state, store){
        type = parseInt(type)

        if(type === 1){
        
            store.dispatch(actions.setZindex('1000000'))
        
        } else if (type == 2){
        
            const zIndex = $('#ex1').val();
            store.dispatch(actions.setZindex(zIndex))
            
        } else if (type == 3){
            
            const zIndex = $('#sticky-website-zindex').val()
            store.dispatch(actions.setZindex(zIndex))
        }
    }

    updateZindexInputOnChange(zIndex){
        $('#zindex').val(zIndex);
    }

}