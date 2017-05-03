import {ADD_FILTER_STATUS, REMOVE_FILTER_STATUS} from "./consts";
/**
 * Created by thomas_2 on 29.04.2017.
 */
export const filter = (filter_name, value) => {
    return {
        type: filter_name,
        payload: value
    }
}
export const addStatusFilter = (status) => {
    return {
        type: ADD_FILTER_STATUS,
        payload:status
    }
}
export const removeStatusFilter = (status) => {
    return {
        type: REMOVE_FILTER_STATUS,
        payload:status
    }
}