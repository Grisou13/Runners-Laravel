import React from 'react'
import PropTypes from 'prop-types';

import {connect} from 'react-redux'
import moment from 'moment'
import {getRuns} from './../../actions/runs'

import WaypointList from './../views/WaypointList'
import RunDetails from './../views/RunDetails'
import SubscriptionList from './../views/SubscriptionList'
import Time from './../views/Time'
import {FILTER_STATUS} from "../../actions/consts";
import {FILTER_WAYPOINT_BETWEEN} from "../../actions/consts";
import ui from 'redux-ui';
import {startRun} from "../../actions/runs";
import {deleteRun} from "../../actions/runs";
@ui({
    key:"run-list",
    state:{
        hoverRun:null
    }
})
class RunList extends React.Component
{
    componentDidMount(){
        this.props.getRuns()
    }
    renderList(runs){
        return (
            <div className="container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {runs.map(run => {
                        var date = moment(run.begin_at)
                        var d = run.begin_at ? `${date.format("DD/MM")}` : null
                        var t = run.begin_at ? `${date.format("HH:mm")}` : null
                        return (
                            <div key={"run-"+run.id} id={"run-"+run.id} className={run.status + ' run-container'} /*onMouseLeave={(e)=>this.props.updateUI({hoverRun:null})} onMouseOver={(e)=>this.props.updateUI({hoverRun:run.id})}*/ >
                                <div className="btn-container">
                                    <a href={window.Laravel.basePath + `/runs/${run.id}/edit`} className="control"><span className="glyphicon glyphicon-edit"></span></a>
                                    <a href="#" onClick={()=>this.props.dispatch(startRun(run))} className="control"><span className="glyphicon glyphicon-play"></span></a>
                                    {/*<a href="#" onClick={()=>this.props.dispatch(deleteRun(run))} className="control"><span className="glyphicon glyphicon-minus"></span></a>*/}
                                </div>

                                <div className="run" /*style={{transform: (this.props.ui.hoverRun != null && this.props.ui.hoverRun==run.id )? "translateX(50px)": "" }}*/>
                                    <div className="col-md-3 col-xs-6 col-sm-2">
                                        <RunDetails title={run.title} nb_passenger={run.nb_passenger} note={run.note ? run.note : ""} date={d} />
                                    </div>
                                    <div className="col-md-5 col-xs-6 col-sm-7">
                                        <div className="row">
                                            <WaypointList run={run} points={run.waypoints} />
                                        </div>
                                        <div className="row">
                                            <span className="time">{ t }</span>
                                        </div>
                                    </div>
                                    <div className="col-md-4 col-xs-12 col-sm-3">
                                        <SubscriptionList subs={run.runners} />
                                    </div>
                                </div>
                            </div>
                        )
                    })}
                </div>
            </div>
        )
    }
    renderEmpty(){
        return (
            <div className="container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    <p>No runs available for today... </p>
                </div>
            </div>
        )
    }
    renderLoading(){
        return (
            <div className="container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    <p>Loading ... </p>
                </div>
            </div>
        )
    }
    renderError(){
        return (
            <div className="container-fluid">
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    <div>
                        <p>There has been an error fetching the runs, please try again later, or logging in</p>
                    </div>
                </div>
            </div>
        )
    }
    render(){

        if(this.props.loaded){
            if(this.props.runs.length){
                //let runs = _.sortBy(this.props.runs,["status","begin_at"])
                return this.renderList(this.props.runs)
            }
            else{
                if(this.props.error != false)
                    return this.renderError()
                return this.renderEmpty()
            }
        }
        else if(this.props.error != false){
            return this.renderError()
        }
        else
            return this.renderLoading()

    }
}


const getVisibleRuns = (runs, filters) => {
    runs = _(runs).orderBy(function(r){
        return moment(r.begin_at).unix();
    }).orderBy(function(r){
        return r.status
    }).value()
    runs.forEach(r => console.log(r.status))
    if(filters.status.length)
        runs = runs.filter(r=>filters.status.indexOf(r.status) > -1)
    if(filters.name.length)
        runs = runs.filter(r => r.title.startsWith(filters.name))
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
    return {
        runs: getVisibleRuns(state.runs.items, state.filters),
        loaded: state.runs.loaded,
        error: state.runs.error
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