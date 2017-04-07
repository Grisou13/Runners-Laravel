import React, {PropTypes} from 'react'

const RemoveCarType = ({sub,car_type}) => (
    <button className="btn btn-danger searchable" name="button" >
        <span className="glyphicon glyphicon-minus-sign"></span>
        <span>{car_type.type}</span>
    </button>
)

export default RemoveCarType