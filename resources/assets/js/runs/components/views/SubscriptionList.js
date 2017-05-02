import React from 'react'
import PropTypes from 'prop-types';

import Subscription from './Subscription'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'
import AddUserButton from './subs/AddUserButton'

const SubscriptionList = ({subs = []}) =>(
    <div className="subscription" style={{height:"100%", minHeight:"100px"}}>
        {subs.map( sub =>
            (<Subscription key={sub.id}  sub={sub} user={sub.user} car={sub.car} car_type={sub.vehicule_category} />)
        )}
    </div>
)

SubscriptionList.propTypes = {

}

export default SubscriptionList
