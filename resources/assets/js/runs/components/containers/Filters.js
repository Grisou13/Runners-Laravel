import React from 'react'
import PropTypes from 'prop-types';
import {connect} from 'react-redux'
import StatusFilter from './../views/filters/status'
import {removeStatusFilter} from "../../actions/filters";
import {addStatusFilter} from "../../actions/filters";

class Filters extends React.Component{
    render(){
        return (
        <div>
            {/*<StatusFilter status={this.props.status} addFilter={(s)=>this.props.dispatch(addStatusFilter(s))} removeFilter={(s)=>this.props.dispatch(removeStatusFilter(s))} />*/}
        </div>
        )
    }
}

Filters.propTypes = {

}

const mapStateToProps = (state) => {
    return state.filters
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch,
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Filters)