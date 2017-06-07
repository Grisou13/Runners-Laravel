/**
 * Created by Thomas.RICCI on 09.05.2017.
 */
import React from 'react'
import PropTypes from 'prop-types';
import {timeSplitter} from "../../../utils";

// const TimeFilter = ({time, changeTimeEnd, changeTimeStart}) => {
//     const changeTime = (e) => {
//         if(e.target.value.length >= 3 && e.target.value.indexOf(":"))
//             changeTimeStart(e.target.value)
//         return e
//     }
//     return (
//         <div>
//             Entre:
//             <input className="form-control input-filter" type="text" value={time.start} onChange={(e)=>changeTime(e)} placeholder="08:00" />
//             Et:
//             <input className="form-control input-filter" type="text" value={time.end} onChange={(e)=>changeTimeEnd(e.target.value)} placeholder="18:00" />
//         </div>
//     )
// }

class TimeFilter extends React.Component {
    // changeTimeStart = (e) => {
    //     if(e.target.value.length >= 3 && e.target.value.indexOf(":"))
    //         changeTimeStart(e.target.value)
    //     return e
    // }
    changeTime = (e, cb) => {
        // let state = {}
        // state[e.target.name] = e.target.value
        // console.log(e)
        const val = ""+e.target.value
        this.setState({
            [e.target.name]:val
        })
        console.log(e.target.name)
        console.log(e.target.value)
        console.log(this.state)
        if(val.match(timeSplitter))
            cb(val)
        else
            if(this.props.time[e.target.name] != "")
                cb("")
    }
    // shouldComponentUpdate(nextProps, nextState){
    //     return nextProps.time != this.props.time || this.state != nextState
    // }
    componentWillMount(){
        this.setState({
            start: this.props.time.start,
            end: this.props.time.end
        })
    }
    render(){
        console.log(this.state);
        return (
            <div>
                Entre:
                <input className="form-control input-filter" name="start" type="text" value={this.state.start} onChange={(e)=>this.changeTime(e,this.props.changeTimeStart)} placeholder="08:00" />
                Et:
                <input className="form-control input-filter" name="end" type="text" value={this.state.end} onChange={(e)=>this.changeTime(e,this.props.changeTimeEnd)} placeholder="18:00" />
            </div>
        )
    }
}

TimeFilter.propTypes = {
    time:PropTypes.shape({
        start: PropTypes.string.isRequired,
        end: PropTypes.string.isRequired
    }).isRequired,
    changeTimeEnd: PropTypes.func.isRequired,
    changeTimeStart: PropTypes.func.isRequired
}

export default TimeFilter