const defaultState = {
    runs:[],
    subscriptions:[],
    user:{},
    runSubIds:[],
    activeRun:{}
}
import {GOT_RUNS, ADD_RUN} from './../actions/consts'
const activeRun = (state = {}, action) =>{
    switch(action.type){
        case ADD_RUN:
            return action.payload
        default:
            return state;
    }
}
const runs = (state = [], action) => {
    switch(action.type){
        case GOT_RUNS:
            return action.payload
        case ADD_RUN:
            return [...state, activeRun(undefined, action)]
        default:
            return state;
    }
}
//runSubIds is a mapping between runId : [...array of subs linked to run]


export default runs