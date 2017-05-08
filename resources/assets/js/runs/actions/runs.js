const api = window.api
import {GOT_RUNS} from './consts'
import {ADD_RUN} from "./consts";
import {DELETE_RUN} from "./consts";
import {UPDATE_RUN} from "./consts";
import {FETCHING_RUN_FAILED} from "./consts";
import {EDIT_RUN} from "./consts";
import {subscribeRun} from "../services/websocket";
import {subscribeSubscription} from "../services/websocket";
export const gotRuns = (runs) => {
    return (dispatch) => {
        runs.forEach(r => subscribeRun(r, dispatch))//TODO maybe put this somewhere else? dunno
        runs.map(r => r.runners.map( s => subscribeSubscription(r,s,dispatch)))
        dispatch({
            type:GOT_RUNS,
            payload:runs
        })
    }

}
export const editRun = (run) => {
    return {
        type: EDIT_RUN,
        payload:run
    }
}
export const gotRun = (run) => {
    return (dispatch)=> {
        subscribeRun(run, dispatch)
        run.runners.map( s => subscribeSubscription(run,s,dispatch))
        dispatch({
            type: ADD_RUN,
            payload: run
        })
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
export const deleteRun = (run) => {
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
export const fetchingFailed = (error) => {
    return {
        type:FETCHING_RUN_FAILED,
        error
    }
}
export const getRuns = () => {
    return (dispatch) => {
        api.get("/runs?sortBy=planned_at,status").then(
            res => dispatch(gotRuns(res.data))
        )
        .catch((res)=>{
            console.log(res)
            dispatch(fetchingFailed(res))
        })
    }
}
