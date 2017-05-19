/**
 * Created by thomas_2 on 29.04.2017.
 */

import wsService from './websocket'
import printService from './print'
export default (dispatcher) => {
    wsService(dispatcher)
    printService(dispatcher)
}