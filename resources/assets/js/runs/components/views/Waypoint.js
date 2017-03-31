import React, {PropTypes} from 'react'

const Waypoint = ({point})=>(
    <li>{point.nickname}</li>
)

Waypoint.propTypes = {
    point: PropTypes.shape({
        id: PropTypes.number.isRequired,
        nickname: PropTypes.string.isRequired,
        geocoder: PropTypes.any.isRequired
    }).isRequired
}

export default Waypoint