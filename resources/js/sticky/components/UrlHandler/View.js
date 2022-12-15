
import $ from '@/jQueryCache';
import { validateUrlPath } from '@/utils';
import ViewComponent from '@/ViewComponent';
import { actions, select } from './Reducer';
import { debounce } from 'lodash';


export default class UrlHandler extends ViewComponent {

    init() {
        this.urlPathValidationInit();
    }

    initEvents(){
        $('.switcher-area').on('change', '.radio-switcher input[type="radio"]', this.callback(this.onStickyTargetPagesChange))
        $('.input-url').keyup( this.callback(this.onUrlUpdate) )
        
        this.subscribe(this.renderSpecificPagesAccordian, select.targetPagesOption)
    }

    urlPathValidationInit () {

        const $wrapper = $('.sticky-popup-wrap');

        $wrapper.on('keydown', '.input-url-path', function (e){
            const $self = $(this);
            if (e.keyCode === 13) {
                $self.parents('.url-slide__detail').find('.add-url-btn').click();
            } else {
                const value = $self.val();
                const valid = validateUrlPath(value);
                if (valid) {
                    $self.parents('.url-add-field').removeClass('has-error');
                }
            }
        });
    }

    onUrlUpdate(e, {dispatch}){
        const url = $(this).val();
        dispatch( actions.updateWebsiteUrl( url ) )
    }

    onStickyTargetPagesChange(e, {dispatch}){
        const val = $(this).val()

        if(val == '0' || val == ''){
            dispatch(actions.showOnSpecificPages());
        } else {
            dispatch(actions.showOnWholeWebsite());
        }
    
    }
    
    renderSpecificPagesAccordian(onSpecificPages){
        
        if(onSpecificPages === '' || onSpecificPages === '0'){
            $('#specific-pages-option').prop('checked', true);
            $('.switcher-area .slide').slideDown();
        } else {
            $('#all-pages-flag').prop('checked', true);
            $('.switcher-area .slide').slideUp();
        }

        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }
}