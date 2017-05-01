import {TOGGLE_DISPLAY_MODE} from "../actions/consts";
import {UI_LOADED} from "../actions/consts";
import {GOT_RUNS} from "../actions/consts";
import {FETCHING_RUN_FAILED} from "../actions/consts";
/**
 * Created by thomas_2 on 29.04.2017.
 */


const defaultState = {
    displayMode: false,
    loaded:false,
    error:false
}

export default (state = defaultState, action) => {
    switch(action.type){
        case TOGGLE_DISPLAY_MODE:
            return Object.assign({}, state, {displayMode: !state.displayMode})
        case GOT_RUNS:
            return Object.assign({}, state, {loaded: true})
        case FETCHING_RUN_FAILED:
            return Object.assign({}, state, {loaded: true, error: action.error})
        default:
            return state;
    }
}