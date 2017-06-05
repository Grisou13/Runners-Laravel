import React from 'react'
import PropTypes from 'prop-types';
const RemoveUser = ({sub,user}) => (
    <button className="btn btn-danger searchable" name="button" >
        <span className="glyphicon glyphicon-minus-sign" />
        <span>{user.name}</span>
    </button>
)

export default RemoveUser