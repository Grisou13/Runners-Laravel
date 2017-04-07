import React, {PropTypes} from 'react'

const RemoveUser = ({sub,user}) => (
    <button className="btn btn-danger searchable" name="button" >
        <span className="glyphicon glyphicon-minus-sign"></span>
        <span>{user.name}</span>
    </button>
)

export default RemoveUser