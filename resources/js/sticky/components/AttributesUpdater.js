import $ from '@/jQueryCache';
import {unserialize} from '@/utils'
import { getAttrToInputMap, getAttrToObjectMap } from '@/InitialStateMapper';
import ViewComponent from '@/ViewComponent';
import $_ from 'jquery';

export default class AttrsAndStateAdapter extends ViewComponent {

    initEvents(){
        $('#sticky-popup-wrap').on('lp:sticky:updateElementAttrs', this.callback(this.onUpdateAttrs))
    }

    onUpdateAttrs(e, {view, store}) {
        
        const allFieldsMap = getAttrToInputMap();
        // this would also update values in funnel object so that
        // after filtering adn rendering it gets latest values
        const allFieldsToObjectMap = getAttrToObjectMap();

        const state = unserialize($('#sticky-bar-form').serialize());

        const $element = view.relocateElementInDom(view.$element);
        const funnelObj = view.funnelObj;

        let map = allFieldsMap.text;
        let objMap = allFieldsToObjectMap.text;

        for(let attr in map){
            
            if( state.hasOwnProperty(map[attr]) ){
            
                $element.attr(attr, state[map[attr]]);
                funnelObj[objMap[attr]] = state[map[attr]]
            }
        }

        map = allFieldsMap.checkbox;
        objMap = allFieldsToObjectMap.checkbox;

        for(let attr in map){
            
            const value = state[map[attr]];

            $element.attr(attr, value ? '1' : '0');
            funnelObj[objMap[attr]] = value ? '1' : '0';
        }

        map = allFieldsMap.array;
        objMap = allFieldsToObjectMap.array;

        for(let attr in map){
            
            if( state.hasOwnProperty(map[attr]) ){

                const value = state[map[attr]];

                if(Array.isArray(value)){
                
                    $element.attr(attr, value.join('~'));
                    funnelObj[objMap[attr]] = value.join('~');
               
                } else {
                
                    $element.attr(attr, value);
                    funnelObj[objMap[attr]] = value;
                
                }
            
            }
        }
    }

    /**
     * This function relocates sticky bar anchor element in DOM
     * because in case of sticky persistant shareable URL 
     * the element defined in view as this.$element may not
     * be the element present in DOM
     * @param {object} $element jQuery anchor element
     */
    relocateElementInDom($element){
        const hash = $element.attr('data-funnel_hash')
        if(!hash) $element

        const $locatedElement = $_(`a[data-funnel_hash="${hash}"]`)
        
        if($locatedElement.length){
            return $locatedElement
        }

        return $element
    }
}