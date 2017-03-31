import React, {PropTypes} from 'react'
import Waypoint from './Waypoint'

const WaypointList = ({runId,points}) => (
    <div key={"waypoint"-runId} className="col-md-6 col-xs-12">
        <ul className="waypoint-list">
            {points.map( (p,i) =>{
                let icon = i<points.length -1  ? (<span className="glyphicon glyphicon-arrow-right" />) : null
                return (<Waypoint key={`waypoint-${runId}-${p.id}-${i}`} point={p} icon={icon} />)
            }

            )}
        </ul>
    </div>
)

WaypointList.propTypes = {
    points: PropTypes.arrayOf(Waypoint.propTypes.point).isRequired,
    runId: PropTypes.number.isRequired
}

export default WaypointList