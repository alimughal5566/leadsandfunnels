import {createSlice} from '@reduxjs/toolkit';
import {getDefaults} from '@/InitialStateMapper';


const ctaSlice = createSlice({
    name: 'cta',
    initialState: getDefaults(),
    
    reducers: {
        updateCtaText(state, action) {
            state.stickyCtaText = action.payload;
        },

        updateCtaBtnText(state, action) {
            state.stickyCtaBtnText = action.payload;
        },
        
        enablePhoneNumber(state) {
            state.stickyCtaPhoneEnabled = 1
        },

        disablePhoneNumber(state) {
            state.stickyCtaPhoneEnabled = 0
        },

        updateFunnelUrl(state, action){
            state.funnelUrl = action.payload
        }
    }
});


export const select = {
    phoneEnabled: state => state.stickyCtaPhoneEnabled,
    ctaText     : state => state.stickyCtaText,
    ctaBtnText  : state => state.stickyCtaBtnText,
    funnelUrl   : state => state.funnelUrl
}

export const {actions} = ctaSlice

export default ctaSlice.reducer;
