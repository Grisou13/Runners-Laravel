let scheduleFormat, schedules;

function display(entries, container){
    for (let day in entries){
        let hourListed = [];
        let currentContainer = document.createElement("div");
        let sliderContainer = document.createElement("div");
        currentContainer.className = "kiela";
        sliderContainer.className = "slider";
        container.parentNode.appendChild(sliderContainer);
        container.parentNode.appendChild(currentContainer);

        for (let hour in entries[day]){
            let entryDiv = document.createElement("div");
            let entryHeader = document.createElement("h3");
            entryHeader.innerHTML = entries[day][hour][0]["start_time"].split(" ")[0];
            entryHeader.innerHTML += " à ";
            entryHeader.innerHTML += entries[day][hour][0]["start_time"].split(" ")[1];
            // keep a list of all the different hours for this day
            hourListed.push(entries[day][hour][0]["start_time"].split(" ")[1]);
            for (let current in entries[day][hour]){
                entryDiv.innerHTML += "GROUP N° " + entries[day][hour][current]["group_id"] + " ";
            }
            entryDiv.appendChild(entryHeader);
            currentContainer.appendChild(entryDiv);
        }
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
        console.log(hourListed)
        ctrlNextBtn.onclick = function(){
            i += 1;
            if(i == hourListed.length){ i = 0 }
            console.log(i);
            console.log(hourListed[i]);
            let info = slider.getInfo();
            let indexPrev = info.indexCached;
            let indexCurrent = info.index;

            // update style based on index
            ctrlPrevBtn.innerHTML = hourListed[i == 0 ? hourListed.length -1 : i - 1 ];
            ctrlNextBtn.innerHTML = hourListed[i == hourListed.length -1 ? 0 : i + 1];
            // ctrlPrevBtn.innerHTML = hourListed[];
            // ctrlNextBtn.innerHTML = hourListed[i];
            slider.goTo("next");
        };


        ctrlPrevBtn.onclick = function(){
            i -= 1;
            if(i < 0){ i = hourListed.length -1 }
            console.log(i);
            console.log(hourListed[i]);
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

function init() {
    // todo magic here
    schedules.sort(function(a,b){
        return new Date(a["start_time"]).getTime() - new Date(b["start_time"]).getTime();
    });
    let sortedByHour = _.groupBy(schedules, function(d){
        return new Date(d["start_time"]);
    });
    let sortedByHourAndByDay = _.groupBy(sortedByHour, function(d){
        return new Date(d[0]["start_time"].split(" ")[0])
    });
    
    for(let property in sortedByHourAndByDay){
        if(sortedByHourAndByDay.hasOwnProperty(property)){
            console.log(sortedByHourAndByDay[property])
        }
    }
    throw new Error("Work in progress, please step aside.");
    display(sortedByHourAndByDay, document.getElementById("kiela"));
}
function getAllSchedules(callback){
    window.api.get("/schedules",{})
        .then(function(r){
            schedules = r["data"];
            callback();
        })
        .catch(function(error){
            // todo manage if user not logged in...
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


