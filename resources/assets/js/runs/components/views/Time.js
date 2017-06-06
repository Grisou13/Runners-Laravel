import React from 'react'
import PropTypes from 'prop-types';
import moment from 'moment'
class Time extends React.Component{
    constructor(props){
        super(props)
        this.state = {date: moment()}
    }
    setTime(){

        // var currentdate = new Date();
        // var hours = currentdate.getUTCHours() + this.props.UTCOffset;
        //
        // // correct for number over 24, and negatives
        // if( hours >= 24 ){ hours -= 24; }
        // if( hours < 0   ){ hours += 12; }
        //
        // // add leading zero, first convert hours to string
        // hours = hours + "";
        // if( hours.length == 1 ){ hours = "0" + hours; }
        //
        // // minutes are the same on every time zone
        // var minutes = currentdate.getUTCMinutes();
        //
        // // add leading zero, first convert hours to string
        // minutes = minutes + "";
        // if( minutes.length == 1 ){ minutes = "0" + minutes; }
        //
        // var seconds = currentdate.getUTCSeconds()
        this.setState({
            date: moment()
        });
    }
    componentWillUnmount(){
        clearInterval(this.interval);
    }
    componentDidMount(){
        this.setTime();
        this.interval = window.setInterval(function () {
            this.setTime();
        }.bind(this), 60*1000);
    }
    render() {
        return(
            <div className="time-row">
                <span className="time">{this.state.date.format("DD/MM/YY HH:mm")}</span>
            </div>
        )
    }
}
Time.propTypes = {
    UTCOffset: PropTypes.number.isRequired
}

export default Time