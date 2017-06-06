const defaultState = {
    subs:[]
}
import {GOT_SUBS} from './../actions/consts'
const subs = (state=defaultState.subs, action)=>{
    switch(action.type){
        case GOT_SUBS:
            return action.payload
        default:
            return state;
    }
}