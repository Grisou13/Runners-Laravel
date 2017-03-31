import React, {PropTypes} from 'react'

const Run = ({name, nb_passenger}) => (
    <div>
        <p>{name}</p>
        <p>{nb_passenger}</p>
    </div>
)

Run.propTypes = {
    name:PropTypes.string.isRequired,
    nb_passenger:PropTypes.string.isRequired,
}

export default Run