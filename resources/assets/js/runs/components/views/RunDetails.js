import React, {PropTypes} from 'react'

const RunDetails = ({title, nb_passenger, date}) => (
    <div className="col-md-3 col-xs-11 text-center run-details">
        <div className="container-fluid">
            <div className="row">
                <div className="col-md-12">
                    <div className="date">
                        { date }
                    </div>
                    <div className="title">
                        { title }
                    </div>
                    <div className="passengers">
                        { nb_passenger } personnes
                    </div>

                </div>
            </div>
        </div>
    </div>
)
RunDetails.propTypes = {
    title:PropTypes.string.isRequired,
    nb_passenger:PropTypes.number.isRequired,
    date:PropTypes.string.isRequired
}

export default RunDetails