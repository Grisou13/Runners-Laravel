// export const UPDATING_SUB       =   "updating_sub"
// export const SUB_WAS_UPDATED    =   "sub_was_updated"
// export const ADDING_SUB         =   "adding_subscription"
// export const ADDED_SUB          =   "added_subscription"
// export const FILTER_STATUS      =   "filter_run_by_status"
// export const ADDING_WAYPOINT    =   "adding_waypoints"

export const GETTING_RUNS       =   "getting_runs"
export const ADD_RUN            =   "add_run"
export const GOT_RUNS           =   "got_runs"
export const DELETE_RUN         =   "delete_run"
export const UPDATE_RUN         =   "update_run"
export const CREATING_RUN       =   "creating_run"
export const EDIT_RUN           =   "edit_run"
export const RESET_RUNS    =   "delete_all_runs"
export const FETCHING_RUN_FAILED  = "fetching_run_failed"
export const API_ERROR            = "api_error"

export const SUBSCRIPTION_CREATED   =   "sub_created"
export const SUBSCRIPTION_UPDATED   =   "sub_updated"
export const SUBSCRIPTION_DELETED   =   "sub_deleted"

export const GOT_SUBS           =   "got_subs"
export const GET_SUB            =   "get_sub"
export const ADD_SUB            =   "add_sub"
//this will block the ui
export const EDITING_SUB            =   "editing_sub"
//this will unlock the ui
export const EDITING_SUB_FINISHED   =   "editing_sub_finished"

//thses will change and add a search field to the ui
export const ADD_USER_TO_SUB    =   "add_user_to_sub"
export const ADD_CAR_TO_SUB     =   "add_car_to_sub"
export const ADD_CAR_TYPE_TO_SUB=   "add_car_type_to_sub"

// TODO: delete or find usage for these
export const ADDED_USER_TO_SUB    =   "added_user_to_sub"
export const ADDED_CAR_TO_SUB     =   "added_car_to_sub"
export const ADDED_CAR_TYPE_TO_SUB=   "added_car_type_to_sub"

//this will be userfull to keep track of current user inputs
export const ADDING_USER_TO_SUB    =   "adding_user_to_sub"
export const ADDING_CAR_TO_SUB     =   "adding_car_to_sub"
export const ADDING_CAR_TYPE_TO_SUB=   "adding_car_type_to_sub"

//for ui

export const UI_LOADED              =   "ui_loaded"
//filters

export const ADD_FILTER             =   "filter_add"
export const REMOVE_FILTER          =   "filter_delete"
export const RESET_FILTERS          =   "filter_reset"

export const FILTER_STATUS          =   "status"
export const ADD_FILTER_STATUS              =   "add_status"
export const REMOVE_FILTER_STATUS           =   "remove_status"
export const RESET_FILTER_STATUS            =   "reset_status"

export const FILTER_NAME                    =   "filter_name"

export const FILTER_STATUS_GONE     =   "filter_status_gone"
export const FILTER_STATUS_ERROR    =   "filter_status_error"
export const FILTER_STATUS_EMERGENCY=   "filter_status_emergency"

export const FILTER_WAYPOINT_BETWEEN=   "filter_waypoint_between"
export const FILTER_WAYPOINT_IN     =   "filter_waypoint_in"

export const FILTER_USING_CAR       =   "filter_using_car"
export const FILTER_USING_USER      =   "filter_using_user"

/*display mode*/

export const TOGGLE_DISPLAY_MODE    =   "toggle_display_mode"
export const SET_DISPLAY_MODE       =   "set_display_mode"
export const RESET_DISPLAY_MODE     =   "reset_display_mode"

export const UPDATE_FILTER_TIME_START   =   "UPDATE_FILTER_TIME_START"
export const UPDATE_FILTER_TIME_END     =   "UPDATE_FILTER_TIME_END"
export const RESET_FILTER_TIME_START    =   "RESET_FILTER_TIME_START"
export const RESET_FILTER_TIME_END      =   "RESET_FILTER_TIME_END"
