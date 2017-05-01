import React, {PropTypes} from 'react'
import {connect} from 'react-redux'
import moment from 'moment'
import {getRuns} from './../../actions/runs'

import WaypointList from './../views/WaypointList'
import RunDetails from './../views/RunDetails'
import Status from './../views/Status'
import SubscriptionList from './../views/SubscriptionList'
import Time from './../views/Time'
import {FILTER_STATUS} from "../../actions/consts";
import {FILTER_WAYPOINT_BETWEEN} from "../../actions/consts";

class RunList extends React.Component
{
    componentDidMount(){
        this.props.getRuns()
    }
    renderList(runs){
        return runs.map(run => {
            var date = moment(run.begin_at)
            var d = run.begin_at ? `${date.format("DD/MM")}` : null
            var t = run.begin_at ? `${date.format("HH:mm")}` : null
            return (
                <div key={run.id} id={run.id} className={run.status} style={{marginRight:"34px", marginLeft:"23px"}} >
                    <div className="row run" style={{marginLeft:"15px", paddingRight:"-10px"}}>
                        <RunDetails title={run.title} nb_passenger={run.nb_passenger} date={d} />
                        <div className="row col-md-5 col-xs-12">
                            <div className="row">
                                <WaypointList run={run} points={run.waypoints} />
                            </div>
                            <div className="row">
                                <span style={{fontWeight:"bold", fontSize:"2.5rem"}}>{ t }</span>
                            </div>
                        </div>
                        <SubscriptionList subs={run.runners} />
                    </div>
                </div>
            )
        })
    }
    render(){
        let display = null;
        console.log(this.props)
        if(this.props.error != false){
            display = (
                <div>
                    <p>There has been an error fetching the runs, please try again later, or logging in</p>
                </div>
            )
        }
        else if(this.props.loaded){
            if(this.props.runs.length){
                //let runs = _.sortBy(this.props.runs,["status","begin_at"])
                display = this.renderList(this.props.runs)
            }
            else{
                display = "No runs available for today..."
            }
        }
        else
            display = "loading ... "
        return (
            <div className="container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {display}
                </div>
            </div>
        )
    }
}


const getVisibleRuns = (runs, filters) => {
    // filters.forEach((f, key)=>{
    //     switch(key){
    //         case FILTER_STATUS:
    //             runs = runs.filter(r => f.payload.indexOf(r.status) > -1)
    //             break;
    //         case FILTER_WAYPOINT_BETWEEN:
    //             var from = f.payload[0]
    //             var to = f.payload[1]
    //             runs = runs.filter((r)=>{
    //                 //TODO search between
    //                 if(r.waypoints.filter(w => w.name.startswith(from)) && r.waypoints.reverse().filter(w => w.name.startswith(to)))
    //                     return r
    //             })
    //             break;
    //         default:
    //             return true;
    //     }
    // })
    return runs;
}


const mapStateToProps = (state) => {
    console.log(state)
    return {
        runs: getVisibleRuns(state.runs, state.filters),
        loaded: state.ui.loaded,
        error: state.ui.error
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch,
        getRuns: () =>{
            dispatch(getRuns())
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(RunList)