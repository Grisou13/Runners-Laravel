import React from 'react'
import PropTypes from 'prop-types';
const RemoveCar = ({sub,car}) => (
    <button className="btn btn-danger searchable" name="button" >
        <span className="glyphicon glyphicon-minus-sign" />
        <span>{car.name}</span>
    </button>
)

export default RemoveCar