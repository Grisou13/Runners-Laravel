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

var groupUsers = [];

function display(entries, container){

    function displayUsersPerGroup(container, groupID){
        if(typeof groupUsers[groupID] === "undefined"){ //if not set yet
            window.api.get("/groups/"+groupID, {"include":"users"})
                .then(function(groupR){
                    // window.api.get("/groups/"+groupID+"/users", {})
                    //     .then(function(r){
                    let r = groupR.users
                            let div = document.createElement("div");
                            groupUsers[groupID] = "<h3>Groupe " + groupR["data"].name +"</h3>"; //todo get group letter
                            //groupUsers[groupID] = r["data"];
                            if(r.length > 0 ){
                                r.forEach(function(user){
                                    let p = "<p>";
                                    p += user.firstname;
                                    p += " ";
                                    p += user.lastname;
                                    p += "</p>";
                                    groupUsers[groupID] += p;
                                });
                            }else{
                                groupUsers[groupID] += "Aucun utilsateur dans le groupe.";
                            }
                            div.innerHTML = groupUsers[groupID];
                            container.appendChild(div); //append when done.
                            return groupUsers[groupID];
                        // });
                });

        }else{
            return groupUsers[groupID];
        }
    }


    for(let day in entries){

        let hourListed = [];
        let currentContainer = document.createElement("div");
        let sliderContainer = document.createElement("div");
        currentContainer.className = "kiela";
        sliderContainer.className = "slider";
        container.parentNode.appendChild(sliderContainer);
        container.parentNode.appendChild(currentContainer);

        for(let shift in entries[day]){
            let entryDiv = document.createElement("div");
            let entryDay = document.createElement("h2");
            let d = new Date(entries[day][shift][0]["start_time"].split(" ")[0]);
            entryDay.innerHTML = d.toDateString();
            let entryShift = document.createElement("h3");
            entryShift.innerHTML = "De ";
            entryShift.innerHTML += entries[day][shift][0]["start_time"].split(" ")[1];
            entryShift.innerHTML += " à ";
            entryShift.innerHTML += entries[day][shift][0]["end_time"].split(" ")[1];

            hourListed.push(entries[day][shift][0]["start_time"].split(" ")[1]);
            for(var obj in entries[day][shift]){
                let groupID = entries[day][shift][obj]["group_id"];
                displayUsersPerGroup(entryDiv, groupID);
            }

            entryDay.appendChild(entryShift);
            entryDiv.appendChild(entryDay);
            currentContainer.appendChild(entryDiv);
        }

        // create slider element
        let slider = tns({
            container: currentContainer,
            controls: false
        });

        // add next button control
        let ctrlNextBtn = document.createElement("button");
        let ctrlPrevBtn = document.createElement("button");
        // index starts at 0, but we want the next one...
        let i = 0;
        ctrlPrevBtn.innerHTML = hourListed[(hourListed.length)-1];
        ctrlNextBtn.innerHTML = hourListed[hourListed.length > 1 ? i + 1 : i];
        container.parentNode.appendChild(ctrlPrevBtn);
        container.parentNode.appendChild(ctrlNextBtn);
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

        }

    }
}

function init(schedules) {
  if(!schedules.length)
  {
    document.getElementById("kiela").innerHTML = ("<p>Il n'y a pas d'horaire crée :(</p>")
    return false;
  }
    schedules.sort(function(a,b){
        return new Date(a["start_time"]).getTime() - new Date(b["start_time"]).getTime();
    });
    let sortedByHour = _.groupBy(schedules, function(d){
        return new Date(d["start_time"]);
    });
    let sortedByHourAndByDay = _.groupBy(sortedByHour, function(d){
        return new Date(d[0]["start_time"].split(" ")[0])
    });

    var finalSort = []; finalSort[0] = []; // no ragrets
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
    display(finalSort, document.getElementById("kiela"));
}
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
