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
var cellListener = function(){
    var cell = this.id.split("-");
    var groupId = cell[0];
    var startHour = schedule[cell[1]];

    var endHour = cell[1] == schedule.length - 1 ? schedule[0] : schedule[parseInt(cell[1]) + 1];

    //var endHour = schedule[parseInt(cell[1]) + 1];
    var date = cell.splice(2,3).join("-");
    console.log(this);

    let selGrp = groups.filter(function(x){
        return x.id == groupId;
    })[0];

    if(this.dataset.assigned === "true"){
        let url = window.Laravel.basePath + "/api/schedules/" + this.dataset.scheduleId + "?token=root";
        this.dataset.assigned = "false";
        this.style.backgroundColor = "white";
        ajaxRequest("delete", url, "", console.log);
    }else{
        this.dataset.assigned = "true";
        this.style.backgroundColor = "#" + selGrp.color;
        let url = window.Laravel.basePath + "/api/groups/"+groupId+"/schedules?token=root";
        let data = {
            "start_time": date + " " + startHour,
            "end_time": date + " " + endHour,
            "group": groupId
        };
        var cell = this
        let assignDataId = function(scheduleCreated){

            cell.dataset.scheduleId = scheduleCreated.id;
        };
        ajaxRequest("post", url, data, assignDataId);


    }

};
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
        var rgb = _hexToRgb(group.color);
        td.style.backgroundColor = "rgba("+ [rgb["r"], rgb["g"], rgb["b"], 0.7].join(",") + ")";
        td.style.color = "white";

        bodyTR.appendChild(td);
        schedule.forEach(function(hour){
            var td = document.createElement("td");
            td.setAttribute("id", group.id + "-" + schedule.indexOf(hour) + "-" + day);

            // is our row assigned ?
            td.dataset.assigned = "false";
            if(typeof group.schedules !== 'undefined' && group.schedules.length > 0){
                group.schedules.forEach(function(p){
                    let datetime = p.start_time.split(" ");
                    if((datetime[0] === day) && (datetime[1] === hour+":00")){
                        td.style.backgroundColor = "#" + group.color;
                        td.dataset.scheduleId = p.id;
                        td.dataset.assigned = "true";
                    }
                })
            }
            td.onclick = cellListener;
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

    days.forEach(function(day){
        var dayTable = createTable(schedule, groups, day);
        moment.locale("fr");
        let div = document.createElement("div");
        div.innerHTML = moment(day).format("LL");
        div.className = "dayDiv";
        div.style.fontSize = "25px";
        container.appendChild(div);
        container.appendChild(dayTable);
    });
}

function getAllGroups(){
    var url = window.Laravel.basePath + "/api/groups?token=root&include=schedules";
    return ajaxRequest("get", url, "", false);
    // console.log(res);
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

function editSchedule(currentSchedule){
    var _diff = function(hor1, hor2){
        let r = parseInt(hor1) - parseInt(hor2);
        if(r < 0){
            r = Math.abs(r);
        }
        return r;
    };

    var container = document.getElementsByClassName("schedule-edit");
    var diffElement = document.createElement("div");
    let sel = currentSchedule[0];
    var diff = _diff(sel, currentSchedule[currentSchedule.indexOf(sel)+1]);
    var typingValidation = function(){
        // Button is clickable only if we have a value
        if(document.getElementById("sch").value){
            document.getElementById("sch-validate").disabled = false;
            document.getElementById("sch-validate").style.opacity = "1";
        }else{
            document.getElementById("sch-validate").disabled = true;
            document.getElementById("sch-validate").style.opacity = "0.8";
        }
    };
    var changeSchedule = function(){
        let newDiff = document.getElementById("sch").value;
        if(newDiff != diff.toString()){
            console.log("we chaaange");
        }
        console.log(newDiff);
        let alertElement = document.createElement("div");
        if(!newDiff){
            alertElement.innerHTML = "No Value.."
        }

        container[0].appendChild(alertElement);
    };
    diffElement.innerHTML = "Tranche actuelle : " + diff.toString() + " H.";
    diffElement.style.fontSize = "20px";
    container[0].appendChild(diffElement);

    var changeElement = document.createElement("input");
    changeElement.type = "time";
    changeElement.setAttribute("id", "sch");
    changeElement.onchange = typingValidation;
    container[0].appendChild(changeElement);

    var validateElement = document.createElement("input");
    validateElement.type = "submit";
    validateElement.setAttribute("id", "sch-validate");
    validateElement.disabled = true;
    validateElement.style.opacity = "0.7";
    validateElement.onclick = changeSchedule;
    container[0].appendChild(validateElement);
    // currentSchedule.forEach(function(schedule){
    //     // console.log(currentSchedule.indexOf(schedule));
    //     // let i = document.createElement("input");
    //     // i.setAttribute()
    // });
}

/*
* Contains all the day that have been changed in te grid.
* We only read and update the days in this array
* */
var dayChanged = [];
var days = getAllDays();
var schedule = ["08:00", "10:00",
                "12:00", "14:00",
                "16:00", "18:00",
                "20:00", "22:00",
                "00:00", "02:00",
                "04:00", "06:00"];

var groups = getAllGroups();
// console.log(groups);
createGrid(schedule, days, groups);
editSchedule(schedule);

