const api = window.api
import {GOT_RUNS} from './consts'
import {ADD_RUN} from "./consts";
import {DELETE_RUN} from "./consts";
import {UPDATE_RUN} from "./consts";
export const gotRuns = (runs) => {
    return {
        type:GOT_RUNS,
        payload:runs
    }
    return (dispatch) => {
        dispatch({
            type:GOT_RUNS,
            payload:runs
        })
        dispatch(uiLoaded())
    }

}
export const editRun = (run) => {
    return {
        type: EDIT_RUN,
        payload:run
    }
}
export const updateRun = (run) => {
    return {
        type: UPDATE_RUN,
        payload: run
    }
}
export const deleteRun = (run) => {
    return {
        type: DELETE_RUN,
        payload: run
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
export const getRuns = () => {
    return (dispatch) => {
        api.get("/runs?sortBy=status ASC, planned_at DESC").then(
            res => dispatch(gotRuns(res.data))
        )
    }
}
