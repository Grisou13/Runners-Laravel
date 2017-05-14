import React from 'react'

const NameFilter = ({name, changeName}) => {

  return (
    <div>
      <input className="form-control input-filter" type="text" value={name} onChange={(e)=>changeName(e.target.value)} />
    </div>
  )
}

export default NameFilter
