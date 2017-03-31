import React, {PropTypes} from 'react'

const Status = ({status}) => {
    let klassses = ["status",status].join(" ")
    return (
        <div className="col-md-1 col-xs-1 status-wrapper">
            <label htmlFor="" className={klassses} >{status}</label>
        </div>
    )
}

Status.propTypes = {
    status:PropTypes.string.isRequired,
}

export default Status