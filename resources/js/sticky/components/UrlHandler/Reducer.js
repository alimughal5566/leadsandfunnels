import {createSlice} from '@reduxjs/toolkit';
import {getDefaults} from '../../InitialStateMapper';


const urlSlice = createSlice({
    name: 'url',
    initialState: getDefaults(),
    
    reducers: {
        showOnWholeWebsite(state) {
            state.showStickyOnSpecificPages = '1';
        },
        
        showOnSpecificPages(state) {
            state.showStickyOnSpecificPages = '0';
        },

        updateWebsiteUrl(state, action){
            state.stickyWebsiteUrl = action.payload;
        }
    }
});


export const select = {
    targetPagesOption: state => state.showStickyOnSpecificPages,
    websiteUrl       : state => state.stickyWebsiteUrl,
}

export const {actions} = urlSlice

export default urlSlice.reducer;
