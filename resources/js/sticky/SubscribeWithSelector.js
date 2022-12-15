

let prevState = null;
let currentState = null;


export function enhanceReducer(reducer) {
    
    return function(state, action){
        
        prevState = state;
    
        currentState = reducer(state, action);
    
        return currentState;
    }
}

export function subscribe(store, listener, selector) {

    let firstRender = true;

    return store.subscribe(function (){

        if((!currentState || currentState === prevState) && !firstRender) {
            return
        }
        
        if(typeof selector === 'function'){
        
            const currentSelectedState = selector(currentState)
            
            if(prevState && currentSelectedState === selector(prevState) && !firstRender){
                return
            }

            firstRender = false;
            listener(currentSelectedState, currentState, store);

            return
        }
        
        
        firstRender = false;
        listener(currentState, store);
    });
}

export function isStateChanged(selector) {
    
    if(typeof selector === 'function'){
        return selector(currentState) !== selector(prevState);
    }

    return currentState !== prevState;
}



export default subscribe;