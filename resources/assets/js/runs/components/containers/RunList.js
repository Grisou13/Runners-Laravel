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

const selectionMode = ({toggle,toggleAll,action}) => {
    return (
        <div>

        </div>
    )
}

@ui({
    key:"run-list",
    state:{
        hoverRun:null,
        selecting:false,
        selected:[],
        printing:false,
        exporting:false

    }
})
class RunList extends React.Component
{
    componentDidMount(){
        this.props.getRuns()
    }
    print(e){
        this.disableList(e)
    }
    exportRuns(e){
        this.disableList(e)
    }

    toggleSelectMode(e, action){
        e.preventDefault()
        this.props.updateUI({...action,selecting:!this.props.ui.selecting, selected: this.props.runs.map(r => r.id)})
    }
    toggleSelection(e, run){
        if(e.target.checked)
            this.addSelection(run)
        else
            this.removeSelection(run)
    }
    addSelection(run){
        this.props.updateUI({selected: this.props.ui.selected.push(run.id)})
    }
    removeSelection(run){
        this.props.updateUI({selected: this.props.ui.selected.filter( rId => rId != run.id )})
    }
    toggleList(e){
        if(e.target.checked)
            this.props.updateUI({selected: this.props.runs.filter(r => r.id)})
        else
            this.props.updateUI({selected: []})

    }
    disableList(e)
    {
        e.preventDefault()
        this.props.updateUI({selected: [], selecting:false, printing:false, exporting:false})
    }
    renderButtons(){
        if(this.props.ui.exporting){
            return (
                <div>
                    <input type="checkbox" checked={this.props.ui.selected.length == this.props.runs.length} onClick={(e)=>e.target.checked ? this.props.updateUI({selected: this.props.runs.map(r => r.id)}) : this.props.updateUI({selected: []})} />
                    <button onClick={(e)=>this.print(e)} className="btn btn-default">
                        <span className="glyphicon glyphicon-ok"/>
                    </button>
                    <button className="btn btn-default" onClick = {(e)=>{this.disableList(e)}}>
                        <span className="glyphicon glyphicon-remove" />
                    </button>
                </div>
            );
        }
        else if(this.props.ui.printing){
            return (
                <div>
                    <input type="checkbox" checked={this.props.ui.selected.length == this.props.runs.length} onClick={(e)=>this.toggleList(e)} />
                    <button onClick={(e)=>this.exportRuns(e)} className="btn btn-default">
                        <span className="glyphicon glyphicon-ok"/>
                    </button>
                    <button className="btn btn-default" onClick = {(e)=>{this.disableList(e)}}>
                        <span className="glyphicon glyphicon-remove" />
                    </button>
                </div>
            );
        }
        else{
            return (
                <div>
                    <button onClick={(e)=>this.toggleSelectMode(e, {printing:true})} className="btn btn-default">
                        <span className="glyphicon glyphicon-print" />
                    </button>
                    <button onClick={(e)=>this.toggleSelectMode(e, {exporting: true})} className="btn btn-default">
                        <span className="glyphicon glyphicon-save-file"/>
                    </button>
                </div>
            );
        }
    }

    renderList(runs){
        return (
            <div className="container-fluid">
                <div className="row print-controls">
                    {this.renderButtons()}
                </div>
                <div className="row text-center">
                    <Time UTCOffset={2} />
                </div>
                <div className="row">
                    {runs.map(run =>{
                        return (
                            <div key={"run-"+run.id} className={run.status + ' run-container ' + (this.props.ui.selecting ? "hovered" : "")} /*onMouseLeave={(e)=>this.props.updateUI({hoverRun:null})} onMouseOver={(e)=>this.props.updateUI({hoverRun:run.id})}*/ >
                                {/*<div className="btn-container">*/}
                                    {
                                        this.props.ui.selecting ?
                                        (
                                            <div className="btn-container">
                                                <input className="control" type="checkbox" checked={this.props.ui.selected.filter((r)=>r == run.id).length > 0} onClick={(e)=>this.toggleSelection(e,run)} />
                                            </div>
                                        )
                                            :
                                        (
                                        <div className="btn-container">
                                            <a href="#" onClick={()=>this.props.editRun(run)} className="control"><span className="glyphicon glyphicon-edit" /></a>
                                            {run.start_at == null || run.start_at == "" ? <a href="#" onClick={()=>this.props.startRun(run)} className="control"><span className="glyphicon glyphicon-play" /></a> : <a href="#" onClick={()=>this.props.stopRun(run)} className="control"><span className="glyphicon glyphicon-ban-circle" /></a>}

                                        </div>
                                        )
                                    }
                                    {/*<a href="#" onClick={()=>this.props.dispatch(deleteRun(run))} className="control"><span className="glyphicon glyphicon-minus"></span></a>*/}
                                {/*</div>*/}

                                <Run  {...run} />
                            </div>
                    )})}
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
    runs = runs.filter( r => !r.start_at && !r.end_at)
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
    runs:  PropTypes.array.isRequired
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
