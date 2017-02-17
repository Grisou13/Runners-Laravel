/**
 * Created by Eric.BOUSBAA on 17.02.2017.
 */
function _getDates(startDate, stopDate) {
    // https://momentjs.com/
    // credits to http://stackoverflow.com/questions/4413590/javascript-get-array-of-dates-between-2-dates
    var dateArray = [];
    var currentDate = moment(startDate);
    var stopDate = moment(stopDate);
    while (currentDate <= stopDate) {
        dateArray.push( moment(currentDate).format('YYYY-MM-DD') );
        currentDate = moment(currentDate).add(1, 'days');
    }
    return dateArray;
}
function ajaxRequest(url, data, callback, method) {
    return $.ajax({
        url: url,
        type: method,
        data: data,
        success: callback
    });
}

function createGrid(days){


}
function getAllGroups(){
    
    return false;
}
/*
 * Get all days where we can assign schedule
 */
function getAllDays(){
    //TODO query the api to get the days in config
    //ajax
    //for the moment, we only return an array of dates from now in one week
    return _getDates(moment().format(), moment().add(1, "week").format());

}
/*
 * Return all the schedules in a given day
 */
function getSchedulePerDay(day){
    //TODO
    //ajax
}
function addSchedule(day, group){
    //TODO
    //ajax
}



/*
* Contains all the day that have been changed in te grid.
* We only read and update the days in this array
* */
var days = getAllDays();
createGrid(days);
var dayChanged = [];
var groups = getAllGroups();