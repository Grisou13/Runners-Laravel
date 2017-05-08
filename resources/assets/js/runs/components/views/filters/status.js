import React from 'react'
import PropTypes from 'prop-types';
import {FILTER_STATUS} from "../../../actions/consts";


const StatusFilter = ({status,addFilter, removeFilter}) => {
    const handleChange = (event) => {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
        if(!value) //if unchecked and is in status array, remove it
            removeFilter(name)
        else
            addFilter(name)
    }
    return (
        <div>
            <input type="checkbox" name="error" checked={status.indexOf("error") > -1 } onChange={handleChange}/><span>Problème</span>
            <input type="checkbox" name="needs_filling" checked={status.indexOf("needs_filling") > -1 } onChange={handleChange}/><span>Manque voiture</span>
            <input type="checkbox" name="needs_filling" checked={status.indexOf("needs_filling") > -1 } onChange={handleChange}/><span>Manque chauffeur</span>
            <input type="checkbox" name="ready" checked={status.indexOf("ready") > -1 } onChange={handleChange} /><span>Prêt</span>
        </div>
    )
}

StatusFilter.propTypes = {

}

export default StatusFilter