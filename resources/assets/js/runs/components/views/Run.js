/**
 * Created by Thomas.RICCI on 10.05.2017.
 */
import React from 'react'
import PropTypes from 'prop-types'
import WaypointList from './WaypointList'
import RunDetails from './RunDetails'
import SubscriptionList from './SubscriptionList'

const Run = ({run, startRun, editRun}) => {
var date = moment(run.begin_at)
var t = run.begin_at ? `${date.format("HH:mm")}` : null
return (
    <div id={"run-"+run.id} className={run.status + ' run-container'} /*onMouseLeave={(e)=>this.props.updateUI({hoverRun:null})} onMouseOver={(e)=>this.props.updateUI({hoverRun:run.id})}*/ >
        <div className="btn-container">
            <a href={()=>editRun(run)} className="control"><span className="glyphicon glyphicon-edit" /></a>
            <a href="#" onClick={()=>startRun(run)} className="control"><span className="glyphicon glyphicon-play" /></a>
            {/*<a href="#" onClick={()=>this.props.dispatch(deleteRun(run))} className="control"><span className="glyphicon glyphicon-minus"></span></a>*/}
        </div>

        <div className="run" /*style={{transform: (this.props.ui.hoverRun != null && this.props.ui.hoverRun==run.id )? "translateX(50px)": "" }}*/>
            <div className="col-md-3 col-xs-6 col-sm-2">
                <RunDetails title={run.title} nb_passenger={run.nb_passenger} note={run.note} date={run.begin_at} />
            </div>
            <div className="col-md-5 col-xs-6 col-sm-7">
                <div className="row">
                    <WaypointList run={run} points={run.waypoints} />
                </div>
                <div className="row">
                    <span className="time">{ t }</span>
                </div>
            </div>
            <div className="col-md-4 col-xs-12 col-sm-3">
                <SubscriptionList subs={run.runners} />
            </div>
        </div>
    </div>
)
}