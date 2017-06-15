import {UI} from "../actions/consts";

const defaultState = {
  enabled: false
}

const display = (state = defaultState, action) => {
  switch (action.type) {
    case UI.ENABLE_DISPLAY_MODE:
      return {...state, enabled: true}
    case UI.DISABLE_DISPLAY_MODE:
      return {...state, enabled: false}
    case UI.TOGGLE_DISPLAY_MODE:
      return {...state, enabled: !state.enabled}
    default:
      return state
  }
}

export default display
