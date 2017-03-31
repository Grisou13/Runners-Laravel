const statusFilter = (state = "ALL", action) => {
    switch (action.type) {
        case 'SET_STATUS_FILTER':
            return action.filter
        default:
            return state
    }
}

export default statusFilter