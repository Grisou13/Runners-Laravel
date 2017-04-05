import React, {PropTypes} from 'react'

class Time extends React.Component{
    setTime(){

        var currentdate = new Date();
        var hours = currentdate.getUTCHours() + this.props.UTCOffset;

        // correct for number over 24, and negatives
        if( hours >= 24 ){ hours -= 24; }
        if( hours < 0   ){ hours += 12; }

        // add leading zero, first convert hours to string
        hours = hours + "";
        if( hours.length == 1 ){ hours = "0" + hours; }

        // minutes are the same on every time zone
        var minutes = currentdate.getUTCMinutes();

        // add leading zero, first convert hours to string
        minutes = minutes + "";
        if( minutes.length == 1 ){ minutes = "0" + minutes; }

        var seconds = currentdate.getUTCSeconds()
        console.log(currentdate)
        this.setState({
            hours: hours,
            minutes: minutes,
            seconds: seconds,
            date:currentdate
        });
    }
    componentWillMount(){
        this.setTime();
    }
    componentDidMount(){
        window.setInterval(function () {
            this.setTime();
        }.bind(this), 1000);
    }
    render() {
        return(
            <div className="time-row" ref="cityRow">
                <span className="time">{this.state.date.getDate()}/{this.state.date.getMonth()}/{this.state.date.getFullYear()} {this.state.hours}:{this.state.minutes}:{this.state.seconds}</span>
            </div>
        )
    }
}
Time.propTypes = {
    UTCOffset: PropTypes.number.isRequired
}

export default Time