/**
 * Created by Eric.BOUSBAA on 17.02.2017.
 */

function _hexToRgb(hex){
    // credits to http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
}

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

function updateCell(cellID){
    console.log("UPDATE");
    let cell = document.getElementById(cellID);
    cellID = cellID.split("-");
    let groupID = cellID[0];
    let startHour = schedule[cellID[1]];
    let endHour = moment.duration(startHour).add("00:30", "minutes");
    let minutes = null;
    // turn 18:00 to 18:30 and 18:30 to 19:00
    endHour.minutes().toString().length == 1 ? minutes = endHour.minutes().toString() + "0" : minutes = endHour.minutes().toString();
    endHour = endHour.hours().toString() + ":" + minutes;

    let date = cellID.splice(2,3).join("-");
    let selGrp = groups.filter(function(x){
        return x.id == groupID;
    })[0];

    if(cell.dataset.assigned === "true"){
        let url = window.Laravel.basePath + "/api/schedules/" + cell.dataset.scheduleId + "?token=root";
        cell.dataset.assigned = "false";
        ajaxRequest("delete", url, "", console.log);
    }else{
        cell.dataset.assigned = "true";
        cell.style.backgroundColor = "#" + selGrp.color;
        let url = window.Laravel.basePath + "/api/groups/"+groupID+"/schedules?token=root"
        let data = {
            "start_time": date + " " + startHour,
            "end_time": date + " " + endHour,
            "group": groupID
        };
        let assignDataId = function(scheduleCreated){
            cell.dataset.scheduleId = scheduleCreated.id;
            console.log("Sucess ! Assigned...")
        };

        ajaxRequest("post", url, data, assignDataId);
    }
}

function createTable(schedule, groups, day, gridID){
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
    th.style.width = "25%";
    th.innerHTML = "Groupes";
    headerTR.appendChild(th);

    schedule.forEach(function(hour){
        var th = document.createElement("th");
        th.innerHTML = hour;
        th.style.webkitTransform = "rotate(-65deg)";
        th.style.height = "45px";
        headerTR.appendChild(th);
    });
    theader.appendChild(headerTR);
    var bgColor;

    // listener vars
    var isdown = false;
    var modified = [];
    var lin = 0;

    groups.forEach(function(group){
        var bodyTR = document.createElement("tr");
        var td = document.createElement("td");
        td.style.cursor = "none";
        td.innerHTML = "Grp. " + group.name;
        td.style.color = "white";
        var rgb = _hexToRgb(group.color);
        td.style.backgroundColor = "rgba("+ [rgb["r"], rgb["g"], rgb["b"], 0.9].join(",") + ")";

        bodyTR.appendChild(td);
        schedule.forEach(function(hour){
            schedule.indexOf(hour) % 2 == 0 ? bgColor = "white" : bgColor = "#ECEFF1";
            // if(hour == "08")
            var td = document.createElement("td");
            td.setAttribute("id", group.id + "-" + schedule.indexOf(hour) + "-" + day);
            td.dataset.bgColor = bgColor;
            td.dataset.gridID = gridID;
            td.style.backgroundColor = bgColor;
            td.dataset.assigned = "false";
            // is our cell assigned ?
            if(typeof group.schedules !== 'undefined' && group.schedules.length > 0){
                group.schedules.forEach(function(p){
                    let datetime = p.start_time.split(" ");

                    if((datetime[0] === day) && (datetime[1] === hour+":00")){
                        td.style.backgroundColor = "#" + group.color;
                        td.dataset.scheduleId = p.id;
                        td.dataset.assigned = "true";
                    }
                });
            }

            // change color of the given cell (based on the group, or return to bgColor)
            var changeColor = function(td){
                if(td.dataset.assigned == "false"){
                    td.style.backgroundColor = "#" + group.color;
                }else{
                    td.style.backgroundColor = td.dataset.bgColor;
                }
            };
            td.addEventListener("mousedown", function(e){
                isdown = true;
                lin = group.id;
                modified.push(td.id);
                changeColor(td);
                return false;
            });

            td.addEventListener("mouseover", function(e){
                if(isdown){
                    if(lin == group.id){
                        modified.push(td.id);
                        changeColor(td);
                    }
                }
                return false;
            });

            td.addEventListener("mouseup",function(e){
                // TODO maybe use time-slot instead of using each cell independently
                console.log("before update");
                loadingDiv.style.display = "block";

                modified.map(function(cellID){
                    updateCell(cellID);
                    // update the state of each selected div
                });
                console.log("updated...");
                loadingDiv.style.display = "none";

                modified = [];
                isdown = false;
            });

            // td.onclick = cellListener;
            // td.addEventListener("click", cellListener, false);
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
    let i=1;
    days.forEach(function(day){
        var dayTable = createTable(schedule, groups, day, i);
        dayTable.id = i;
        moment.locale("fr");
        let div = document.createElement("div");
        div.innerHTML = moment(day).format("LL");
        div.className = "dayDiv";
        div.style.fontSize = "25px";
        container.appendChild(div);
        container.appendChild(dayTable);
        i++;
    });
}

function getAllGroups(){
    var url = window.Laravel.basePath + "/api/groups?token=root&include=schedules";
    return ajaxRequest("get", url, "", null);
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


var days = getAllDays();

schedule = ["08:00","08:30", "09:00","09:30",
    "10:00","10:30", "11:00","11:30",
    "12:00","12:30", "13:00","13:30",
    "14:00","14:30", "15:00","15:30",
    "16:00","16:30", "17:00","17:30",
    "18:00","18:30", "19:00","19:30",
    "20:00","20:30", "21:00","21:30",
    "22:00","22:30", "23:00","23:30",
    "00:00","00:30", "01:00","01:30",
    "02:00","02:30", "03:00","03:30",
    "04:00","04:30", "05:00","05:30",
    "06:00","06:30", "07:00","07:30"
];
var loadingDiv = document.getElementById("loading");
var groups = getAllGroups();

createGrid(schedule, days, groups);

//TODO https://laravel.com/docs/5.4/dusk#waiting-for-elements
//TODO visual division of hours and day&night
//TODO 'waiting' icon (or disable table)
