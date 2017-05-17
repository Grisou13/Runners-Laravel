/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import PropTypes from "prop-types";
import {connect} from 'react-redux'
import DevTools from './containers/DevTools'
import ui from 'redux-ui';

@ui({
    key:"root-app",
    state:{
        displayModeEnabled : false
    }
})
class App extends React.Component{
    render() {
        let ui = this.props.ui;
        let updateUI = this.props.updateUI;
        let cl = ui.displayModeEnabled ? "glyphicon-remove" : "glyphicon-fullscreen"
        return (
            <div className="app-container">
                <div className={ui.displayModeEnabled ? "display" : null}>
                    {ui.displayModeEnabled ? (<div className="hidden"><Filters /></div>) : <Filters />}
                    <button className="display-toggle" onClick={()=>updateUI({displayModeEnabled: !ui.displayModeEnabled})}>
                        <span className={["glyphicon", cl].join(" ")}/>
                    </button>
                    <RunList />
                    <DevTools />
                </div>
            </div>
        )
    }
}
App.propTypes = {

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
