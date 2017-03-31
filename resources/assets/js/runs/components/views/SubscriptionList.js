import React, {PropTypes} from 'react'
import Subscription from './Subscription'
import AddCarTypeButton from './subs/AddCarTypeButton'
import AddCarButton from './subs/AddCarButton'
import AddUserButton from './subs/AddUserButton'

const SubscriptionList = ({subs = []}) =>(
    <div className="subscription col-md-4 col-xs-12">
        {/*<div className="row">*/}
        {/*<div className="col-md-6">*/}
        {/*<AddCarTypeButton/>*/}
        {/*<AddCarButton/>*/}
        {/*</div>*/}
        {/*<div className="col-md-6">*/}
        {/*<AddUserButton/>*/}
        {/*</div>*/}
        {/*</div>*/}
        {subs.map( sub =>
            (<div className="row" key={sub.id}>
                <Subscription  sub={sub} user={sub.user} car={sub.car} car_type={sub.car_type} />
            </div>)
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