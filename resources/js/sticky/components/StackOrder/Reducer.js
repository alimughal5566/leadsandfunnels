import {createSlice} from '@reduxjs/toolkit';
import {getDefaults} from '@/InitialStateMapper';


const stackOrderSlice = createSlice({
    name: 'advancedSettings/stackOrder',
    initialState: getDefaults(),
    
    reducers: {
        setStackOrderType(state, action){
            state.stickyZindexOption = parseInt(action.payload)
        },

        setZindex(state, action){
            state.stickyZindex = parseInt(action.payload)
        },
    }
});


export const select = {
    stackOrderType: state => state.stickyZindexOption,
    zIndex        : state => state.stickyZindex,
}

export const {actions} = stackOrderSlice

export default stackOrderSlice.reducer;
