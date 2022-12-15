import {createSlice} from '@reduxjs/toolkit';
import {getDefaults} from '@/InitialStateMapper';


const advancedSettingsSlice = createSlice({
    name: 'advancedSettings',
    initialState: getDefaults(),
    
    reducers: {
        showCloseBtn(state){
            state.stickyShowCloseBtn = 1
        },

        hideCloseBtn(state){
            state.stickyShowCloseBtn = 0
        },

        stickToTop(state){
            state.stickyLocation = 't'
        },
        
        stickToBottom(state){
            state.stickyLocation = 'b'
        },

        setFullSize(state){
            state.stickySize = 'f'
        },

        setMediumSize(state){
            state.stickySize = 'm'
        },

        setSlimSize(state){
            state.stickySize = 's'
        },
    }
});


export const select = {
    showCloseBtn  : state => state.stickyShowCloseBtn,
    stickyLocation: state => state.stickyLocation,
    stickySize    : state => state.stickySize,
}

export const {actions} = advancedSettingsSlice

export default advancedSettingsSlice.reducer;
