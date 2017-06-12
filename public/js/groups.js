var drake = null;

/*
 credits to
 http://stackoverflow.com/questions/2735067/how-to-convert-a-dom-node-list-to-an-array-in-javascript
 */
function toArray(obj) {
    var array = [];
    // iterate backwards ensuring that length is an UInt32
    for (var i = obj.length >>> 0; i--;) {
        array[i] = obj[i];
    }
    return array;
 }

 /*
  Delete the given group (by id).
  Hide the div, and delete on group on the web API
  */
function deleteGroup(groupID){
    // delete the group in the api
    let success = function(deleted){};
    window.api.delete("/groups/"+groupID,{})
        .then(function(res){
            console.log("Deleted");
            console.log(res);
        })
        .catch(function (error) {
            console.log(error);
         });

    // delete (hide for the moment) the div
    let groupContainer = document.getElementById("container-"+groupID);
    groupContainer.style.display = "none";
}
/*
 Creates a new group and display a new div
 */
function getNewGroup(){
    var base_path = window.Laravel.basePath;
    var url = base_path + "/api/groups?token=root";
    var success = function(created) {
        data = created.data;
        console.log(data);
        // create a new container
        var newContainer = document.createElement("div");
        newContainer.classList.add("panel");
        newContainer.classList.add("panel-default");
        newContainer.classList.add("col-md-2");
        newContainer.classList.add("enabledbutton");
        newContainer.id = "container-" + data["id"];
        newContainer.style = "background-color : #" + data["color"] + ";";
        var heading = document.createElement("div");
        heading.classList.add("panel-heading");
        heading.appendChild(document.createTextNode(data["name"]));
        heading.style = "background-color : #" + data["color"] + ";";
        // heading.style += "color : white;";
        newContainer.appendChild(heading);
        // add tge delete functionality (as the group is currently empty)
        let img = document.createElement("img");
        img.className = "delIcon";
        img.src = "images/icons/trash.png";
        img.onclick = function(){
            deleteGroup(data["id"]);
        };
        newContainer.appendChild(img);
        document.querySelector("#group-container").appendChild(newContainer);
        // add the container to the "dropable" containers
        drake.containers.push(newContainer);
    };

    // check if a group name has been given in input
    let name = document.getElementById("group-name").value;
    let data = {};
    if(name.length){
        data["name"] = name;
    }
    // and post it on the web api
    window.api.post("/groups",data)
        .then(function(res){
            console.log("group created");
            document.getElementById("group-name").value = "";
            success(res);
        })  .catch(function (error) {
        console.log(error);
    });
}
/*
 Drag and Drop event
 */
function addUserToGroup(userID, groupID) {
    var base_path = window.Laravel.basePath;
    //TODO get users token
    var url = base_path + "/api/groups/" + groupID + "?token=root";
    var success = function(data) {
        // debugger;
        console.log(data);
    };
    window.api.patch("/groups/"+groupID,{user:userID})
        .then(function(res){
            console.log(res);
        })  .catch(function (error) {
        console.log(error);
    });
    //ajaxRequest(url,{user:userID}, success, "patch");
}

/*
 Delete the user form his group
 */
function removeUserFromGroup(userID, groupID) {
    if(!confirm("Etes-vous sûr de vouloir enlever l'utilisateur du groupe ?")){
        location.reload();
        return false;
    }
    var base_path = window.Laravel.basePath;
    var url = base_path + "/api/groups/" + groupID + "?token=root&user="+userID;
    var success = function(data) {
        console.log(data);
    };

    ajaxRequest(url,{user:userID}, success, "delete");
}

function ajaxRequest(url, data, callback, method) {
    return $.ajax({
        url: url,
        type: method,
        contentType: "application/json",
        dataType:'application/x-www-form-urlencoded; charset=UTF-8',
        headers:{
            "x-access-token":window.Laravel.token
        },
        data: data,
        success: callback
    });
}


var containers = toArray(document.querySelectorAll("[id^='container-']"));

drake = dragula(containers, {
    moves: function(el, source, handle, sibling){
        return el.classList.contains("panel-body");

    },
    accepts: function(el, target, source, sibling){
        //can't move to empty containe (no header)
        if(!sibling){
            return false;
        }

        if(sibling.classList.contains("panel-body")){
            return true;
        }else if(target.classList.contains("panel")){
            // if you want to move an element to an empty group list
            target.appendChild(el);

        }else{
            return false;
        }
    }
});

drake.on("drop", function(el, target, source, sibling){
    userID = el.id;
    destGroupdID = target.id.replace("container-", "");
    sourceGroupID = source.id.replace("container-", "");
    // update e user in the model
    if(destGroupdID == "null"){
        removeUserFromGroup(userID, sourceGroupID);
    }else{
        addUserToGroup(userID, destGroupdID);
    }
});
