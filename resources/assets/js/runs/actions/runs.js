const api = window.api;
import {GOT_RUNS} from './consts'
import {ADD_RUN} from "./consts";
import {DELETE_RUN} from "./consts";
import {UPDATE_RUN} from "./consts";
import {FETCHING_RUN_FAILED} from "./consts";
import {EDIT_RUN} from "./consts";
import {API_ERROR} from "./consts";
import {subscribeRun} from "../services/websocket";
import {subscribeSubscription} from "../services/websocket";
import {unsubscribeRun} from "../services/websocket";
import {RESET_RUNS} from "./consts";
import {STARTED_RUN,RUN_PRINTED} from "./consts";
// const jsPDF = window.jsPDF
export const gotRuns = (runs) => {
    return {
        type:GOT_RUNS,
        payload:runs
    }
};
export const stopRun = run => dispatch => {
    api.post(`/runs/${run.id}/stop`)
        .then(res => dispatch(updateRun(res.data)))

};
export const editRun = (run) => {
    window.location = window.Laravel.basePath + `/runs/${run.id}/edit`;

    return {
        type: EDIT_RUN,
        payload:run
    }
};
export const runPrinted = () => (
  {
    type: RUN_PRINTED
  }
);
export const printRuns = (runs = []) => {
    return dispatch => {
        // console.log(runs)
        // var doc = new jsPDF('l', 'pt', 'a2');
        // var columns = ["ID", "Name", "Country", "extra"];
        // var rows = [
        //     [1, "Shaw", "Tanzania", ["some","other"]],
        //     [2, "Nelson", "Kazakhstan", ["some","other"]],
        //     [3, "Garcia", "Madagascar", ["some","other"]],
        //
        // ];
        //
        // // Only pt supported (not mm or in)
        // var doc = new jsPDF('l', 'pt');
        // doc.autoTable(columns, rows);
        // doc.output('dataurlnewwindow');
        // return false
        let url = "/runs/pdf?"+runs.map(r => r.id).reduce((acc, cur, i,t)=>{
                if(i == 1)
                    return "runs[]="+acc+"&runs[]="+cur;
                else
                    return acc+"&runs[]="+cur
            },""); //TODO reimplement this
        let res = window.open(url,"_blank");
        if(res)
          dispatch(runPrinted());
        // axios.get(url).then(res => {
        //     let data = res.data
        //     var downloadLink      = document.createElement('a');
        //       downloadLink.target   = '_blank';
        //       downloadLink.download = 'runs.pdf';
        //
        //       // convert downloaded data to a Blob
        //       var blob = new Blob([data], { type: 'application/pdf' });
        //
        //       // create an object URL from the Blob
        //       var URL = window.URL || window.webkitURL;
        //       var downloadUrl = URL.createObjectURL(blob);
        //
        //       // set object URL as the anchor's href
        //       downloadLink.href = downloadUrl;
        //
        //       // append the anchor to document body
        //       document.body.appendChild(downloadLink);
        //
        //       // fire a click event on the anchor
        //       downloadLink.click();
        //
        //       // cleanup: remove element and revoke object URL
        //       document.body.removeChild(downloadLink);
        //       URL.revokeObjectURL(downloadUrl);        })
    };

    // return {
    //     type: "PRINTED"
    // }
};
export const gotRun = (run) => {
    return {
        type: ADD_RUN,
        payload: run
    }

};
export const updateRun = (run) => {
    return {
        type: UPDATE_RUN,
        payload: run
    }
};
export const runStarted = (run) => {
    return {
        type: STARTED_RUN,
        payload: run
    }
};
export const startRun = (run) => {
    return dispatch => {
        api.post("/runs/"+run.id+"/start")
            .then((res)=>{
                console.log("run started");
                console.log(res);
                dispatch(runStarted(res.data));
                dispatch(updateRun(res.data))
            })
            .catch((res)=> {
                console.log(res);
                dispatch(fetchingFailed(res))
            })
    }
};
export const resetRuns = () => {
    return dispatch => {
        dispatch(deleteRuns());
        dispatch(fetchRuns())
    }
};
export const deleteRuns = () => {
    return {
        type: RESET_RUNS
    }
};
export const deleteRun = (run) => {

  return {
      type: DELETE_RUN,
      payload: run
  };
    return dispatch => {
        api.delete("/runs/"+run.id)
            .then((res)=>{
                dispatch({
                    type: DELETE_RUN,
                    payload: run
                })
            })
            .catch((res)=>{
                console.log(res);
                dispatch(fetchingFailed(res))
            })
    }
};
export const addRun = (run) => {
    return {
        type: ADD_RUN,
        payload: run
    }
};
export const removeRun = (run) => {
    return {
        type: DELETE_RUN,
        payload: run
    }
};
export const apiError = (error) => {
  return {
    type: API_ERROR,
    error
  }
};
export const fetchingFailed = (error) => {
    return {
        type:FETCHING_RUN_FAILED,
        error
    }
};
export const fetchRuns = () => {
    return (dispatch) => {
        api.get("/runs?sortBy=planned_at,status&finished=true").then(
            res => dispatch(gotRuns(res.data))
        )
        .catch((res)=>{
            dispatch(fetchingFailed(res))
        })
    }
};
