/**
 * Created by Eric.BOUSBAA on 17.02.2017.
 */

// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/round
/*
(function() {
    /**
     * Decimal adjustment of a number.
     *
     * @param {String}  type  The type of adjustment.
     * @param {Number}  value The number.
     * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
     * @returns {Number} The adjusted value.

    function decimalAdjust(type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // If the value is negative...
        if (value < 0) {
            return -decimalAdjust(type, -value, exp);
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function(value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function(value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function(value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
})();
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
/*
function _updateSchedule(newScheduleInterval){
    newScheduleInterval = parseFloat(newScheduleInterval);
    // let newSchedule = generateScheduleFromInterval(newScheduleInterval);
    // schedule = newScheduleInterval;
    // console.log("DONE");

    let url = window.Laravel.basePath + "/api/settings/schedule_interval?token=root&value="+newScheduleInterval;

    ajaxRequest("patch", url, null, console.log);
    // location.reload();
    // console.log(newSchedule);
    // change settings
}
*/

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
        var cell = this;
        let assignDataId = function(scheduleCreated){

            cell.dataset.scheduleId = scheduleCreated.id;
        };
        console.log(data);

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
    th.style.width = "25%";
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
        td.innerHTML = "G°" + group.id;
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
    return ajaxRequest("get", url, "", null);
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
/*
function editSchedule(currentSchedule, hourInterval, minutesInterval){
    var _diff = function(hor1, hor2){
        let r = parseInt(hor1) - parseInt(hor2);
        if(r < 0){
            r = Math.abs(r);
        }
        return r;
    };

    var container = document.getElementsByClassName("schedule-edit")[0];
    var diffElement = document.createElement("div");
    let sel = currentSchedule[0];
    var diff = _diff(sel, currentSchedule[currentSchedule.indexOf(sel)+1]);
    var typingValidation = function(){
        // Get our two dropdown list values
        let hoursInput = document.getElementById("sch-hours").value;
        let minutesInput = document.getElementById("sch-minutes").value;

        // Submit button is clickable only if we have a jump bigger than 0
        if(hoursInput != "00" || minutesInput != "00"){
            document.getElementById("sch-validate").disabled = false;
            document.getElementById("sch-validate").style.opacity = "1";
        }else{
            document.getElementById("sch-validate").disabled = true;
            document.getElementById("sch-validate").style.opacity = "0.8";
        }
    };

    var changeSchedule = function(){
        let hoursDiff = document.getElementById("sch-hours").value;
        let minutesDiff = document.getElementById("sch-minutes").value;
        //TODO check if val is different that the one actually used.

        _updateSchedule(hoursDiff + "." + minutesDiff);

        let alertElement = document.createElement("div");

    };

    diffElement.innerHTML = "Tranche actuelle : " + diff.toString() + " H.";
    diffElement.style.fontSize = "20px";
    container.appendChild(diffElement);
    //container[0].appendChild(changeElement);

    // hour dropdown
    // hour jump given in parameter array
    var selectHour = document.createElement("select");
    hourInterval.forEach(function(val){
        selectHour.options.add(new Option(val,val))
    });
    selectHour.setAttribute("id", "sch-hours")
    selectHour.onchange = typingValidation;
    // minutes dropdown
    // minutes jump given in parameter array
    var selMinutes = document.createElement("select");
    minutesInterval.forEach(function(val){
        selMinutes.options.add(new Option(val,val))
    });
    selMinutes.setAttribute("id", "sch-minutes");
    selMinutes.onchange = typingValidation;

    // append the options to container
    container.appendChild(selectHour);
    container.appendChild(selMinutes);

    // submit button
    var validateElement = document.createElement("input");
    validateElement.type = "submit";
    validateElement.setAttribute("id", "sch-validate");
    validateElement.disabled = true;
    validateElement.style.opacity = "0.7";
    validateElement.onclick = changeSchedule;
    // append the submit button to container
    container.appendChild(validateElement);
}
*/

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

var groups = getAllGroups();

createGrid(schedule, days, groups);

//TODO https://laravel.com/docs/5.4/dusk#waiting-for-elements
