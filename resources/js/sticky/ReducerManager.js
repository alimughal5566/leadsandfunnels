import reduceReducers from 'reduce-reducers';
import {enhanceReducer} from './SubscribeWithSelector';

import ctaFields from '@components/CtaFields/Reducer';
import advancedSettings from '@components/AdvancedSettings/Reducer';
import stackOrder from '@components/StackOrder/Reducer';
import urlHandler from '@components/UrlHandler/Reducer';
import saveHandler from '@components/SaveButtonHandler/Reducer'


export default class ReducerManager {

    constructor(initialState){
        this.initialState = initialState
    }

    getReducer(){

        const reducer = reduceReducers(
            this.initialState,
            ctaFields,
            advancedSettings,
            stackOrder,
            urlHandler,
            saveHandler,
        );

        return enhanceReducer(reducer);
    }

}