import React, {PropTypes} from 'react'
import {FILTER_STATUS} from "../../../actions/consts";

const handleChange = (event,status,filter) => {
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    if(!value && status.indexOf(name) > -1) //if unchecked and is in status array, remove it
        filter(FILTER_STATUS,[status.splice(status.indexOf(name),1)])
    else
        filter(FILTER_STATUS,[...status, name])
}
const StatusFilter = ({status,filter}) => {
    return (
        <div>
            <input type="checkbox" name="error" checked={()=>status.indexOf("error") > -1 }/><span>Problème</span>
            <input type="checkbox" name="missing_car" checked={()=>status.indexOf("missing_car") > -1 }/><span>Manque voiture</span>
            <input type="checkbox" name="missing_user" checked={()=>status.indexOf("missing_user") > -1 }/><span>Manque chauffeur</span>
            <input type="checkbox" name="ready" checked={()=>status.indexOf("ready") > -1 } onChange={(e)=>handleChange(e,status,filter)}/><span>Prêt</span>
        </div>
    )
}