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
import _ from "lodash";
const swal = window.swal

@ui({
    key:"run-list",
    state:{
        hoverRun:null,
        printing_selection:false,
        print:{
            selected: [],
            selecting:false
        }
    }
})
class RunList extends React.Component
{
    componentDidMount(){
        this.props.getRuns()
    }
    print(e){
        e.preventDefault()
        if(this.props.ui.printing_selection)
        {
            //print the runs :D
        }
        this.props.updateUI({print:{selecting:!this.props.ui.print.selecting}})

    }
    addRunToPrintSelection(run){
        this.props.updateUI({print:{selected:_.uniq(this.props.ui.print.selected.push(run))}})
    }
    toggleRunPrint(run){
        if(this.props.ui.print.selected.find((e)=>e == run))
            this.addRunToPrintSelection(run)
        else
            this.removeFromPrintSelection(run)
    }
    removeFromPrintSelection(run){
        this.props.updateUI({print:{selected:this.props.ui.print.selected.filter((e)=>e != run)}})
    }
    renderList(runs){
        return (
            <div className="container-fluid">
                <div className="row print-controls">
                    <input type="checkbox" value={this.props.ui.print.selected.length == this.props.runs.length} onClick={()=>this.props.runs.forEach( r => this.addRunToPrintSelection(r.id))} />
                    <button onClick={(e)=>this.print(e)} className="btn btn-default">
                        <span className="glyphicon glyphicon-print" />
                    </button>
                </div>
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {runs.map(run =>{
                        return (
                        <div className={status + ' run-container' + (this.props.ui.print.selecting ? "hovered" : "")} /*onMouseLeave={(e)=>this.props.updateUI({hoverRun:null})} onMouseOver={(e)=>this.props.updateUI({hoverRun:run.id})}*/ >
                            <div className="btn-container">
                                { this.props.ui.print.selecting ? <input className="control" type="checkbox" checked={this.props.ui.print.selected.find((e)=>e == run)} onClick={()=>this.toggleRunPrint(run)} /> : null}
                                <a href="#" onClick={()=>this.props.editRun(run)} className="control"><span className="glyphicon glyphicon-edit" /></a>
                                <a href="#" onClick={()=>this.props.startRun(run)} className="control">
                                    <span className="glyphicon glyphicon-play" />
                                </a>
                                <a href="#" onClick={()=>this.props.stopRun(run)} className="control"><span className="glyphicon glyphicon-ban-circle" /></a>
                                {/*<a href="#" onClick={()=>this.props.dispatch(deleteRun(run))} className="control"><span className="glyphicon glyphicon-minus"></span></a>*/}
                            </div>

                            <Run key={"run-"+run.id} {...run} />
                        </div>

                        )
                    }
                    )}
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
                    <p>No runs ... </p>
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
        runs = runs.filter(r => r.title.toLowerCase().startsWith(filters.name.toLowerCase()))
    if(filters.user.length)
      runs = runs.filter(r => {
         if ( r.runners.filter( r => r.user && r.user.name.toLowerCase().startsWith(filters.user.toLowerCase())).length )
          return r
      })
    if(filters.car.length)
        runs = runs.filter(r => {
          //check cars and car types
          if ( r.runners.filter( r => r.car && r.car.name.toLowerCase().startsWith(filters.car.toLowerCase())).length ||  r.runners.filter( r => r.vehicule_category && r.vehicule_category.type.toLowerCase().startsWith(filters.car.toLowerCase())).length)
            return r
        })
    if(filters.waypoint_in.length)
      runs = runs.filter( r => {
        if(r.waypoints.filter(p => p.nickname.toLowerCase().startsWith(filters.waypoint_in.toLowerCase())).length)
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

RunList.propTypes = {
    runs:  PropTypes.arrayOf(Run.propTypes).isRequired
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
        stopRun: (run) => {
            swal({
                title: "Are you sure you want to stop the run?",
                text: "This will stop the run",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, stop it!",
                closeOnConfirm: false,
                html: false
            }, function(){
                swal.close()
                dispatch(stopRun(run))
            })

        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(RunList)
