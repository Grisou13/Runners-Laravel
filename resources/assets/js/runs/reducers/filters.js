import {ADD_FILTER} from "../actions/consts";
import {REMOVE_FILTER} from "../actions/consts";
import {FILTER_STATUS} from "../actions/consts";
/**
 * Created by thomas_2 on 29.04.2017.
 */

const state = {
    FILTER_STATUS:[],
    FILTER_NAME:"",
    FILTER_BETWEEN:[],
    FILTER_CONTAINS:"",
    FILTER_CAR:"",
    FILTER_USER:""
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
const filter = (state = state, action) => {
    switch (action.type) {
        case FILTER_STATUS:
            if(action.payload.value)
             return [...state, {type:FILTER_STATUS, value:[]}]
        case ADD_FILTER:
            return [...state,action.payload]
        case REMOVE_FILTER:
            var filter_ = action.payload
            return state.filter( f => f == filter_)
        case UPDATE_FILTER:
            break;
        default:
            return state
    }
}

export default filter