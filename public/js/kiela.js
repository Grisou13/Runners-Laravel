let scheduleFormat, schedules;
// attach the .equals method to Array's prototype to call it on any array
Array.prototype.equals = function (array) {
    // if the other array is a falsy value, return
    if (!array)
        return false;

    // compare lengths - can save a lot of time
    if (this.length != array.length)
        return false;

    for (var i = 0, l=this.length; i < l; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].equals(array[i]))
                return false;
        }
        else if (this[i] != array[i]) {
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;
        }
    }
    return true;
};
// Hide method from for-in loops
Object.defineProperty(Array.prototype, "equals", {enumerable: false});

/*
 Display the entries in the slider
 */
function display(entries, container){
    /*
     Each group users is stores in this array in a Node Object.
     */
    var groupUsers = [];

    function getDay(entries, now){
        function firstInArray(arr) {
            for(let el  in arr){
                if(arr.hasOwnProperty(el)){
                    return arr[el]
                }
            }
        }
        for (let day in entries){
            let entryDate = moment(firstInArray(entries[day])[0]["start_time"].split(" ")[0])
            if(entryDate.diff(now, "days") < 0){
                continue;
            }
            if(entries.hasOwnProperty(day)){
                console.log(entries[day]);
                return entries[day];
            }
        }
    }

    function displayUsersPerGroup(groupID, rootContainer){
        return window.api.get("/groups/"+groupID, {params:{"include":"users"}})
            .then(function(res){
                let currentContainer = document.createElement("div");
                currentContainer.className += "container";
                currentContainer.innerHTML = "<h3>Groupe " + res["data"].name +"</h3>";
                let row = document.createElement("row");
                row.className += "row";
                //TODO what if no users
                let users = res["data"].users;
                users.forEach(function(user){
                    let userDiv = document.createElement("div");
                    userDiv.innerHTML += user.firstname + " ";
                    userDiv.innerHTML += user.lastname + "<br>";
                    userDiv.innerHTML += "<img src='" + user.profile_image + "'>";
                    userDiv.innerHTML += "<br>";
                    userDiv.className += "col-md-2";

                    row.appendChild(userDiv);
                });
                currentContainer.appendChild(row);
                rootContainer.appendChild(currentContainer); // display the data when we have it

                // and now and ONLY NOW we can set groupUsers[groupID]
                groupUsers[groupID] = currentContainer;
            });
    }

    let now = moment("2017-07-19");
    let  hourListed = [];

    // we only keep one day, which is the closer day to now in the future.
    // I.e. if we are the 10 of July but the schedule only starts the 17, it'll display the 17
    // use moment with a different date to try it out : let now = moment("2017-07-19");
    let day = getDay(entries, now);

    for(let shift in day){ // iterate through each entries of the day (which is already sorted)
        var entryDiv = document.createElement("div");
        let entryDay = document.createElement("h2");
        let d = new Date(day[shift][0]["start_time"].split(" ")[0]);
        entryDay.innerHTML = d.toDateString();
        let entryShift = document.createElement("h3");
        entryShift.innerHTML = "De ";
        entryShift.innerHTML += day[shift][0]["start_time"].split(" ")[1];
        entryShift.innerHTML += " à ";
        entryShift.innerHTML += day[shift][0]["end_time"].split(" ")[1];
        hourListed.push(day[shift][0]["start_time"].split(" ")[1]);
        console.log("=======")
        for(var obj in day[shift]){
            let groupID = day[shift][obj]["group_id"];
            console.log(groupID);
            if (typeof groupUsers[groupID] == "undefined"){ // if we didn't query this group yet...

                displayUsersPerGroup(groupID, entryDiv);
            }else{
                console.log(groupUsers[groupID]);
            }

            // entryDay.appendChild(entryShift);
            // entryDiv.appendChild(entryDay);
            // container.appendChild(entryDiv);
        }

        // creates the button 'previous' and 'next' buttons
        // assign the hour displayed on it depending of the selected shift
        var ctrlNextBtn = document.createElement("button");
        var ctrlPrevBtn = document.createElement("button");
        let i = 0;
        ctrlPrevBtn.innerHTML = "Précédent";
        ctrlNextBtn.innerHTML = "Suivant";
        ctrlNextBtn.onclick = function(){
            i += 1;
            if(i == hourListed.length){ // if we reach the end of the listed hours
                i = 0;
                slider.goTo("first"); // we go back to the first element. ever.
            }else{
                slider.goTo("next");
            }
            //update buttons content (prev and next hour)
            ctrlPrevBtn.innerHTML = hourListed[i == 0 ? hourListed.length -1 : i - 1];
            ctrlNextBtn.innerHTML = hourListed[i == hourListed.length -1 ? 0 : i + 1];
            //let info = slider.getInfo();
        };
        ctrlPrevBtn.onclick = function(){
            i -= 1;
            if(i < 0){ // we can't go before the index right ?
                i = hourListed.length - 1;
                slider.goTo("last");
            }else{
                slider.goTo("prev");
            }
            let info = slider.getInfo();
            let indexPrev = info.indexCached;
            let indexCurrent = info.index;
            // update style based on index
            info.slideItems[indexPrev].classList.remove('active');
            info.slideItems[indexCurrent].classList.add('active');

            ctrlPrevBtn.innerHTML = hourListed[i == 0 ? hourListed.length -1 : i - 1];
            ctrlNextBtn.innerHTML = hourListed[i == hourListed.length -1 ? 0 : i + 1];

        };
        
        entryDay.appendChild(entryShift);
        entryDiv.appendChild(entryDay);
        entryDiv.appendChild(ctrlPrevBtn);
        entryDiv.appendChild(ctrlNextBtn);
        container.appendChild(entryDiv);
    }
    let slider = tns({
        container: container,
        controls: false
    });
}

/*
 Sort the given schedules and call the method to display it
 Each new group set (GROUP_X + GROUP_Y) is in a new sub_array
 I.e. From 8AM to 10AM we have the GROUP 1 and GROUP 2
 Then from 10AM to 1PM we have GROUP 1 (only) ===> creates 2 sub_array for each group
 */
function init(schedules){
    if(!schedules.length){
        document.getElementById("kiela").innerHTML = ("<p>Aucun horaire disponible.(</p>")
        return false;
    }

    // sort by time.
    // I.e. [['start_time': 2017-01-01 10:00:00, ...], ['start_time': 2017-01-02 10:00:00, ...], ['start_time': 2017-01-03 10:00:00, ...], ...]
    schedules.sort(function(a,b){
    return new Date(a["start_time"]).getTime() - new Date(b["start_time"]).getTime();
    });

    // group by day
    let sortedByHour = _.groupBy(schedules, function(d){
        return new Date(d["start_time"]);
    });

    // and group by hour
    let sortedByHourAndByDay = _.groupBy(sortedByHour, function(d){
    return new Date(d[0]["start_time"].split(" ")[0])
    });
    /*
     Now you have something like
    [Fri Jan 11 2017 02:00:00 GMT+0200: [
        [ [0:entry_data], [1:entry_data], [2:entry_data], [3:entry_data], ... ], <= GROUP SET
        [ [0:entry_data], [1:entry_data], [2:entry_data], [3:entry_data], ... ], <= GROUP SET
        ...
    ]],
    [Stat Jan 22 2017 03:00:00 GMT+0200 : [...]],
    ...
    */

    // only keep the entries if we have a new group set
    // also rearrange the 'end_time' to refer to the last schedule entry
    var finalSort = []; finalSort[0] = [];
    let index = 0;
    let bigO = 0;
    for(let property in sortedByHourAndByDay){ // foreach day
        if(sortedByHourAndByDay.hasOwnProperty(property)){
            let currentGroup = [];
            let lastGroup = [];
            finalSort[bigO] = [];
            let last_group_ref = sortedByHourAndByDay[property][0]; // first element
            let ref = false;
            for(var times in sortedByHourAndByDay[property]){
                for(var grp in sortedByHourAndByDay[property][times]){
                    currentGroup.push(sortedByHourAndByDay[property][times][grp]["group_id"]);
                }
                // "Talk is cheap. Show me the code." - Linus Torvalds
                if(!currentGroup.sort().equals(lastGroup.sort())){ // do we have a different group set
                    if(ref){
                        for(grp in ref){
                            ref[grp]['end_time'] = last_group_ref[0]['end_time']
                        }
                    }
                    // we only keep the first element of the shift (when the shift begins)
                    finalSort[bigO][index] = sortedByHourAndByDay[property][times];
                    ref = finalSort[bigO][index];
                }
                index += 1;
                lastGroup = currentGroup;
                currentGroup = []; //reset current
                last_group_ref = sortedByHourAndByDay[property][times];
            }
            for(let grp in ref){
                ref[grp]["end_time"] = last_group_ref[0]["end_time"];
            }
        }
        bigO += 1;
    }

    /*
     So finally we have something like
     [
        [
            [0:entry_data, 1:entry_data, 2:entry_data]
        ],
        [
            [0:entry_data, 1:entry_data, 2:entry_data]
        ],
        [
            [0:entry_data,1:entry_data, 2:entry_data]
        ]
    ]
     */
    display(finalSort, document.getElementById("kiela"));
}

/*
 Get all schedules from the API
 */
function getAllSchedules(callback){
    window.api.get("/schedules",{})
        .then(function(r){
            schedules = r["data"];
            callback(schedules);
        })
        .catch(function(error){
            console.log(error);
        });
}

/*
 Get the schedules (from api if exists)
 Then call the init method that parse the schedules as we want to
 */
function getScheduleFormat(callback){
    // get config from api
    window.api.get("/settings", {})
        .then(function(r){
            if(!r["data"] || r["data"].length <= 0){
                // if api can't get an answer, take the standard format
                scheduleFormat = [ "08:00","08:30", "09:00","09:30",
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
            }else{
                scheduleFormat = r["data"];
            }
            callback(init);
        })
        .catch(function(error){
            switch(error.response.status){
                case 401:
                    window.location.replace("/login")
            }
        });
}

getScheduleFormat(getAllSchedules);
