import React from 'react'
import PropTypes from 'prop-types';
import {FILTER_STATUS} from "../../../actions/consts";


const StatusFilter = ({status,addFilter, removeFilter}) => {
    const handleChange = (event) => {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
        console.log(value)
        if(!value) //if unchecked and is in status array, remove it

            removeFilter(name)
        else
            addFilter(name)
    }
    return (
        <div>
            <ul className="list-unstyled">
                <li><input type="checkbox" name="error" checked={status.indexOf("error") > -1 } onChange={handleChange}/><span>Urgent</span></li>
                <li><input type="checkbox" name="needs_filling" checked={status.indexOf("needs_filling") > -1 } onChange={handleChange}/><span>Problème</span></li>
                <li><input type="checkbox" name="ready" checked={status.indexOf("ready") > -1 } onChange={handleChange} /><span>Prêt</span></li>
                <li><input type="checkbox" name="gone" checked={status.indexOf("gone") > -1 } onChange={handleChange} /><span>Parti</span></li>
                <li><input type="checkbox" name="finished" checked={status.indexOf("finished") > -1 } onChange={handleChange} /><span>Fini</span></li>
                <li><input type="checkbox" name="drafting" checked={status.indexOf("drafting") > -1 } onChange={handleChange} /><span>Pas encore publié</span></li>

            </ul>
        </div>
    )
}

StatusFilter.propTypes = {
    status: PropTypes.arrayOf(PropTypes.string).isRequired,
    addFilter: PropTypes.func.isRequired,
    removeFilter: PropTypes.func.isRequired
}

export default StatusFilter
