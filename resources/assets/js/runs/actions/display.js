import { UI } from './consts'

export const enableDisplayMode = () => ({
  type: UI.ENABLE_DISPLAY_MODE
})
export const disableDisplayMode = () => ({
  type: UI.DISABLE_DISPLAY_MODE
})
export const toggleDisplayMode = () => ({
  type: UI.TOGGLE_DISPLAY_MODE
})
