import React from 'react'
import PropTypes from 'prop-types';
import moment from 'moment'

const RunDetails = ({title, nb_passenger, date, note}) => {
    let d = `${moment(date).format("DD/MM")}`

    return(
        <div className="text-center run-details">
            <div className="date">
                { d }
            </div>
            <div className="title">
                { title }
            </div>
            <div className="passengers">
                { nb_passenger } personnes
            </div>
            <div className="notes">
                {note ? note : ""}
            </div>
        </div>
    )
}
RunDetails.propTypes = {
    title:PropTypes.string.isRequired,
    nb_passenger:PropTypes.number.isRequired,
    date:PropTypes.string.isRequired,
    note:PropTypes.string.isRequired,
}

export default RunDetails