import React, {PropTypes} from 'react'

const AddCar = ({sub,car_type = null}) => (
    <button className="btn btn-info searchable" name="button" >
        <span className="glyphicon glyphicon-plus-sign"></span>
        <span>Voiture</span>
    </button>
)

export default AddCar