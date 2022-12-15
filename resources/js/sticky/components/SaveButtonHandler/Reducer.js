import {createSlice} from '@reduxjs/toolkit';
import {getDefaults} from '@/InitialStateMapper';


const saveHandlerSlice = createSlice({
    name: 'saveHandler',
    initialState: getDefaults(),
    
    reducers: {
      updateStickyScriptType(state, action){
        state.stickyScriptType = action.payload
      }
    }
});


export const select = {
    stickyScriptType   : state => state.stickyScriptType
}

export const {actions} = saveHandlerSlice

export default saveHandlerSlice.reducer;
