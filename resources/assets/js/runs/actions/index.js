const api = window.api

export const setStatusFilter = (filter) => {
    return {
        type: 'SET_STATUS_FILTER',
        filter
    }
}

export const addSub = (run,sub) => {
    return {
        type: 'ADD_SUB',
        sub,
        run
    }
}

export const updateSub = (sub) => {
    return {
        type:"UPDATE_SUB",
        sub
    }
}

export const createSub = (run, user = null, car = null, car_type = null) => {
    let data = {
        car,
        user,
        car_type
    }
    return api.post(`/run/${run.id}/runners`,data)
        .then(
            new_sub => dispatch(addSub(run,sub))
        )
}