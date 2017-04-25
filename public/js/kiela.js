function getScheduleFormat(){
    // get config from api
    window.api.get("/settings",{})
        .then(function(r){
            console.log("settings")
            console.log(r);
        })
        .catch(function(error){
            console.log(error);
        })

    console.log("after")
    console.log(r)
}
getScheduleFormat();
