import React from 'react'
import PropTypes from 'prop-types';
import {connect} from 'react-redux'
import ui from 'redux-ui';

import moment from 'moment'

import Run from './../views/Run'
import Time from './../views/Time'
import {startRun} from "./../../actions/runs";
import {stopRun} from "./../../actions/runs";
import {editRun} from "./../../actions/runs";
import {fetchRuns} from './../../actions/runs'

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
                <div className="row print-controls">
                    <button className="btn btn-default">
                        <span className="glyphicon glyphicon-print" />
                    </button>
                </div>
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {runs.map(run => <Run key={"run-"+run.id} run={run} startRun={this.props.startRun} editRun={this.props.editRun} stopRun={this.props.stopRun} />)}
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
        runs = runs.filter(r => r.title.toLowerCase().startsWith(filters.name))
    if(filters.user.length)
      runs = runs.filter(r => {
         if ( r.runners.filter( r => r.user && r.user.name.toLowerCase().startsWith(filters.user)).length )
          return r
      })
    if(filters.car.length)
        runs = runs.filter(r => {
          //check cars and car types
          if ( r.runners.filter( r => r.car && r.car.name.toLowerCase().startsWith(filters.car)).length ||  r.runners.filter( r => r.vehicule_category && r.vehicule_category.type.toLowerCase().startsWith(filters.car)).length)
            return r
        })
    if(filters.waypoint_in.length)
      runs = runs.filter( r => {
        if(r.waypoints.filter(p => p.nickname.toLowerCase().startsWith(filters.waypoint_in)).length)
          return r
      })
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
            dispatch(fetchRuns())
        },
        startRun: (run) => dispatch(startRun(run)),
        editRun: (run) => dispatch(editRun(run)),
        stopRun: (run) => dispatch(stopRun(run))
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(RunList)
