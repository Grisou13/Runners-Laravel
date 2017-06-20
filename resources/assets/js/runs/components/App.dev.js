/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import PropTypes from "prop-types";
import {connect} from 'react-redux'
import DevTools from './containers/DevTools'
import {toggleDisplayMode} from './../actions/display'
import ui from 'redux-ui';
class App extends React.Component{
    renderApp = () =>{
        const {
            displayModeEnabled
        } = this.props
        let cl = displayModeEnabled ? "glyphicon-remove" : "glyphicon-fullscreen"
        return (
            <div className={["app-container ",displayModeEnabled ? "display" : ""].join(" ")}>
                {displayModeEnabled ? (<div className="hidden"></div>) : <Filters />}
                <button className="display-toggle" onClick={()=>this.props.dispatch(toggleDisplayMode())}>
                    <span className={[ "glyphicon", cl ].join(" ")}/>
                </button>
                <RunList />
                <DevTools />
            </div>
        )
    }
    renderStaticDisplayMode = () => {
        return (
            <div className="app-container display">
                <RunList />
                <DevTools />
            </div>
        )
    }
    render() {
        const force =  typeof window.forceDisplayMode !== "undefined" && window.forceDisplayMode
        if(force)
            return this.renderStaticDisplayMode()
        return this.renderApp()
    }
}
App.propTypes = {
  displayModeEnabled: PropTypes.bool.isRequired,
  toggleDisplayMode: PropTypes.func.isRequired
}
const mapStateToProps = (state) => {
    return {
        displayModeEnabled : state.display.enabled
    }
}
const mapDispatchToProps = (dispatch) => {
    return {
        dispatch
    }
}
export default connect(mapStateToProps, mapDispatchToProps)(App)
