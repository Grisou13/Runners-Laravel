import { createStore,combineReducers, applyMiddleware, compose } from 'redux'
import thunk from 'redux-thunk'
import runs from './runs'
import filterReducer from './filters'
import { reducer as rUiReducer } from 'redux-ui'
import DevTools from './../components/containers/DevTools';
const reducers = combineReducers({
    filters: filterReducer,
    ui: rUiReducer,
    runs,
})
const enhancer = compose(
    // Middleware you want to use in development:
    applyMiddleware(thunk),
    // Required! Enable Redux DevTools with the monitors you chose
    DevTools.instrument(),
    // Optional. Lets you write ?debug_session=<key> in address bar to persist debug sessions
);
const initialState = {}
export default createStore(reducers, initialState , enhancer)