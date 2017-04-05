import React, {PropTypes} from 'react'
import {connect} from 'react-redux'
import moment from 'moment'
import {getRuns} from './../../actions/runs'

import WaypointList from './../views/WaypointList'
import RunDetails from './../views/RunDetails'
import Status from './../views/Status'
import SubscriptionList from './../views/SubscriptionList'
import Time from './../views/Time'
class RunList extends React.Component
{
    constructor(props){
        super(props);
    }
    componentDidMount(){
        this.props.dispatch(getRuns())
    }
    render(){
        let runs = _.sortBy(this.props.runs,["status","begin_at"])
        return (
            <div className="display container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {runs.map(run => {
                        var date = moment(run.begin_at)
                        var d = run.begin_at ? `${date.format("DD/MM")}` : null
                        var t = run.begin_at ? `${date.format("HH:mm")}` : null
                        return (
                            <div key={run.id} id={run.id} className={run.status} style={{marginRight:"34px", marginLeft:"23px"}} >
                                <div className="row run" style={{marginLeft:"15px", paddingRight:"-10px"}}>
                                    <RunDetails title={run.title} nb_passenger={run.nb_passenger} date={d} />
                                    <div className="row col-md-6 col-xs-12">
                                        <div className="row">
                                            <WaypointList run={run} points={run.waypoints} />
                                        </div>
                                        <div className="row">
                                            <span style={{fontWeight:"bold"}}>{ t }</span>
                                        </div>
                                    </div>

                                    <SubscriptionList subs={run.runners} />
                                </div>

                            </div>
                        )
                    })}
                </div>
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