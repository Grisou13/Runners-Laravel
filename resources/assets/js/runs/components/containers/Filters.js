import React from 'react'
import PropTypes from 'prop-types';
import {connect} from 'react-redux'
import StatusFilter from './../views/filters/status'
import TimeFilter from './../views/filters/time'
import UserFilter from './../views/filters/user'
import NameFilter from './../views/filters/name'
import CarFilter from './../views/filters/car'
import WaypointFilter from './../views/filters/waypoint_in'
import TodayFilter from './../views/filters/today'
import {removeStatusFilter} from "../../actions/filters";
import {addStatusFilter} from "../../actions/filters";
import {updateTimeEnd} from "../../actions/filters";
import {updateTimeStart, updateUser, updateName, updateCar} from "../../actions/filters";
import {updateWaypointIn} from "../../actions/filters";
import {resetFilters} from "../../actions/filters";
import {today} from "../../actions/filters";

class Filters extends React.Component{
    render(){
        console.log(this.props.time);
        return (
            <div className="">
                <div className="row">
                    <div className="col-md-2 form-inline" >
                        <div className="row form-inline">
                            <button onClick={this.props.reset} >
                                <span className="glyphicon glyphicon-repeat" />
                            </button>
                            <NameFilter name={this.props.name} changeName={(u)=>this.props.dispatch(updateName(u))} />
                        </div>
                        <div className="row">
                            <WaypointFilter waypoint_in={this.props.waypoint_in} changeWaypointIn={(p)=>this.props.dispatch(updateWaypointIn(p))} />
                        </div>
                    </div>
                    <div className="col-md-4 row">
                        <div className="col-md-10" >
                            <TimeFilter time={this.props.time} changeTimeEnd={(t)=>this.props.dispatch(updateTimeEnd(t))} changeTimeStart={(t)=>this.props.dispatch(updateTimeStart(t))} />
                        </div>
                        <div className="col-md-2 pull-right">
                            {/*<TodayFilter today={this.props.today} toggleToday={(flag) => this.props.dispatch(today(flag))} /> */}
                        </div>
                    </div>
                    <div className="col-md-2">
                        <StatusFilter status={this.props.status} addFilter={(s)=>this.props.dispatch(addStatusFilter(s))} removeFilter={(s)=>this.props.dispatch(removeStatusFilter(s))} />
                    </div>
                    <div className="col-md-2" >
                        <CarFilter car={this.props.car} changeCar={(c)=>this.props.dispatch(updateCar(c))} />
                    </div>
                    <div className="col-md-2">
                        <UserFilter user={this.props.user} changeUser={(u)=>this.props.dispatch(updateUser(u))} />
                    </div>
                </div>

            </div>

        )
    }
}

Filters.propTypes = {
    reset: PropTypes.func.isRequired
}

const mapStateToProps = (state) => {
    return Object.assign({},state.filters)
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch,
        reset: () => {
            return dispatch(resetFilters())
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Filters)
