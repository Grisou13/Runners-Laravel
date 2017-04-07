import React, {PropTypes} from 'react'

const Waypoint = ({point, icon = null})=>(
    <li>{point.nickname} {icon}</li>
)

Waypoint.propTypes = {
    point: PropTypes.shape({
        id: PropTypes.number.isRequired,
        nickname: PropTypes.string.isRequired,
        geocoder: PropTypes.any.isRequired
    }).isRequired,
    icon: PropTypes.node
}

export default Waypoint