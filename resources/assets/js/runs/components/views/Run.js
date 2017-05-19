import React from 'react'
import PropTypes from 'prop-types'
import moment from 'moment'
import WaypointList from './WaypointList'
import RunDetails from './RunDetails'
import SubscriptionList from './SubscriptionList'
const Run = ({status, id, waypoints, runners, title, note, begin_at, nb_passenger, startRun, editRun, stopRun}) => {
    var t = run.begin_at ? `${moment(run.begin_at).format("HH:mm")}` : null

    return (
        <div className={status + ' run-container'} /*onMouseLeave={(e)=>this.props.updateUI({hoverRun:null})} onMouseOver={(e)=>this.props.updateUI({hoverRun:run.id})}*/ >
            <div className="btn-container">
                <a href="#" onClick={()=>editRun(run)} className="control"><span className="glyphicon glyphicon-edit" /></a>
                <a href="#" onClick={()=>startRun(run)} className="control">
                    <span className="glyphicon glyphicon-play" />
                </a>
                <a href="#" onClick={()=>endTheRun(run)} className="control"><span className="glyphicon glyphicon-ban-circle" /></a>
                {/*<a href="#" onClick={()=>this.props.dispatch(deleteRun(run))} className="control"><span className="glyphicon glyphicon-minus"></span></a>*/}
            </div>

            <div className="run" /*style={{transform: (this.props.ui.hoverRun != null && this.props.ui.hoverRun==run.id )? "translateX(50px)": "" }}*/>
                <div className="col-md-3 col-xs-12 col-sm-4">
                    <RunDetails title={title} nb_passenger={nb_passenger} note={note ? note : ""} date={begin_at} />
                </div>
                <div className="col-md-5 col-xs-12 col-sm-5">
                    <div className="row">
                        <WaypointList run={id} points={waypoints} />
                    </div>
                    <div className="row">
                        <span className="time">{ t }</span>
                    </div>
                </div>
                <div className="col-md-4 col-xs-12 col-sm-3">
                    <SubscriptionList run={id} subs={runners} />
                </div>
            </div>
        </div>
    )
}
Run.propTypes = {

    id:PropTypes.number.isRequired,
    title: PropTypes.string.isRequired,
    status: PropTypes.string.isRequired,
    nb_passenger: PropTypes.number.isRequired,
    note: PropTypes.string,
    begint_at: PropTypes.any.isRequired,
    waypoints: PropTypes.array.isRequired,
    runners: PropTypes.array.isRequired

}
export default Run
