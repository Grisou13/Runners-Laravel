import React from 'react'

const WaypointInFilter = ({waypoint_in, changeWaypointIn}) => {
  return (
    <div>
      <input type="text" className="form-control input-filter" value={waypoint_in} onChange={e => changeWaypointIn(e.target.value)} />
    </div>
  )
}
export default WaypointInFilter
