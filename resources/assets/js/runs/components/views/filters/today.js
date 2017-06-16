import React from 'react'
import PropTypes from 'prop-types'
const TodayFilter = ({today, toggleToday}) => {
    return (
        <div className="form-inline checkbox">
            <input type="checkbox" name="today" className="checkbox-inline" checked={today} onClick={(e)=>toggleToday(e.target.checked)} />
            <span>Aujourd'hui </span>
        </div>
    )
}

TodayFilter.propTypes = {
    today: PropTypes.bool.isRequired,
    toggleToday: PropTypes.func.isRequired
}

export default TodayFilter