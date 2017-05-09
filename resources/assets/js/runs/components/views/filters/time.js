/**
 * Created by Thomas.RICCI on 09.05.2017.
 */
import React from 'react'
import PropTypes from 'prop-types';

const TimeFilter = ({time, changeTimeEnd, changeTimeStart}) => {
    return (
        <div>
            <input type="text" value={time.start} onChange={(e)=>changeTimeStart(e.target.value)} />
            <input type="text" value={time.end} onChange={(e)=>changeTimeEnd(e.target.value)} />
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