/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import DevTools from './containers/DevTools'

const App = () => (
    <div>
        <Filters />
        <RunList />
        <DevTools />
    </div>
)

export default App