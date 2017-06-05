import { createStore,combineReducers, applyMiddleware } from 'redux'
import thunk from 'redux-thunk'
import carTypeReducer from './car_types'
import carReducer from './cars'
import userReducer from './users'

const reducers = combineReducers({
    carTypeReducer,
    carReducer,
    userReducer
})

export default createStore(reducers, applyMiddleware(thunk))
/**
 * Created by thomas_2 on 30.04.2017.
 */
