import React, {PropTypes} from 'react'
import Subscription from './Subscri'
const Subscriptionlist = ({subs}) =>(
{this.subs.map( sub => <Subscription sub={sub} /> )}
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
export default Subscriptionlist
//export default connect(mapStateToProps)(Subscriptionlist)