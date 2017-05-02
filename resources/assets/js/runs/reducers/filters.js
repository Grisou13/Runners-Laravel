import {ADD_FILTER} from "../actions/consts";
import {REMOVE_FILTER} from "../actions/consts";
import {FILTER_STATUS} from "../actions/consts";
import {ADD_FILTER_STATUS, REMOVE_FILTER_STATUS, RESET_FILTER_STATUS} from "../actions/consts";
import {FILTER_NAME} from "../actions/consts";
/**
 * Created by thomas_2 on 29.04.2017.
 */

const defaultState = {
    status:[],
    name:"",
    waypoint_between:[],
    waypoint_in:"",
    car:"",
    runner:""
}

/*
* Filters are simple object with an action and maybe a payload
 * {
 *  type: FILTER_STATUS_ERROR
 * }
 * OR
 * {
 *  type: FILTER_WAYPOINT_BETWEEN,
 *  payload: ["Some point", "another"]
 * }
*/
const filter = (state = defaultState, action) => {
    switch (action.type) {
        case ADD_FILTER_STATUS:
            return Object.assign({},state, {status: [...state.status, action.payload]})
        case REMOVE_FILTER_STATUS:
            var index = false;
            if(index = state.status.indexOf(action.payload) > -1)
                return Object.assign({},state, {status: state.status.splice(index,1)})
            else
                return state
        case RESET_FILTER_STATUS:
            return Object.assign({},state, {status: []})
        case FILTER_NAME:
            return Object.assign({},state, {name: action.payload})
        default:
            return state
    }
}

export default filter