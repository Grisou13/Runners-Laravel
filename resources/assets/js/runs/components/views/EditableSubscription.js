import React, {PropTypes} from 'react'

import AddUserButton from './subs/AddUserButton'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'

import RemoveUserButton from './subs/RemoveUserButton'
import RemoveCarButton from './subs/RemoveCarButton'
import RemoveCarTypeButton from './subs/RemoveCarTypeButton'


const Subscription = ({sub,user=null,car=null,car_type=null}) => {
    let userBtn = null;
    let carBtn = null;
    let carTypeBtn = null;
    if(user != null)
        userBtn = (<RemoveUserButton sub={sub} user={user} />)
    else
        userBtn = (<AddUserButton sub={sub.id} />)
    if(car != null)
        carBtn = (<RemoveCarButton sub={sub} car={car} />)
    else
        carBtn = (<AddCarButton sub={sub} />)
    if(car_type != null)
        carTypeBtn = (<RemoveCarTypeButton sub={sub} car_type={car_type} />)
    else
        carTypeBtn = (<AddCarTypeButton sub={sub} />)

    return (
        <div className="row" style={{ height:"100%", minHeight:"100px" }}>
            <div className="col-md-6 col-xs-6 car">
                <span>{car_type? car_type.type : carTypeBtn}</span>
                <span className="">{car ? car.name: carBtn}</span>
            </div>
            <div className="col-md-6 col-xs-6 user">
                <span className="">{user ? user.name: userBtn}</span>
            </div>
        </div>

    );
}

export default Subscription