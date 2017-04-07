import React from 'react'
import { render } from 'react-dom'
import { Provider } from 'react-redux'
import App from './components/containers/RunEditableList'
import store from './reducers'

render(
    <Provider store={store}>
        <App />
    </Provider>,
    document.getElementById('run-list')
)