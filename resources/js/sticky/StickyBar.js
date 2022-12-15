import $ from 'jquery';
import {resetCache} from './jQueryCache';
import {configureStore} from '@reduxjs/toolkit';
import ComponentManager from './ComponentManager';
import InitialStateMapper from './InitialStateMapper';
import ReducerManager from './ReducerManager';
import queryString from 'query-string';


export default class StickyBar {
    
    constructor(element, funnelObj){
        this.$el = $(element);
        this.funnelObj = funnelObj;
    }

    createStore(initialState){

        const manager = new ReducerManager(initialState);

        const reducer = manager.getReducer();

        const store = configureStore({
            reducer,
            preloadedState: initialState,
            devTools: {
                name: "Sticky Bar"
            }
        })

        return store;
    }

    getAttributes(){
        const attrs = {};

        $.each(this.$el.get(0).attributes, function () {
            if(this.specified){
                attrs[this.name] = this.value;
            }
        });

        return attrs;
    }

    init(){

        const attrs = this.getAttributes();

        const mapper = new InitialStateMapper(attrs);
        
        const data = mapper.map();

        this.store = this.createStore(data);

        this.createPopup();

        requestAnimationFrame(() => {
            
            const manager = new ComponentManager(this.store, data, this.$el, this.funnelObj);
    
            manager.init();
    
            this.reduxInitAction()
    
            this.show();
            this.addStickyQueryString(attrs)
    
            $('.sticky-close-btn').click(this.destory.bind(this));
        })
    }

    reduxInitAction(){
        this.store.dispatch({
            type: 'stickybar/init'
        })
    }

    show(){
        
        $('body').addClass('sticky-bar-setting-popup-shown');
    }

    createPopup(){

        const popupHtml = $('#sticky-popup-html').html();

        $('#wrapper').after(popupHtml);
    }

    destory(e){
        e.preventDefault();
        resetCache();

        $('body').removeClass('sticky-bar-setting-popup-shown');        
        $('#sticky-popup-wrap').trigger('lp:stickyBar:destroy').remove();

        this.removeStickyQueryString()
    }

    addStickyQueryString(attrs){
        if(!window.history || !window.history.pushState) return        
        const query = queryString.parse(window.location.search)

        const hash = attrs['data-funnel_hash']
        if(!hash) return

        query['sticky-bar'] = hash

        const newQuery = queryString.stringify(query)

        const newPath = window.location.pathname + (newQuery ? '?' + newQuery : '')
        window.history.replaceState(null, '', newPath)
    }

    removeStickyQueryString(){
        if(!window.history || !window.history.pushState) return        
        const query = queryString.parse(window.location.search)

        if(!Object.keys(query).length) return

        delete query['sticky-bar']
        const newQuery = queryString.stringify(query)

        const newPath = window.location.pathname + (newQuery ? '?' + newQuery : '')
        window.history.replaceState(null, '', newPath)
    }
}


