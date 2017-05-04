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
        console.log(hourListed);
        let slider = tns({
            container: currentContainer,
            controls: false
        });

        // add button control
        let ctrlNextBtn = document.createElement("button");
        let i = 1;
        // index starts at 0, but we want the next one...
        ctrlNextBtn.innerHTML = hourListed[i];
        container.parentNode.appendChild(ctrlNextBtn);
        ctrlNextBtn.onclick = function(){
            let info = slider.getInfo();
            let indexPrev = info.indexCached;
            let indexCurrent = info.index;
            // restart at the beginning when we reach the end of the day
            if(i+1 == hourListed.length){ i= -1 }
            // update style based on index
            info.slideItems[indexPrev].classList.remove('active');
            info.slideItems[indexCurrent].classList.add('active');
            i += 1;
            ctrlNextBtn.innerHTML = hourListed[i];
            slider.goTo("next");
        }
    }
}
function _display(ntry, ctnr){
    for(let key in ntry){
        if(!ntry.hasOwnProperty(key)){continue};
        // create table
        let tbl = document.createElement("table");
        tbl.style.border = "1px solid";
        tbl.style.width = "60%";
        tbl.style.margin = "10px";
        let rw = tbl.insertRow(0);
        rw.insertCell(0).appendChild(document.createTextNode("G"));

        rw.insertCell(0).appendChild(document.createTextNode("H"));
        rw.setAttribute("border", "1");

        let crrnt = ntry[key];

        for(let vl in crrnt){
            console.log(crrnt[vl]);
            let tr = tbl.insertRow();
            tr.insertCell(0).appendChild(document.createTextNode(crrnt[vl]["group_id"]));
            tr.insertCell(0).appendChild(document.createTextNode(crrnt[vl]["start_time"].split(" ")[1]));
            // tr.insertCell(crrnt[vl]["group_id"])
        }
        ctnr.appendChild(tbl);

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


