
import $ from '@/jQueryCache';
import $_ from 'jquery';
import ViewComponent from '@/ViewComponent';
import {notify} from '@/utils';
import FormValidator from '@components/FormValidator';
import { actions } from './Reducer';
import AttrsAndStateAdapter from '../AttributesUpdater';

export default class AjaxHandler extends ViewComponent {

    init(){
        this.stateChanged = false;
    }

    initEvents(){
        $('#sticky-popup-wrap')
            .on('click', '.sticky-submit-btn', this.callback(this.onStickySlideSubmitBtn))
            .on('click', '.owl__btn-next', this.callback(this.onClickOwlNextBtn))
            .on('change', '.sticky-side__head input[type="checkbox"]', this.callback(this.onOnOffToggle))
            .find('.sticky-side .owl-dots button').eq(1).on('click',  this.callback(this.onClickOwlNextBtn));

        $('.sticky-popup-wrap').on('change', '.check-switcher input[type="checkbox"]', this.callback(this.changeScriptTyepAjax))

        $(document).on('lp:sticky:stateChanged', this.onStateChange.bind(this));

        this.subscribe(this.onStateChange.bind(this))
    }

    onStateChange(){
        this.stateChanged = true;
    }

    onSaveStickyBar(e, {store, view}){
        e.preventDefault();

        const state = store.getState();

        const isValid = view.validateForm(state)

        view.saveSuccess = false
        
        if(!isValid){
            return
        }

        if($('#sticky-activate-btn').prop('checked')){
            view.checkFunnelDomainAjax(state, view)
        } else {
            view.resetCheckFunnelDomainFlags()
        }
        view.saveStickyBarAjax(state, view)

        view.updateStickyStatusMessage();
    }

    onOnOffToggle(e, {view}){
        $('#sticky_status').val(this.checked ? '1' : '0')
        
        view.onSaveStickyBar.apply(this, arguments);

        if(!view.saveSuccess){
            $('#sticky-activate-btn').prop('checked', false);
        }
    }

    onClickOwlNextBtn(e, {view}){
        
        e.stopPropagation()
        
        if(!view.stateChanged){
    
            e.preventDefault();

            view.owlMoveToNextSlide();
            return
        }

        view.onSaveStickyBar.apply(this, arguments);

        if(view.saveSuccess){
            view.owlMoveToNextSlide();
        }
    }

    onStickySlideSubmitBtn(e, {view}){

        if(view.stateChanged){
            view.onSaveStickyBar.apply(this, arguments);
        }
    }

    validateForm(state){
        const validator = new FormValidator(state)

        return validator.isValid()
    }

    checkFunnelDomainAjax(state, view) {
        let id = state.stickyId;
        let fallbackId = view.$element.attr('data-sticky_id');
        fallbackId = fallbackId != 'null' && typeof fallbackId === 'string' && fallbackId.length ? fallbackId : id;
        id = parseInt(id) ? id : fallbackId;

        const domain = $('#url').val();
        const allPagesFlag = $('#all-pages-flag').prop('checked');

        let specificPages = '';

        if($('#sticky-homepage-path-checkbox').prop('checked')){
            specificPages = '/';
        }

        $_('.input-url-path').each(function (){
            const path = $(this).val();
            if(path){
                specificPages = path + '~' + specificPages;
            }
        })

        $_.ajax({
            type : "POST",
            url : "/lp/popadmin/checkfunneldomain",
            data : {'id': id, 'sticky_status_db': 1 ,'domain': domain ,'all_pages_flag':allPagesFlag, 'pages': specificPages },
            success : function(data) {
                var obj = $_.parseJSON(data);
                if(obj.status == 'error'){
                    if(parseInt(obj.id)){
                        const $switchModal = $('#modal-sticky-bar-switch-dialog')
                        let url = $('#url').val() || ''
                        url = url.trim()
                        url = url.charAt(0).toUpperCase() + url.slice(1)
                        $switchModal.find('.sticky-switch-website').html(url)
                        $switchModal.find('.sticky-switch-btn').data('stickySwitchId', obj.id);
                        $switchModal.modal('show')
                    } else {
                        notify.error(obj.message);
                    }
                    
                    view.duplicateUrl = 1;
                    $('#duplicate_url').val('1');


                    $('#sticky-activate-btn').prop('checked', false);
                    $('#sticky_status').val(0);
                    $('#pending_flag').val(0);
                    $('.sticky-wesbite-url').addClass('sticky-url-already-exists');

                } else {
                    
                    if(!parseInt(obj.status_flag)){
                        
                        $('#sticky_status').val(0);
                        $('#sticky-activate-btn').prop('checked', false);
                        $('.sticky-wesbite-url').addClass('sticky-url-already-exists');
                        
                    } else {
                        $('.sticky-wesbite-url').removeClass('sticky-url-already-exists');
                    }
 
                    view.duplicateUrl = 0;
                    $('#duplicate_url').val('0');
                }
            },
            cache : false,
            async : false
        });
    }

    resetCheckFunnelDomainFlags(){
        $('.sticky-wesbite-url').removeClass('sticky-url-already-exists');
        this.duplicateUrl = 0;
        $('#duplicate_url').val('0');
    }

    saveStickyBarAjax(state, view){
        
        if(view.duplicateUrl){
            return
        }

        const form_data = $('#sticky-bar-form').serialize();
        $_.ajax({
            type : "POST",
            url : "/lp/popadmin/savestickybar",
            data : form_data,
            success : function(data) {
                var obj = $_.parseJSON(data);
                if(obj.status == 'success'){
                    
                    $('#insert_flag').val(obj.hash);
   
                    view.updateCodeBlock(state.stickyScriptType, obj.hash)

                    view.hash = obj.hash
                    view.saveSuccess = true;
                    if(obj.id){
                        view.$element.attr('data-sticky_id', obj.id);
                        const $element = AttrsAndStateAdapter.prototype.relocateElementInDom(view.$element);
                        $element.attr('data-sticky_id', obj.id);
                        view.funnelObj.sticky_id = obj.id;
                    }


                    $('#sticky-popup-wrap').trigger('lp:sticky:updateElementAttrs')

                    $('#sticky-activate-btn').prop('checked', !!parseInt(obj.sticky.sticky_status));
                    $('#sticky_status').val(obj.sticky.sticky_status);

                    notify.success(obj.message);

                    view.stateChanged = false;
            
                }else{
                    notify.error(obj.message);
                    $('#sticky-activate-btn').prop('checked', false);
                    $('#sticky_status').val(0);
                    view.saveSuccess = false;
                    
                }
            },
            cache : false,
            async : false
        });
    }

    changeScriptTyepAjax(e, {view}){
        
        const type = this.checked ? 'f' : 'a';
        const hash = $('#insert_flag').val();


        $_.ajax({
            type : "POST",
            url : "/lp/popadmin/updatestickycodetype",
            data : {'value':type , 'client_leadpops_id':$('#client_leadpops_id').val()},
            success : function(data) {
                var obj = $_.parseJSON(data);

                if(obj.status == 'success'){
                    
                    notify.success(obj.message);
                    view.updateCodeBlock(type, hash);
                    $('#sticky_script_type').val(type);

                    $('#sticky-popup-wrap').trigger('lp:sticky:updateElementAttrs')

                    $('.owl-carousel').trigger('refresh.owl.carousel');

                }else{
                    
                    notify.error('Your request was not processed. Please try again.');
                    e.preventDefault();
                }
            },
            cache : false,
            async : false
        });
    }

    updateStickyStatusMessage(){
        
        const stickyStatus = parseInt( $('#sticky_status').val() );
        const pendingStatus = parseInt( $('#pending_flag').val() );

        let statusMessage = '';

        if (stickyStatus) {
            if(pendingStatus){
                statusMessage = '(Active)';
            } else {
                statusMessage = '(Pending Installation)';
            }
        } else {
            statusMessage = '(Inactive)';
        }

        this.$element.find('.funnel-sticky-status').text(statusMessage);
        const $element = AttrsAndStateAdapter.prototype.relocateElementInDom(this.$element);
        $element.find('.funnel-sticky-status').text(statusMessage);
        
    }

    updateCodeBlock(type, hash){
        if(type == 'a'){
            $("#code-block").html(this.getScriptWithTagHtml(hash))
            $('#sticky-script-type-checkbox').prop('checked', false);
        } else {
            $("#code-block").html(this.getScriptWithoutTagHtml(hash))
            $('#sticky-script-type-checkbox').prop('checked', true);
        }
        this.dispatch(actions.updateStickyScriptType(type))
    }

    owlMoveToNextSlide(){
        $('.owl-carousel').trigger('next.owl.carousel', [300])
    }

    getScriptWithTagHtml(hash){
        let domain = site.stickyBarScriptDomain || ''

        const urlRegex = /^\s*(https?:\/\/embed\.)(.+?)\s*$/
        const match = domain.match(urlRegex)
        
        if(match){
            domain = match[1] + '</span><span>' + match[2]
        }

        return `&lt!---leadPops Sticky Bar Code Starts Here---><br /><br /> 
                <span class="sticky-script-code-wrap">&lt;script  type="text/javascript" src="${domain}/${hash}.js">&lt;/script></span><br /><br /> 
                &lt!---leadPops Sticky Bar Code Ends Here--->`
    }

    getScriptWithoutTagHtml(hash){
        return `\/* leadPops Sticky Bar Code Starts Here *\/ <br /><br />var lpsticky = document.createElement('script');<br />
                lpsticky.async = true;<br />
                lpsticky.src='${site.stickyBarScriptDomain}/${hash}.js';<br />
                var lpstickytag = document.getElementsByTagName('script')[0];<br />
                lpstickytag.parentNode.insertBefore(lpsticky , lpstickytag); <br /><br />\/* leadPops Sticky Bar Code Ends Here *\/`
    }

}