
import {TOGGLE_DISPLAY_MODE} from './consts'
import {UI_LOADED} from "./consts";

export const toggleDisplayMode = () => {
    return {
        type: TOGGLE_DISPLAY_MODE,
        payload: null
    }
}

export const uiLoaded = () => {
    return {
        type: UI_LOADED
    }
}