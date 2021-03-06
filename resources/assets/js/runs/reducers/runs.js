const defaultState = {
    items : [],
    loaded:false,
    error:false
}
import {GOT_RUNS, ADD_RUN, UPDATE_RUN} from './../actions/consts'
import {DELETE_RUN} from "../actions/consts";
import {SUBSCRIPTION_CREATED} from "../actions/consts";
import {SUBSCRIPTION_DELETED} from "../actions/consts";
import {SUBSCRIPTION_UPDATED} from "../actions/consts";
import {FETCHING_RUN_FAILED} from "../actions/consts";
import {RESET_RUNS} from "../actions/consts";
import {GOT_RUN_BULK} from "../actions/consts";
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
        case GOT_RUN_BULK:
            return Object.assign({},state, {loaded:true, items: action.payload})
        case GOT_RUNS:
            return Object.assign({},state, {loaded:true, items: state.items.concat(action.payload)})
        case ADD_RUN:
            return Object.assign({},state, {items: [...state.items, action.payload]})
        case DELETE_RUN:
            var runId = action.payload.id
            return Object.assign({},state, {items: state.items.filter(run =>run.id != runId)})
        case RESET_RUNS:
            return Object.assign({},state, {items: []})
        case FETCHING_RUN_FAILED:
            return Object.assign({}, state, {loaded: true, error: action.error})
        case UPDATE_RUN:
            console.log("before",state.items)
            console.log("after", Object.assign({},state, {items: [...state.items.filter(run =>run.id != action.payload.id), action.payload]}).items)
            return Object.assign({},state, {items: [...state.items.filter(run =>run.id != action.payload.id), action.payload]})
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
