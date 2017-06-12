/**
 * Created by thomas_2 on 29.04.2017.
 */

import wsService from './websocket'
import printService from './print'
import {fetchRuns} from "../actions/runs";
export default (dispatcher) => {
    if(!wsService(dispatcher))
        window.setInterval(()=>{
            console.log("refreshing runs");
            dispatcher(fetchRuns())
        },10*1000);
    printService(dispatcher)
}