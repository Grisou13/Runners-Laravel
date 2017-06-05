const api = window.api
import {GOT_SUBS} from './consts'
import {SUBSCRIPTION_DELETED, SUBSCRIPTION_CREATED, SUBSCRIPTION_UPDATED} from "./consts";

export const gotSubs = (subs) => {
    return {
        type:GOT_SUBS,
        payload:subs
    }
}
export const subCreated = (run, sub) => {
    return {
        type: SUBSCRIPTION_CREATED,
        payload: sub,
        run
    }
}
export const subUpdated = (run, sub) => {
    return {
        type: SUBSCRIPTION_UPDATED,
        payload: sub,
        run
    }
}
export const subDeleted = (run, sub) => {
    return {
        type: SUBSCRIPTION_DELETED,
        payload: sub,
        run
    }
}
export const getSubs = (run) => {
    return (dispatch) => {
        api.get(`/runs/${run.id}/runners`).then(
            res => dispatch(gotSubs(res.data))
        )
    }
}
