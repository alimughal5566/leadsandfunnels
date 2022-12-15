
import $ from '@/jQueryCache';
import $_ from 'jquery';
import {validateUrl} from '@/utils';
import ViewComponent from '@/ViewComponent';
import {select as urlHandlerSelect} from '@components/UrlHandler/Reducer';
import {debounce} from 'lodash';
import imagesLoaded from 'imagesloaded';
import FormValidator from '../FormValidator';


export default class UrlPreview extends ViewComponent {

    init(){
        this.url = ''
        this.currentScreenshotUrl = ''
        this.screenshotLink = ''
        this.maxTries = 15
        this.tryInterval = 2000
        this.currentTryCount = 0
        this.timerId = null

        this.onFetchError()
        this.renderUrlPreview($('#url').val())
    }

    initEvents(){
        $('#sticky-website-preview-btn').click(this.callback(this.onClickRenderPreview))
        $('#url').on('keyup', this.callback(this.onKeyupInUrlInput))
        $('#sticky-popup-wrap').on('lp:stickyBar:destroy', this.removeTimerCallback.bind(this))
    }

    renderUrlPreview(url){        
        url = this.formatUrl(url)

        if (this.shouldRenderPreviewFor(url)) {
            this.resetErrorMessageState()
            this.loadingNewPreview()
            this.fetchScreenshot(url);
            this.url = url
        }

        this.updatePreviewButtonStateFor(url)
    }

    formatUrl(url){
        if(!url) return ''
        const schemeRegex = /^(https?\:\/\/)/
        url = url.trim();
        url = schemeRegex.test(url) ? url : `http://${url}`;
        return url
    }

    shouldRenderPreviewFor(url){        
        if(url.indexOf('example') > -1){
            return false
        }
        
        if(this.currentScreenshotUrl == url){
            return false
        }

        this.currentScreenshotUrl = ''

        if(this.url == url){
            return false
        }

        return validateUrl(url)
    }

    updatePreviewButtonStateFor(url){
        url = this.formatUrl(url)
        if(this.shouldRenderPreviewFor(url)){
            this.enablePreviewButton()
        } else {
            this.disablePreviewButton()
        }
    }

    fetchScreenshot(url){
        $_.ajax({
            type : "POST",
            dataType: 'json',
            url : '/lp/popadmin/captureScreenshot',
            data : { url },
            success : this.onFetchSuccess.bind(this),
            error: this.onFetchError.bind(this)
        });
    }

    onFetchSuccess(data){
        if(data.success){
            this.screenshotLink = `${site.screenshotServiceUrl}/${data.hash}.png`
            this.currentTryCount = 0
            this.tryNewScreenshot();
        } else {
            this.onFetchError();
        }
    }

    tryNewScreenshot(){
        
        if(this.currentTryCount > this.maxTries){
            this.currentTryCount = 0

            this.onIncompatibleWebsiteError()            
            return
        }

        this.currentTryCount++
        this.createImageElement(this.screenshotLink)
    }

    removeTimerCallback(){
        clearTimeout(this.timerId)
    }

    onClickRenderPreview(event, {view}){
        event.preventDefault()
        view.renderUrlPreview($('#url').val())
    }

    onKeyupInUrlInput(event, {view}){
        const url = $('#url').val()

        view.updatePreviewButtonStateFor(url)

        const key = event.which || event.keyCode
        // enter is pressed
        if(key == 13){
            view.renderUrlPreview(url)
        }
    }
    
    enablePreviewButton(){
        $('#sticky-website-preview-btn').removeAttr('disabled')
    }
    
    disablePreviewButton(){
        $('#sticky-website-preview-btn').attr('disabled', true)
    }

    loadingNewPreview(){
        $('.lp-sticky-bar__text-loader').html('website preview is loading...');
        $('.sticky-popup-wrap').removeClass('iframe-active');
    }

    onFetchError(){
        this.removeMessageStateClasses()
        $('.lp-sticky-bar__text-loader').html('ADD URL TO SEE PREVIEW...');
        $('.sticky-popup-wrap').removeClass('iframe-active');
        this.currentScreenshotUrl = ''
        this.url = ''
        this.updatePreviewButtonStateFor($('#url').val())
    }

    onIncompatibleWebsiteError(){
        const msg = 'This website is not compatible with this functionality. Please select another website.'
        $('.lp-sticky-bar__text-loader').html(msg);
        $('.sticky-popup-wrap').addClass('sticky-incompatible-website-error')
        $('.sticky-wesbite-url').addClass('sticky-invalid-website-url')
        
        this.validateUrlField()

        $('.sticky-popup-wrap').removeClass('iframe-active');
        this.currentScreenshotUrl = ''
        this.url = ''
        this.updatePreviewButtonStateFor($('#url').val())

        requestAnimationFrame(function(){
            $('.owl-carousel').trigger('refresh.owl.carousel');
        })
    }

    resetErrorMessageState(){
        this.removeMessageStateClasses()
        this.validateUrlField()
    }
    
    removeMessageStateClasses(){
        $('.sticky-popup-wrap').removeClass('sticky-incompatible-website-error')
        $('.sticky-wesbite-url').removeClass('sticky-invalid-website-url sticky-url-already-exists')
    }

    validateUrlField(){
        const form = new FormValidator();
        form.validateWebsiteUrl();
    }

    onScreenshotLoadError(){
        clearTimeout(this.timerId)

        this.timerId = setTimeout(() => {
            this.tryNewScreenshot()
        }, this.tryInterval);
    }

    onScreenshotImageLoaded(){
        $('.sticky-popup-wrap').addClass('iframe-active')
        this.currentScreenshotUrl = this.url
    }


    createImageElement(src){

        const $screenshotWrap = $('#sticky-url-screenshot-wrap');

        $screenshotWrap.find('.sticky-url-screenshot').remove();

        if(!src){
            src = 'https://via.placeholder.com/1500x1500.png'
        }

        const imageHtml = `<img id="sticky-url-screenshot" class="sticky-url-screenshot" src="${src}">`

        const $image = $_(imageHtml);

        const imageLoad = imagesLoaded( $image.get(0) );

        imageLoad.on('done', this.onScreenshotImageLoaded.bind(this));

        imageLoad.on('fail', this.onScreenshotLoadError.bind(this));

        $screenshotWrap.append($image);
    }
}