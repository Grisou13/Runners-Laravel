import React, {PropTypes} from 'react'

const AddUserButton = ({}) =>(
    <div>
        <button className="btn btn-info searchable" name="button" data-searchable="users">
            <span className="glyphicon glyphicon-plus-sign"></span>
            <span>Utilisateur</span>
        </button>
    </div>
)

export default AddUserButton