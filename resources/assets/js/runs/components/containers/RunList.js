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
            <div className="display">
                {this.props.runs.map(run => {
                    return (
                        <div key={run.id} id={run.id} className={run.status} style={{marginRight:"0px"}} >
                            <div className="row run" style={{marginLeft:"15px", paddingRight:"-10px"}}>
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