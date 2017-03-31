import React, {PropTypes} from 'react'
import {connect} from 'react-redux'

import {getRuns} from './../../actions/runs'

import WaypointList from './../views/WaypointList'
import RunDetails from './../views/RunDetails'
import Status from './../views/Status'
import SubscriptionList from './../views/SubscriptionList'

class RunList extends React.Component
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
                {this.props.runs.map(run => {
                    return (
                        <div key={run.id} id={run.id} className={run.status} style={{"margin-right":"0px"}} >
                            <div className="row run" style={{"margin-left":"10px", "padding-right":"-10px", "margin-right":"0px"}}>
                                <RunDetails title={run.title} nb_passenger={run.nb_passenger} />
                                <WaypointList runId={run.id} points={run.waypoints} />
                                <SubscriptionList subs={run.runners} />
                            </div>

                        </div>
                    )
                })}
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

export default connect(mapStateToProps)(RunList)