import React from 'react'
import PropTypes from 'prop-types';
const AddCar = ({sub,car_type = null}) => (
    <button className="btn btn-info searchable" name="button" >
        <span className="glyphicon glyphicon-plus-sign" />
        <span>{car_type ? "Voiture "+car_type.type : "Voiture"}</span>
    </button>
)

export default AddCar