
import {TOGGLE_DISPLAY_MODE} from './consts'
import {UI_LOADED} from "./consts";
import {SET_DISPLAY_MODE} from "./consts";
import {RESET_DISPLAY_MODE} from "./consts";

export const toggleDisplayMode = () => {
    return {
        type: TOGGLE_DISPLAY_MODE
    }
}
export const setDisplayMode = (b) => {
    return {
        type: SET_DISPLAY_MODE,
        payload: b
    }
}
export const resetDisplayMode = () => {
    return {
        type: RESET_DISPLAY_MODE
    }
}

export const uiLoaded = () => {
    return {
        type: UI_LOADED
    }
}