/**
 * Created by Thomas.RICCI on 09.05.2017.
 */
import React from 'react'
import PropTypes from 'prop-types';

const TimeFilter = ({time, changeTimeEnd, changeTimeStart}) => {
    return (
        <div>
            Entre:
            <input className="form-control input-filter" type="text" value={time.start} onChange={(e)=>changeTimeStart(e.target.value)} placeholder="08:00" />
            Et:
            <input className="form-control input-filter" type="text" value={time.end} onChange={(e)=>changeTimeEnd(e.target.value)} placeholder="18:00" />
        </div>
    )
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