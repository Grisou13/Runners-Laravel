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

function ajaxRequest(method, url, data, callback = false) {
    // http://es6-features.org/#DefaultParameterValues
    var returnedData = "false";
    $.ajax({
        url: url,
        type: method,
        data: data,
        async: false, //yeah i know
        success: callback ? callback : function(response){
                returnedData = response;
            }
    });
    return returnedData;
}

function createGrid(schedule, days){
    var container = document.getElementsByClassName("grid");
    var grid = document.createElement("table");
    grid.style.width  = "80%";
    grid.setAttribute("border", "1");
    var inHead = true;

    //http://stackoverflow.com/questions/14643617/create-table-using-javascript
    schedule.forEach(function(hour){
        var header = document.createElement("th");
        if(inHead){
            //in table header

            // td.appendChild(document.createTextNode('\u0020'))
            inHead = false;
        }else{
            //in table body
        }
    });

    //container.append(grid);
}

function getAllGroups(){
    var url = window.Laravel.basePath + "/api/groups?token=root";
    return ajaxRequest("get", url, "");
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
var schedule = ["08:00", "10:00",
                "12:00", "14:00",
                "16:00", "18:00",
                "20:00", "22:00",
                "00:00", "02:00",
                "04:00", "06:00"];
createGrid(schedule, days);
var dayChanged = [];
var groups = getAllGroups();
console.log(groups);