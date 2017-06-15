/**
 * Created by Thomas on 02.05.2017.
 */
import React from 'react'
import Filters from './containers/Filters'
import RunList from './containers/RunList'
import PropTypes from "prop-types";
import {connect} from 'react-redux'
import {toggleDisplayMode} from './../actions/display'
import ui from 'redux-ui';

class App extends React.Component{

    render() {
        const {
          displayModeEnabled,
          toggleDisplayMode
        } = this.props
        let cl = displayModeEnabled ? "glyphicon-remove" : "glyphicon-fullscreen"
        return (
            <div className={["app-container ",displayModeEnabled ? "display" : ""].join(" ")}>
                {/*<div className={ui.displayModeEnabled ? "display" : null}>*/}
                    {displayModeEnabled ? (<div className="hidden"><Filters /></div>) : <Filters />}
                    <button className="display-toggle" onClick={()=>toggleDisplayMode()}>
                        <span className={["glyphicon", cl].join(" ")}/>
                    </button>
                    <RunList />
                {/*</div>*/}
            </div>
        )
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
        toggleDisplayMode: () => dispatch(toggleDisplayMode())
    }
}
export default connect(mapStateToProps, mapDispatchToProps)(App)
