import React from 'react'
import { render } from 'react-dom'
import { Provider } from 'react-redux'
import App from './components/App'
import store from './reducers'
import services from './services'
import {enableDisplayMode} from './actions/display'
console.log(process.env.NODE_ENV)
services(store.dispatch)
if( typeof window.forceDisplayMode !== "undefined" && window.forceDisplayMode)
    store.dispatch(enableDisplayMode())
render(
    <Provider store={store}>
        <App />
    </Provider>,
    document.getElementById('run-app')
)
