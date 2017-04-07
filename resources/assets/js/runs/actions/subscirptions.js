const api = window.api
import {GOT_SUBS} from './consts'

export const gotSubs = (subs) => {
    return {
        type:GOT_SUBS,
        payload:subs
    }
}

export const getSubs = (run) => {
    return (dispatch) => {
        api.get(`/runs/${run.id}/runners`).then(
            res => dispatch(gotSubs(res.data))
        )
    }
}
