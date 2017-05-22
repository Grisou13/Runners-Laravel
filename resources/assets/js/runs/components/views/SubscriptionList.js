import React from 'react'
import PropTypes from 'prop-types';

import Subscription from './Subscription'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'
import AddUserButton from './subs/AddUserButton'

const SubscriptionList = ({run,subs = []}) =>(
    <div className="subscription" style={{height:"100%", minHeight:"100px"}}>
        {subs.map( (sub, i, all) => {
            console.log(sub)
             return   (
                    <div key={"sub-"+sub.id}>
                        <Subscription key={`sub-${run}-${sub.id}`}  {...sub}/>
                    </div>
                )
            }
        )}
    </div>
)

SubscriptionList.propTypes = {
    subs: PropTypes.array.isRequired,
    run: PropTypes.number.isRequired
}

export default SubscriptionList
