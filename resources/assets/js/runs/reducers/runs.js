const defaultState = {
    runs:[],
    subscriptions:[],
    user:{},
    runSubIds:[],
    activeRun:{}
}
import {GOT_RUNS, ADD_RUN} from './../actions/consts'
import {DELETE_RUN} from "../actions/consts";
import {SUBSCRIPTION_CREATED} from "../actions/consts";
import {SUBSCRIPTION_DELETED} from "../actions/consts";
import {SUBSCRIPTION_UPDATED} from "../actions/consts";
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
            return [...state, action.payload]
        case DELETE_RUN:
            var runId = action.payload.id
            return state.filter(run =>run.id != runId)
        case SUBSCRIPTION_CREATED:
            var run = action.run
            var sub = action.payload
            return state.map((r)=>{
                if(r.id == run.id) {
                    r.runners.push(sub)
                }
                return r
            })
        case SUBSCRIPTION_DELETED:
            var run = action.run;
            var sub = action.payload;
            return state.map((r)=>{
                if(r.id == run.id){
                    r.runners = r.runners.filter((s) => s.id != sub.id)
                }

                return r
            })
        case SUBSCRIPTION_UPDATED:
            var run = action.run;
            var sub = action.payload;
            return state.map((r)=>{
                if(r.id == run.id)
                    r.runners = r.runners.map((s)=>{
                        if(s.id == sub.id)
                            return Object.assign({},s,sub)
                        return s
                    })
                return r
            })
        default:
            return state;
    }
}
//runSubIds is a mapping between runId : [...array of subs linked to run]


export default runs