import React from 'react'
import PropTypes from 'prop-types';

import AddUserButton from './subs/AddUserButton'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'

import RemoveUserButton from './subs/RemoveUserButton'
import RemoveCarButton from './subs/RemoveCarButton'
import RemoveCarTypeButton from './subs/RemoveCarTypeButton'


const Subscription = ({id, user=null,car=null,vehicule_category=null}) => {
    let userBtn = null;
    let carBtn = null;
    let carTypeBtn = null;
    // if(user != null)
    //     userBtn = (<RemoveUserButton sub={sub} user={user} />)
    // else
    //   userBtn = (<AddUserButton sub={sub.id} />)
    // if(car != null)
    //     carBtn = (<RemoveCarButton sub={sub} car={car} />)
    // else
    //     carBtn = (<AddCarButton sub={sub} />)
    // if(car_type != null)
    //     carTypeBtn = (<RemoveCarTypeButton sub={sub} car_type={car_type} />)
    // else
    //     carTypeBtn = (<AddCarTypeButton sub={sub} />)

    let style={ height:"100%", minHeight:"100px" }
     return (
         <div className="row sub" >
             <div className="col-md-6 col-xs-6 car">
                 <span className="">{car ? car.name: (vehicule_category ? vehicule_category.type: " ")}</span>
             </div>
             <div className="col-md-6 col-xs-6 user">
                 <span className="">{user ? (user.name ? user.name : user.firstname+user.lastname ): " "}</span>
             </div>
         </div>

     );
}
Subscription.propTypes = {
    user: PropTypes.shape({
        firstname:PropTypes.string.isRequired,
        lastname:PropTypes.string.isRequired,
        name:PropTypes.string
    }),
    car: PropTypes.shape({
        name:PropTypes.string.isRequired
    }),
    vehicule_category:PropTypes.shape({
        type: PropTypes.string.isRequired
    }),
    id: PropTypes.number.isRequired
}
export default Subscription