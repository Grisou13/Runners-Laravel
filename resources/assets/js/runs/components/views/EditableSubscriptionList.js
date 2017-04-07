import React, {PropTypes} from 'react'
import EditableSubscription from './EditableSubscription'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'
import AddUserButton from './subs/AddUserButton'

const SubscriptionList = ({subs = []}) =>(
    <div className="subscription col-md-4 col-xs-12" style={{height:"100%", minHeight:"100px"}}>
        {subs.map( sub =>
            (<EditableSubscription key={sub.id}  sub={sub} user={sub.user} car={sub.car} car_type={sub.vehicule_category} />)
        )}
    </div>
)


const mapStateToProps = (state) => {
    return {
        subs: state.runs.map
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        dispatch: dispatch
    }
}
export default SubscriptionList
//export default connect(mapStateToProps)(Subscriptionlist)