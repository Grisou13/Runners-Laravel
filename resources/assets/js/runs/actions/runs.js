const api = window.api
import {GOT_RUNS} from './consts'
export const gotRuns = (runs) => {
    return {
        type:GOT_RUNS,
        payload:runs
    }
}

export const getRuns = () => {
    return (dispatch) => {
        api.get("/runs").then(
            res => dispatch(gotRuns(res.data))
        )
    }
}
