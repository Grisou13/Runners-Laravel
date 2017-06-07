import {ADD_FILTER_STATUS, REMOVE_FILTER_STATUS} from "./consts";
import {UPDATE_FILTER_TIME_START} from "./consts";
import {UPDATE_FILTER_TIME_END, FILTER_USING_USER, FILTER_WAYPOINT_IN} from "./consts";
import {FILTER_NAME} from "./consts";
import {FILTER_USING_CAR} from "./consts";
import {RESET_FILTERS} from "./consts";

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

export const updateTimeStart = (time) => {
    return {
        type: UPDATE_FILTER_TIME_START,
        payload: time
    }
}
export const updateTimeEnd = (time) => {
    return {
        type: UPDATE_FILTER_TIME_END,
        payload: time
    }
}
export const updateName = (artistName) => {
  return {
    type: FILTER_NAME,
    payload: artistName
  }
}
export const updateUser = (username) => {
  return {
    type: FILTER_USING_USER,
    payload: username
  }
}
export const updateCar = (car) => {
  return {
    type: FILTER_USING_CAR,
    payload: car
  }
}

export const updateWaypointIn = (pointName) => {
  return {
    type: FILTER_WAYPOINT_IN,
    payload: pointName
  }
}

export const resetFilters = () => ({
    type: RESET_FILTERS
})