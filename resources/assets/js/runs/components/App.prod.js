/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import PropTypes from "prop-types";
import {connect} from 'react-redux'

import ui from 'redux-ui';

@ui({
    key:"root-app",
    state:{
        displayModeEnabled : false
    }
})
const App = ({uiKey, ui, updateUI, resetUI}) => {
    let cl = displayModeEnabled ? "glyphicon-remove" : "glyphicon-fullscreen"
    return (
        <div className="app-container">
            <div className={ui.displayModeEnabled ? "display" : null}>
                <Filters />
                <button className="display-toggle" onClick={()=>updateUI({displayModeEnabled: true})}>
                    <span className={["glyphicon",cl].join(" ")} />
                </button>
                <RunList />
            </div>
        </div>
    )
}
App.propTypes = {
    uiKey: PropTypes.any.isRequired,
    ui: PropTypes.obj.isRequired,
    updateUI: PropTypes.func.isRequired,
    resetUI: PropTypes.func.isRequired,
}
const mapStateToProps = (state) => {
    return {
        // displayModeEnabled : state.displayMode
    }
}
const mapDispatchToProps = (dispatch) => {
    return {
        // toggle: () => dispatch(toggleDisplayMode())
    }
}
export default connect(mapStateToProps, mapDispatchToProps)(App)
