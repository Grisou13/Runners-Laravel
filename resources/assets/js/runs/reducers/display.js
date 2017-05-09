import {RESET_DISPLAY_MODE} from "../actions/consts";
import {TOGGLE_DISPLAY_MODE} from "../actions/consts";
import {SET_DISPLAY_MODE} from "../actions/consts";
/**
 * Created by Thomas.RICCI on 08.05.2017.
 */

export const defaultState = false

export default (state = defaultState, action) => {
    switch (action.type){
        case TOGGLE_DISPLAY_MODE:
            return !state
        case SET_DISPLAY_MODE:
            return action.payload
        case RESET_DISPLAY_MODE:
            return defaultState
        default:
            return state
    }
}