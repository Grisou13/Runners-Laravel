import React from 'react'
import PropTypes from 'prop-types';
const AddUserButton = ({}) =>(
    <div>
        <button className="btn btn-info searchable" name="button" data-searchable="users">
            <span className="glyphicon glyphicon-plus-sign" />
            <span>Utilisateur</span>
        </button>
    </div>
)

export default AddUserButton