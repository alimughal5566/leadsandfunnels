import StickyBar from './StickyBar'
import $ from 'jquery'
import queryString from 'query-string'
import { find } from 'lodash'


$(document).ready(() => {
    $(document).on('click', '.sticky-bar-btn_v2, #sticky-bar-btn-menu', function (e) {

        e.preventDefault();
        const funnelData = getFunnelObject($(this).attr('data-funnel_hash') || [])
        
        const stickyBar = new StickyBar(this, funnelData || {});
        stickyBar.init();
    })

    /**
     * Finds and returns funnel data object if found or undefined otherwise
     * @param {string} hash funnel hash
     */
    function getFunnelObject(hash){
        const allFunnelData = window.rec || JSON.parse(window.funnel_json) || []
        const funnelData = find(allFunnelData, funnel => funnel.hash === hash)
        return funnelData
    }

    /**
     * This load the sticky bar if sticky bar persistant URL is opened
     */
    function loadStickyBarIfStickyUrl(){
        const query = queryString.parse(window.location.search)
        const hash = query['sticky-bar']
    
        if(!hash) return

        requestAnimationFrame(() => {
            let $link = $(`a[data-funnel_hash="${hash}"]`)
            const funnelData = getFunnelObject(hash)

            if(!$link.length && typeof stickBar === 'function'){
                if(!funnelData) return 

                const link = stickBar(funnelData, 0)
                if(!link) return
                $link = $(link)
            } 

            if(!$link.length) return
        
            const stickyBar = new StickyBar($link.get(0), funnelData || {});
            stickyBar.init();
        })
    }


    loadStickyBarIfStickyUrl()

    /**
     * Finds and returns funnel data object if found or undefined otherwise
     * @param {string} id sticky bar ID
     */
    function getFunnelObjectByStickyId(id){
        const allFunnelData = window.rec || JSON.parse(window.funnel_json) || []
        const funnelData = find(allFunnelData, funnel => String(funnel.sticky_id) === String(id))
        return funnelData
    }

    const $stickySwitchModal = $('.modal-sticky-bar-switch-dialog')
    $stickySwitchModal.find('.sticky-switch-btn').click(function (e) {
        e.preventDefault();

        const id = $(this).data('stickySwitchId') || '0';

        let $link = $(`a[data-sticky_id="${id}"]`)
        const funnelData = getFunnelObjectByStickyId(id)

        if(!$link.length && typeof stickBar === 'function'){
            if(!funnelData) return 

            const link = stickBar(funnelData, 0)
            if(!link) return
            $link = $(link)
        } 

        if(!$link.length) return
    
        $('.sticky-close-btn').trigger('click')
        $stickySwitchModal.modal('hide')
        requestAnimationFrame(() => {
            const stickyBar = new StickyBar($link.get(0), funnelData || {});
            stickyBar.init();
        })
    })

    $stickySwitchModal.find('.button-cancel').click(function (e){
        e.preventDefault();
        $('#sticky-popup-wrap #url').val('').focus()
    })

})

