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

            window.api.get("/groups/"+groupID+"/users", {})
                .then(function(r){
                    let div = document.createElement("div");
                    groupUsers[groupID] = "<h3>Group n° " + groupID +"</h3>"; //todo get group letter
                    //groupUsers[groupID] = r["data"];
                    if(r["data"].length > 0 ){

                        r["data"].forEach(function(user){
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
            let entryHeader = document.createElement("h3");
            entryHeader.innerHTML = "De ";
            entryHeader.innerHTML += entries[day][shift][0]["start_time"].split(" ")[1];
            entryHeader.innerHTML += " à ";
            hourListed.push(entries[day][shift][0]["start_time"].split(" ")[1]); //todo wtf here what's wrong with u

            for(var obj in entries[day][shift]){
                let groupID = entries[day][shift][obj]["group_id"];
                displayUsersPerGroup(entryDiv, groupID);
                // console.log(userList);
            }
            //entryHeader.innerHTML += entries[day][shift][entries[day][shift].length -1]["end_time"].split(" ")[1];
            /////entryHeader.innerHTML += entries[day][shift][obj]["end_time"].split(" ")[1];
            entryDiv.appendChild(entryHeader);
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
        ctrlNextBtn.innerHTML = hourListed[i+1];
        container.parentNode.appendChild(ctrlPrevBtn);
        container.parentNode.appendChild(ctrlNextBtn);

        ctrlNextBtn.onclick = function(){
            i += 1;
            if(i == hourListed.length){ i = 0 }
            // console.log(i);
            // console.log(hourListed[i]);
            let info = slider.getInfo();
            let indexPrev = info.indexCached;
            let indexCurrent = info.index;
            // update style based on index
            if(i == hourListed.length - 1){ // if we reach the end of the listed hours...

                slider.goTo("first");
                console.log("reach the end")

                slider.goTo("next");
            }

            ctrlPrevBtn.innerHTML = hourListed[i == 0 ? hourListed.length -1 : i - 1];
            ctrlNextBtn.innerHTML = hourListed[i];


            // ctrlPrevBtn.innerHTML = hourListed[];
            // ctrlNextBtn.innerHTML = hourListed[i];

        };
        ctrlPrevBtn.onclick = function(){
            i -= 1;
            if(i < 0){ i = hourListed.length -1 }
            // console.log(i);
            // console.log(hourListed[i]);
            let info = slider.getInfo();
            let indexPrev = info.indexCached;
            let indexCurrent = info.index;

            // update style based on index
            info.slideItems[indexPrev].classList.remove('active');
            info.slideItems[indexCurrent].classList.add('active');

            ctrlPrevBtn.innerHTML = hourListed[i == 0 ? hourListed.length -1 : i - 1];
            ctrlNextBtn.innerHTML = hourListed[i == hourListed.length -1 ? 0 : i + 1];
            slider.goTo("prev");
        }

    }
}

function init(schedules) {
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
            for(var times in sortedByHourAndByDay[property]){
                for(let grp in sortedByHourAndByDay[property][times]){
                    currentGroup.push(sortedByHourAndByDay[property][times][grp]["group_id"]);
                }
                // "Talk is cheap. Show me the code." - Linus Torvalds
                if(!currentGroup.sort().equals(lastGroup.sort())){ // do we have a different group set
                    // we only keep the first element of the shift (when the shift begins)
                    finalSort[bigO][index] = sortedByHourAndByDay[property][times];
                }
                index += 1;
                lastGroup = currentGroup;
                currentGroup = []; //reset current
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


