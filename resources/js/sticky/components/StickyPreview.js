import $ from '@/jQueryCache';
import {throttle} from 'lodash';
import ViewComponent from '@/ViewComponent';
import {select as advSettingsSelect} from '@/components/AdvancedSettings/Reducer';


export default class StickyPreview extends ViewComponent {

    init() {
        requestAnimationFrame(() => this.scalePreview());
    }

    initEvents(){

        this.throttledScalePreview = throttle( this.scalePreview.bind(this), 100 );

        $(window).resize( this.throttledScalePreview  );
        
        this.subscribe(this.throttledScalePreview, advSettingsSelect.stickyLocation);
        this.subscribe(this.throttledScalePreview, advSettingsSelect.stickySize);

        $('.sticky-popup-wrap').on('keyup', '#sticky-text', this.callback(this.updatePreviewCtaText));
        $('.sticky-popup-wrap').on('keyup', '#sticky-btn', this.callback(this.updatePreviewBtnText));
    }

    scalePreview() {
        
        const winWidth = $(window).width();
        const winHeight = $(window).height();
        const stickyHeight = $('.sticky-bar').outerHeight();
        const sidePanel = $('.sticky-side').outerWidth();
        
        const stickyScale = 1 - sidePanel / winWidth;
        const scaledHeight = stickyHeight * stickyScale
        
        $('.preview-area').css('height', winHeight - scaledHeight);

        $('.sticky-bar').css({'transform': 'scale(' + stickyScale + ')', 'width': winWidth });
    }

    updatePreviewCtaText(e, {view}){
        $('#sticky-bar__p').html($(this).val());
        view.throttledScalePreview();
    }

    updatePreviewBtnText(e, {view}){
        $('#sticky-bar__btn').html($(this).val());
        view.throttledScalePreview();
    }
}