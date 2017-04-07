import React, {PropTypes} from 'react'

import AddCarTypeButton from './AddCarTypeButton'
import AddCarButton from './AddCarButton'
import AddUserButton from './AddUserButton'

const AddSub = ({run, addRun}) => {
    return (
        <div>
            <div className="col-md-2">
                <AddCarTypeButton />
            </div>
            <div className="col-md-2">
                <AddCarButton/>
            </div>
            <div className="col-md-1 col-md-push-1">
                <AddUserButton />
            </div>
        </div>

    )
}

AddSub.propTypes = {
    run: PropTypes.shape({
        id:PropTypes.number.isRequired,
        name: PropTypes.string.isRequired,
        status: PropTypes.string.isRequired
    }).isRequired,
    addRun: PropTypes.func.isRequired
}

export default AddSub