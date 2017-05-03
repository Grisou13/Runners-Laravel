import {deleteRun} from "../actions/runs";
import {updateRun} from "../actions/runs";
import {subCreated} from "../actions/subscirptions";
import {subUpdated} from "../actions/subscirptions";
import {subDeleted} from "../actions/subscirptions";
// import io from 'socket.io-client'
// import Echo from "laravel-echo"
import {gotRun} from "../actions/runs";


const tranformRun = (run) => {
    return {
        id: run.id,
        status: run.status,
        title: run.name,
        begin_at: run.planned_at,
        nb_passenger: run.nb_passenger
    }
}
export const subscribeSubscription = (run,sub,dispatcher) => {
    var echo = window.LaravelEcho
    echo.channel(`runs.${run.id}.subscriptions.${sub.id}`)
        .on("updated", (e)=>{
            var sub = e.subscription
            var run = e.run
            console.log("===================")
            console.log(e)
            console.log("updated sub")
            dispatcher(subUpdated(run,sub))
        })
    echo.channel(`runs.${run.id}.subscriptions.${sub.id}`)
        .on("deleted", (e)=>{
            var sub = e.subscription
            var run = e.run
            console.log("deleted sub")
            echo.channel(`runs.${run.id}.subscriptions.${sub.id}`).unsubscribe();
            dispatcher(subDeleted(run,sub))
        })
}
export const subscribeRun = (run, dispatcher) => {
    var echo = window.LaravelEcho
    echo.channel(`runs.${run.id}`)
        .on("updated", e => {
            var run = e.run
            console.log("updated")
            dispatcher(updateRun(run))
        })
    echo.channel(`runs.${run.id}`)
        .on("deleted", (e)=>{
            var run = e.run
            console.log("deleted")
            echo.channel(`runs.${run.id}`).unsubscribe();
            dispatcher(deleteRun(run))
        })
    echo.channel(`runs.${run.id}.subscriptions`)
        .on("created", (e) => {
            var sub = e.subscription
            var run = e.run
            subscribeSubscription(run,sub,dispatcher)
            console.log("created sub")
            dispatcher(subCreated(run,sub))
        })

    echo.channel(`runs.${run.id}.subscriptions`)
        .on("deleted", (e)=>{
            var sub = e.subscription
            var run = e.run
            console.log("deleted sub")
            dispatcher(subDeleted(run,sub))
        })
}
/**
 * Created by thomas_2 on 29.04.2017.
 */
export default (dispatcher) => {
    console.log("Starting websocket service");
    var echo = window.LaravelEcho
    // echo.channel("runs")
    //     .on("deleted", (e)=>{
    //         var run = e.run
    //         console.log("deleted")
    //         echo.channel(`runs.${run.id}`).leave();
    //         dispatcher(deleteRun(run))
    //     })
    echo.channel("runs")
        .on("created", (e)=>{
            console.log(e)
            var run = e.run
            console.log("created")
            subscribeRun(run, dispatcher)
            dispatcher(gotRun(run))
        })

}