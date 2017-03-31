import React, {PropTypes} from 'react'

const RunDetails = ({title, nb_passenger}) => (
    <div className="col-md-2 col-xs-11 text-center">
        <div className="container-fluid">
            <div className="row">
                <div className="col-md-12">
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
}

export default RunDetails