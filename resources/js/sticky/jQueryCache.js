import $ from 'jquery';
import _ from 'lodash';
import "core-js/stable/weak-map"

class jQueryCache {

    constructor(){
        this.elSelectorCache = {};
        this.elObjectCache = new WeakMap();
        this.selectorCache = {};
    }

    prepareSelector(selector){
        return selector.trim().replace(/[\s\n]+/,' ');
    }

    get(selector){
        
        let $el;

        if(_.isString(selector)){
            
            if( !this.selectorCache.hasOwnProperty(selector) ) {
                selector = this.prepareSelector(selector);
            }

            if( this.elSelectorCache.hasOwnProperty(selector) ){
                return this.elSelectorCache[selector];
            }

            $el = $(selector);

            this.elSelectorCache[selector] = $el;

        } else {
            
            if( this.elObjectCache.has(selector) ){
                return this.elObjectCache.get(selector);
            }

            $el = $(selector);

            this.elObjectCache.set(selector, $el);
        }

        return $el;
    }
}

let cache;

export function resetCache(){
    cache = new jQueryCache();
}

resetCache();

export default function (selector){
    return cache.get(selector);
}