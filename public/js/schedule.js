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

function ajaxRequest(method, url, data, callback) {
    // http://es6-features.org/#DefaultParameterValues
    // refer to https://kangax.github.io/compat-table/es6/#webkit for compatibility
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

function createTable(schedule, groups, day){
    var grid = document.createElement("table");
    grid.style.width  = "80%";
    grid.setAttribute("border", "1");

    // a little help here
    // http://stackoverflow.com/questions/14643617/create-table-using-javascript
    var theader = document.createElement("thead");
    var tbody = document.createElement("tbody");

    // table header
    var headerTR = document.createElement("tr");
    var th = document.createElement("th");
    th.innerHTML = "Groupes";
    headerTR.appendChild(th);

    schedule.forEach(function(hour){
        var th = document.createElement("th");
        th.innerHTML = hour;
        headerTR.appendChild(th);
    });
    theader.appendChild(headerTR);

    // table body
    groups.forEach(function(group){
        var bodyTR = document.createElement("tr");
        var td = document.createElement("td");
        td.innerHTML = "Group n° " + group.id;
        bodyTR.appendChild(td);
        schedule.forEach(function(hour){
            var td = document.createElement("td");
            td.setAttribute("id", group.id + "-" + schedule.indexOf(hour) + " - " + day);
            bodyTR.appendChild(td);
        });
        tbody.appendChild(bodyTR);
    });

    grid.appendChild(theader);
    grid.appendChild(tbody);

    return grid
}

function createGrid(schedule, days, groups){
    var container = document.getElementsByClassName('schedule-container')[0];

    days.forEach(function(day){
        var dayTable = createTable(schedule, groups, day);
        container.appendChild(dayTable);
        
    });

}

function getAllGroups(){
    var url = window.Laravel.basePath + "/api/groups?token=root";
    return ajaxRequest("get", url, "", false);
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
var groups = getAllGroups();
createGrid(schedule, days, groups);
var dayChanged = [];
