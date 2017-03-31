import React, {PropTypes} from 'react'
import {connect} from 'react-redux'
import WaypointList from './../views/WaypointList'
import RunDetails from './../views/RunDetails'
import Status from './../views/Status'
import {getRuns} from './../../actions/runs'

class App extends React.Component
{
    constructor(props){
        super(props);
    }
    componentDidMount(){
        this.props.dispatch(getRuns())
    }
    render(){
        return (
            <div>
                {this.props.runs.map(run => (
                    <div key={run.id} id={run.id} className="run">
                        <Status status={run.status} />
                        <RunDetails title={run.title} nb_passenger={run.nb_passenger} />
                        <WaypointList points={run.waypoints} />
                    </div>
                ))}
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    console.log(state)
    return {
        runs: state.runs
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch
    }
}

export default connect(mapStateToProps)(App)