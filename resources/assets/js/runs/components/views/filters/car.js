import React from 'react'

const CarFilter = ({car, changeCar}) => {

  return (
    <div>
      <input type="text" className="form-control input-filter" value={car} onChange={(e)=>changeCar(e.target.value)} />
    </div>
  )
}

export default CarFilter
