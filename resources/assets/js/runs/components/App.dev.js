/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import DevTools from './containers/DevTools'
import {toggleDisplayMode} from "../actions/ui";
import PropTypes from "prop-types";
import {connect} from 'react-redux'


const App = ({displayModeEnabled, toggle}) => {
    let cl = displayModeEnabled ? "glyphicon-remove" : "glyphicon-fullscreen"
    return (
        <div className="app-container">
            <div className={displayModeEnabled ? "display" : null}>
                <Filters className="filters" />
                <button className="display-toggle" onClick={toggle}>
                    <span className={["glyphicon",cl].join(" ")} />
                </button>
                <RunList />
            </div>

            {/*<DevTools />*/}
        </div>
    )
}
App.propTypes = {
    displayModeEnabled: PropTypes.bool.isRequired,
    toggle: PropTypes.func.isRequired
}
const mapStateToProps = (state) => {
    return {
        displayModeEnabled : state.displayMode
    }
}
const mapDispatchToProps = (dispatch) => {
    return {
        toggle: () => dispatch(toggleDisplayMode())
    }
}
export default connect(mapStateToProps, mapDispatchToProps)(App)