import React from 'react'
import PropTypes from 'prop-types';
import {connect} from 'react-redux'
import StatusFilter from './../views/filters/status'
import TimeFilter from './../views/filters/time'
import {removeStatusFilter} from "../../actions/filters";
import {addStatusFilter} from "../../actions/filters";
import {updateTimeEnd} from "../../actions/filters";
import {updateTimeStart} from "../../actions/filters";

class Filters extends React.Component{
    render(){
        return (
            <div className="filters">
                <StatusFilter status={this.props.status} addFilter={(s)=>this.props.dispatch(addStatusFilter(s))} removeFilter={(s)=>this.props.dispatch(removeStatusFilter(s))} />
                <TimeFilter time={this.props.time} changeTimeEnd={(t)=>this.props.dispatch(updateTimeEnd(t))} changeTimeStart={(t)=>this.props.dispatch(updateTimeStart(t))} />
            </div>
        )
    }
}

Filters.propTypes = {

}

const mapStateToProps = (state) => {
    return Object.assign({},state.filters)
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch,
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Filters)