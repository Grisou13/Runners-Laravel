const defaultState = {
    items : [],
    loaded:false,
    error:false
}
import {GOT_RUNS, ADD_RUN} from './../actions/consts'
import {DELETE_RUN} from "../actions/consts";
import {SUBSCRIPTION_CREATED} from "../actions/consts";
import {SUBSCRIPTION_DELETED} from "../actions/consts";
import {SUBSCRIPTION_UPDATED} from "../actions/consts";
import {FETCHING_RUN_FAILED} from "../actions/consts";
const activeRun = (state = {}, action) =>{
    switch(action.type){
        case ADD_RUN:
            return action.payload
        default:
            return state;
    }
}
const runs = (state = defaultState, action) => {
    switch(action.type){
        case GOT_RUNS:
            return Object.assign({},state, {loaded:true, items: action.payload})
        case ADD_RUN:
            return Object.assign({},state, {items: [...state.items, action.payload]})
        case DELETE_RUN:
            var runId = action.payload.id
            return Object.assign({},state, {items: state.items.filter(run =>run.id != runId)})
        case FETCHING_RUN_FAILED:
            return Object.assign({}, state, {loaded: true, error: action.error})

        case SUBSCRIPTION_CREATED:
            var run = action.run
            var sub = action.payload
            return Object.assign({},state, {items: state.items.map((r)=>{
                if(r.id == run.id) {
                    r.runners.push(sub)
                }
                return r
            })
            })
            return state
        case SUBSCRIPTION_DELETED:
            var run = action.run;
            var sub = action.payload;
            return Object.assign({},state, {items: state.items.map((r)=>{
                if(r.id == run.id){
                    r.runners = r.runners.filter((s) => s.id != sub.id)
                }
                return r
            })
            })
        case SUBSCRIPTION_UPDATED:
            var run = action.run;
            var sub = action.payload;
            return Object.assign({},state, {items: state.items.map((r)=>{
                if(r.id == run.id)
                    r.runners = r.runners.map((s)=>{
                        if(s.id == sub.id)
                            return Object.assign({},s,sub)
                        return s
                    })
                return r
            })
            })

        default:
            return state;
    }
}
//runSubIds is a mapping between runId : [...array of subs linked to run]


export default runs