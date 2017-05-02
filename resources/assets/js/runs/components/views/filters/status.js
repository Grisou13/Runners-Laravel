import React from 'react'
import PropTypes from 'prop-types';
import {FILTER_STATUS} from "../../../actions/consts";

const handleChange = (event) => {
    console.log(this)
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    if(!value) //if unchecked and is in status array, remove it
        removeFilter(name)
    else
        addFilter(name)
}
const StatusFilter = ({status,addFilter, removeFilter}) => {
    console.log(status)
    return (
        <div>
            <input type="checkbox" name="error" checked={status.indexOf("error") > -1 } onChange={handleChange.bind({addFilter,removeFilter})}/><span>Problème</span>
            <input type="checkbox" name="missing_car" checked={status.indexOf("missing_car") > -1 } onChange={handleChange.bind({addFilter,removeFilter})}/><span>Manque voiture</span>
            <input type="checkbox" name="missing_user" checked={status.indexOf("missing_user") > -1 } onChange={handleChange.bind({addFilter,removeFilter})}/><span>Manque chauffeur</span>
            <input type="checkbox" name="ready" checked={status.indexOf("ready") > -1 } onChange={handleChange.bind({addFilter,removeFilter})} /><span>Prêt</span>
        </div>
    )
}

StatusFilter.propTypes = {

}

export default StatusFilter