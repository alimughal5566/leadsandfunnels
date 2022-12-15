import subscribe from "./SubscribeWithSelector";

/**
 * Base clas for view components, extended by all view components
 */
export default class ViewComponent {

    constructor(store, data, $element, funnelObj){
        this.store = store;
        this.data = data;
        this.$element = $element;
        this.funnelObj = funnelObj;
        this.dispatch = store.dispatch.bind(store);

        this.initEvents();
        this.init();
    }

    init() {}

    initEvents() {}


    /** 
     * Proxy method to our extended/optimized subscribe method, this is a convenient
     * method to avoid importing of subscribe function and passing store
     * @param {function} listener
     * @param {function} selector
     */

    subscribe(listener, selector){
        subscribe(this.store, listener, selector)
    }

    /**
     * This function wraps the original callback passed as parameter, the purpose of this function
     * is to send {view, store, dispatch} as second parameter to original callback 'method'
     * so, the original callback 'method' will receive parameter like following: 
     * method(firstParam, {viewInstance, storeInstance, storeBoundDispatch}, ...restOfParams)
     * @param {function} method 
     */
    callback(method){

        const self = this;

        return function (event) {
            return method.apply(this, [ 
                event, 
                {view: self, store: self.store, dispatch: self.dispatch}, 
                Array.prototype.slice.call(arguments, 1) 
            ]);
        }
    }
}