import { createStore,combineReducers, applyMiddleware } from 'redux'
import thunk from 'redux-thunk'
import runs from './runs'
import filterReducer from './filters'
import uiReducer from './ui'
const reducers = combineReducers({
    runs,
    filters: filterReducer,
    ui: uiReducer
})

export default createStore(reducers, applyMiddleware(thunk))