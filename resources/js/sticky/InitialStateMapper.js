export function getDefaults() {
    return {
        // Funnel index number in admin view
        funnelIndex : 0,

        // Funnel link capitilized
        funnelUrlCapitilized : '',

        // Funnel id 
        funnelId : 0,

        // Sticky bar id
        stickyId : 0,

        // Sticky bar cta text
        stickyCtaText : 'Do you know how much home you can afford?',

        // Sticky cta button text
        stickyCtaBtnText : 'Get Pre-Approved Now!',

        // Sticky target website url
        stickyWebsiteUrl : 'example.com',
        
        // Sticky funnel url
        funnelUrl : '',

        // Sticky bar active status
        stickyActiveStatus : 0,

        // Show/Hide close button on sticky bar
        stickyShowCloseBtn : 0,

        // Sticky bar size
        stickySize : 'f',
        
        // Sticky installation pending flag/status
        stickyPendingStatus : 0,
        
        // Website pages paths on which to show sticky bar
        stickyWebsitePaths : '',
        
        // Show sticky on specific pages instead of whole website
        showStickyOnSpecificPages : '1',

        // Sticky bar location on page
        stickyLocation : 't',
        
        // Sticky script type (with script tag or without script tag)
        stickyScriptType : 'a',
        
        // Sticky z-index
        stickyZindex : '1000000',
        
        // Sticky z-index setting option
        stickyZindexOption : 1,
        
        // Sticky cta button click to call phone number
        stickyCtaPhoneNumber : '',
        
        // Unique sticky hash used for sticky js script
        stickyHash : '',

        // Should phone number be used on cta button click action instead of funnel
        stickyCtaPhoneEnabled : 0
    }
}

export function getDataToAttrsMap() {
    return {
        funnelIndex              : 'data-index',
        funnelUrlCapitilized     : 'data-field',
        funnelId                 : 'data-id',
        stickyId                 : 'data-sticky_id',
        stickyCtaText            : ['data-sticky_cta', 'data-v_sticky_cta'], // fallback attributes
        stickyCtaBtnText         : ['data-sticky_button', 'data-v_sticky_button'],
        stickyWebsiteUrl         : 'data-sticky_url',
        funnelUrl                : ['data-sticky_funnel_url', 'data-field' ],
        stickyActiveStatus       : 'data-sticky_status',
        stickyShowCloseBtn       : 'data-sticky_show_cta',
        stickySize               : 'data-sticky_size',
        stickyPendingStatus      : 'data-pending_flag',
        stickyWebsitePaths       : 'data-sticky_page_path',
        showStickyOnSpecificPages: 'data-sticky_website_flag',
        stickyLocation           : 'data-sticky_location',
        stickyScriptType         : 'data-sticky_script_type',
        stickyZindex             : 'data-sticky_zindex',
        stickyZindexOption       : 'data-sticky_zindex_type',
        stickyCtaPhoneNumber     : 'data-sticky_phone_number',
        stickyHash               : 'data-sticky_js_file',
        stickyCtaPhoneEnabled    : 'data-sticky_phone_number_checked'
    }
}

export function getAttrToInputMap(){
    return {
        text: {
            'data-id' : 'client_leadpops_id',
            'data-sticky_cta' : 'bar_title',
            'data-v_sticky_cta' : 'bar_title',
            'data-sticky_button' : 'cta_title',
            'data-v_sticky_button' : 'cta_title',
            'data-sticky_url' : 'cta_url',
            'data-sticky_status' : 'sticky_status',
            'data-sticky_show_cta' : 'cta_icon',
            'data-sticky_size' : 'size',
            'data-pending_flag' : 'pending_flag',
            'data-sticky_location' : 'pin_flag',
            'data-sticky_script_type' : 'sticky_script_type',
            'data-sticky_zindex' : 'zindex',
            'data-sticky_zindex_type' : 'zindex_type',
            'data-sticky_phone_number' : 'cta_title_phone_number',
            'data-sticky_js_file' : 'insert_flag',
            'data-sticky_website_flag' : 'pages_flag',
        },
        checkbox: {
            'data-sticky_phone_number_checked' : 'cta_phone_number_checker',
        },
        array: {
            'data-sticky_page_path' : 'pages[]',
        }
    }
}

export function getAttrToObjectMap(){
    return {
        text: {
            'data-id' : 'client_leadpop_id',
            'data-sticky_cta' : 'sticky_cta',
            'data-v_sticky_cta' : 'v_sticky_cta',
            'data-sticky_button' : 'sticky_button',
            'data-v_sticky_button' : 'v_sticky_button',
            'data-sticky_url' : 'sticky_url',
            'data-sticky_status' : 'sticky_status',
            'data-sticky_show_cta' : 'show_cta',
            'data-sticky_size' : 'sticky_size',
            'data-pending_flag' : 'pending_flag',
            'data-sticky_location' : 'sticky_location',
            'data-sticky_script_type' : 'sticky_script_type',
            'data-sticky_zindex' : 'zindex',
            'data-sticky_zindex_type' : 'zindex_type',
            'data-sticky_phone_number' : 'stickybar_number',
            'data-sticky_js_file' : 'sticky_js_file',
            'data-sticky_website_flag' : 'sticky_website_flag',
        },
        checkbox: {
            'data-sticky_phone_number_checked' : 'stickybar_number_flag',
        },
        array: {
            'data-sticky_page_path' : 'sticky_url_pathname',
        }
    }
}

export default class InitialStateMapper {

    constructor(attrs){
        this.attrs = attrs;
    }

    map() {

        const attrs = this.attrs;

        const defaults = getDefaults();

        const map = getDataToAttrsMap();

        const data = {};

        for(let key in map){
            
            data[key] = defaults[key];

            let value = map[key];

            if(!Array.isArray(value)){
                value = [value];
            } 

            for(let i = 0; i < value.length; i++){
                
                const attr = attrs[value[i]];

                if(attr != 'null' && attr !== ''){
                    data[key] = attr;
                    break;
                }
            }
        }

        return data;
    }
}