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
    if(user != null)
        userBtn = (<RemoveUserButton sub={sub} user={user} />)
    else
      userBtn = (<AddUserButton sub={sub.id} />)
    if(car != null)
        carBtn = (<RemoveCarButton sub={sub} car={car} />)
    else{
        if(car_type != null)
            carBtn = (<div><AddCarButton sub={sub} car_type={car_type} /><RemoveCarTypeButton sub={sub} car_type={car_type} /></div>)
        else
            carBtn = (<div><AddCarButton sub={sub} /><AddCarTypeButton sub={sub} /></div>)
    }
     return (
         <div>
             <div className="col-md-6">
                 {carBtn}
             </div>
             <div className="col-md-6">
                 {userBtn}
             </div>
         </div>

     );
}

export default Subscription