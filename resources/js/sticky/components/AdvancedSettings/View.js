
import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';
import {actions, select} from './Reducer';

export default class AdvancedSettings extends ViewComponent {

    init() {
        this.openCloseInit();
    }

    initEvents(){
        $('.setting-open-close__opener').click(this.callback(this.onSettingsSlideToggle))
        $('.sticky-popup-wrap').on('change', '.sticky-close-toggle', this.callback(this.onCloseBtnShowHide))
        $('.sticky-popup-wrap').on('change', '.sticky-position-handler', this.callback(this.onStickyLocationChange))
        $('.sticky-popup-wrap').on('change', '.sticky-size-handler', this.callback(this.onSickySizeChange))

        this.subscribe(this.renderCloseBtnSetting, select.showCloseBtn)
        this.subscribe(this.renderStickyPositionSettings, select.stickyLocation)
        this.subscribe(this.renderStickySizeSettings, select.stickySize)
    }

    onSettingsSlideToggle(e){
        e.preventDefault();
        var _self = $(this);
        
        _self.parent().toggleClass('slide-active');
        _self.next().slideToggle();
        
        setTimeout(function () {
            $('.owl-carousel').trigger('refresh.owl.carousel');
        }, 600);
    }

    openCloseInit() {
        $('.setting-open-close__slide').slideUp();
    }

    onCloseBtnShowHide(e, {dispatch}){
        if($(this).val() == '1'){
            dispatch(actions.showCloseBtn());
        } else {
            dispatch(actions.hideCloseBtn());
        }
    }

    renderCloseBtnSetting(show){
        if(parseInt(show)){
            $('#sticky-close-toggle_show').prop('checked', true);
            $('.sticky-bar__close').fadeIn();
        } else {
            $('#sticky-close-toggle_hide').prop('checked', true);
            $('.sticky-bar__close').fadeOut();
        }
    }

    onStickyLocationChange(e, {dispatch}){
        if($(this).val() == 't'){
            dispatch(actions.stickToTop());
        } else{
            dispatch(actions.stickToBottom());
        }
    }

    renderStickyPositionSettings(location){
        if(location == 't'){
            $('.sticky-bar').removeClass('fixed-bottom');
            $('.sticky-content').removeClass('bottom-align');
        } else {
            $('.sticky-bar').addClass('fixed-bottom');
            $('.sticky-content').addClass('bottom-align');
        }
    }

    onSickySizeChange(e, {dispatch}){
        const val = $(this).val();

        if(val == 'f'){
            dispatch(actions.setFullSize())
        } else if(val == 'm'){
            dispatch(actions.setMediumSize())
        } else if(val == 's'){
            dispatch(actions.setSlimSize())
        }
    }

    renderStickySizeSettings(size){
        if (size == 'f') {
            $('.sticky-bar').removeClass('sticky-slim sticky-medium');
            $('.sticky-content').removeClass('content-slim content-medium');
        }
        else if (size == 'm') {
            $('.sticky-bar').removeClass('sticky-slim');
            $('.sticky-bar').addClass('sticky-medium');
            $('.sticky-content').removeClass('content-slim').addClass('content-medium'); 
        }
        else if (size == 's') {
            $('.sticky-bar').removeClass('sticky-medium');
            $('.sticky-bar').addClass('sticky-slim');
            $('.sticky-content').removeClass('content-medium').addClass('content-slim');
        }
    }

}