import { createStore,combineReducers, applyMiddleware } from 'redux'
import thunk from 'redux-thunk'
import runs from './runs'
import statusFilter from './statusFilter'

const reducers = combineReducers({
    runs,
    statusFilter
})

export default createStore(reducers, applyMiddleware(thunk))