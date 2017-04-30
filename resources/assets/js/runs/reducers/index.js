import { createStore,combineReducers, applyMiddleware } from 'redux'
import thunk from 'redux-thunk'
import runs from './runs'
import filterReducer from './filters'

const reducers = combineReducers({
    runs,
    filterReducer
})

export default createStore(reducers, applyMiddleware(thunk))