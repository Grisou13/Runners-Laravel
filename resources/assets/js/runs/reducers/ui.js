import {TOGGLE_DISPLAY_MODE} from "../actions/consts";
import {UI_LOADED} from "../actions/consts";
import {GOT_RUNS} from "../actions/consts";
/**
 * Created by thomas_2 on 29.04.2017.
 */


const state = {
    displayMode: false,
    loaded:false
}

export default (state = state, action) => {
    switch(action.type){
        case TOGGLE_DISPLAY_MODE:
            return {...state, displayMode: !state.displayMode}
        case GOT_RUNS:
            return {...state, loaded:true}
        default:
            return state;
    }
}