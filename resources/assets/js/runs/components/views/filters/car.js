import React from 'react'

const CarFilter = ({car, changeCar}) => {

  return (
    <div>
      <input type="text" className="form-control" value={car} onChange={(e)=>changeCar(e.target.value)} placeholder="voiture" />
    </div>
  )
}

export default CarFilter
