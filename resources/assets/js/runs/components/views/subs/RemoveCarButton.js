import React, {PropTypes} from 'react'

const RemoveCar = ({sub,car}) => (
    <button className="btn btn-danger searchable" name="button" >
        <span className="glyphicon glyphicon-minus-sign"></span>
        <span>{car.name}</span>
    </button>
)

export default RemoveCar