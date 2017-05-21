const api = window.api
import {GOT_RUNS} from './consts'
import {ADD_RUN} from "./consts";
import {DELETE_RUN} from "./consts";
import {UPDATE_RUN} from "./consts";
import {FETCHING_RUN_FAILED} from "./consts";
import {EDIT_RUN} from "./consts";
import {API_ERROR} from "./consts";
import {subscribeRun} from "../services/websocket";
import {subscribeSubscription} from "../services/websocket";
import {unsubscribeRun} from "../services/websocket";
import {RESET_RUNS} from "./consts";
export const gotRuns = (runs) => {
    return {
        type:GOT_RUNS,
        payload:runs
    }
}
export const stopRun = run => dispatch => {
    api.post(`/runs/${run.id}/stop`)
        .then(res => dispatch(deleteRun(res.data)))

}
export const editRun = (run) => {
    window.location = window.Laravel.basePath + `/runs/${run.id}/edit`

    return {
        type: EDIT_RUN,
        payload:run
    }
}
export const gotRun = (run) => {
    return {
        type: ADD_RUN,
        payload: run
    }

}
export const updateRun = (run) => {
    return {
        type: UPDATE_RUN,
        payload: run
    }
}
export const startRun = (run) => {
    return dispatch => {
        api.post("/runs/"+run.id+"/start")
            .then((res)=>updateRun(res))
            .catch((res)=> {
                console.log(res)
                dispatch(fetchingFailed(res))
            })
    }
}
export const resetRuns = () => {
    return dispatch => {
        dispatch(deleteRuns())
        dispatch(fetchRuns())
    }
}
export const deleteRuns = () => {
    return {
        type: RESET_RUNS
    }
}
export const deleteRun = (run) => {

  return {
      type: DELETE_RUN,
      payload: run
  };
    return dispatch => {
        api.delete("/runs/"+run.id)
            .then((res)=>{
                dispatch({
                    type: DELETE_RUN,
                    payload: run
                })
            })
            .catch((res)=>{
                console.log(res)
                dispatch(fetchingFailed(res))
            })
    }
}
export const addRun = (run) => {
    return {
        type: ADD_RUN,
        payload: run
    }
}
export const removeRun = (run) => {
    return {
        type: DELETE_RUN,
        payload: run
    }
}
export const apiError = (error) => {
  return {
    type: API_ERROR,
    error
  }
}
export const fetchingFailed = (error) => {
    return {
        type:FETCHING_RUN_FAILED,
        error
    }
}
export const fetchRuns = () => {
    return (dispatch) => {
        api.get("/runs?sortBy=planned_at,status").then(
            res => dispatch(gotRuns(res.data))
        )
        .catch((res)=>{
            throw res
            console.log(res)
            dispatch(fetchingFailed(res))
        })
    }
}
