import { createStore,combineReducers, applyMiddleware, compose } from 'redux'
import thunk from 'redux-thunk'
import runs from './runs'
import filterReducer from './filters'
import displayReducer from './display'
import { reducer as rUiReducer } from 'redux-ui'
import DevTools from './../components/containers/DevTools';
import {middleware as wsMiddleware} from './../services/websocket';
const reducers = combineReducers({
    filters: filterReducer,
    ui: rUiReducer,
    display:displayReducer,
    runs
})
const enhancer = compose(
    // Middleware you want to use in development:
    applyMiddleware(thunk, wsMiddleware),
    // Required! Enable Redux DevTools with the monitors you chose
    DevTools.instrument(),
    // Optional. Lets you write ?debug_session=<key> in address bar to persist debug sessions
);
const initialState = {}
export default createStore(reducers, initialState , enhancer)
