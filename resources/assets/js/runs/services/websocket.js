import {deleteRun} from "../actions/runs";
import {updateRun} from "../actions/runs";
import {subCreated} from "../actions/subscirptions";
import {subUpdated} from "../actions/subscirptions";
import {subDeleted} from "../actions/subscirptions";
import io from 'socket.io-client'
import Echo from "laravel-echo"



/**
 * Created by thomas_2 on 29.04.2017.
 */
export default (dispatcher) => {
    window.io = typeof(window.io) == "undefined" ? io : window.io

    var echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001'
    });
    echo.channel("runs")
        // .listen("updated.status",(run)=>{
        //
        // })
        .listen("deleted", (run)=>{
            dispatcher.dispatch(deleteRun(run))
        })
        .listen("created", (run)=>{
            echo.channel(`runs.${run.id}`)
                .listen("updated", run => dispatcher.dispatch(updateRun(run)))

            echo.channel(`runs.${run.id}.subscriptions`)
                .listen("created", (run, sub) => dispatcher.dispatch(subCreated(run,sub)))
                .listen("updated", (run,sub)=>dispatcher.dispatch(subUpdated(run,sub)))
                .listen("deleted", (run,sub)=>dispatcher.dispatch(subDeleted(run,sub)))
        })

}