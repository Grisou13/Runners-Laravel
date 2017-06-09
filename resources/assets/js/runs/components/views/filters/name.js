import React from 'react'

const NameFilter = ({name, changeName}) => {

  return (
    <div className="form-group">
      <input className="form-control" type="text" value={name} onChange={(e)=>changeName(e.target.value)} placeholder="Artist" />
    </div>
  )
}

export default NameFilter
