import React from 'react'
import PropTypes from 'prop-types';
import Waypoint from './Waypoint'

const WaypointList = ({run,points}) => (
    <ul className="waypoint-list" key={"waypoint"-run}>
        {points.map( (p,i) =>{
            let icon = (i<points.length -1)  ? (<span className="glyphicon glyphicon-arrow-right" />) : null
            return (<Waypoint key={`waypoint-${run}-${p.id}-${i}`} point={p} icon={icon} />)
        }

        )}
    </ul>
)

WaypointList.propTypes = {
    points: PropTypes.array.isRequired,
    run: PropTypes.number.isRequired
}

export default WaypointList