/**
 * Created by Eric.BOUSBAA on 12.01.2017.
 */
var drake = null;
 //credits to http://stackoverflow.com/questions/2735067/how-to-convert-a-dom-node-list-to-an-array-in-javascript
 function toArray(obj) {
    var array = [];
    // iterate backwards ensuring that length is an UInt32
    for (var i = obj.length >>> 0; i--;) {
        array[i] = obj[i];
    }
    return array;
 }

function getNewGroup(){
    var base_path = window.Laravel.basePath;
    var url = base_path + "/api/groups?token=root";
    console.log(url);
    var success = function(data) {
        // create a new container
        var newContainer = document.createElement("div");
        newContainer.classList.add("panel");
        newContainer.classList.add("panel-default")
        newContainer.classList.add("col-md-2")
        newContainer.classList.add("enabledbutton")
        newContainer.id = "container-"+data;
        var heading = document.createElement("div");
        heading.classList.add("panel-heading");
        heading.appendChild(document.createTextNode("le nomm du groupe"));
        newContainer.appendChild(heading);
        document.querySelector("#group-container").appendChild(newContainer);
        console.log(newContainer);
        console.log(drake);
        drake.containers.push(newContainer);
    };

    ajaxRequest(url, {}, success, "post")
}

function addUserToGroup(userID, groupID) {
    var base_path = window.Laravel.basePath;
    //TODO get users token
    var url = base_path + "/api/groups/" + groupID + "?token=root";
    var success = function(data) {
        console.log(data);
    };

    ajaxRequest(url,{user:userID}, success, "patch");
}

function removeUserFromGroup(userID, groupID) {
    if(!confirm("Etes-vous sûr d'enlever l'utilisateur du groupe ?")){
        //TODO let lock open when reload page
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
    return jQuery.ajax({
        url: url,
        type: method,
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
        console.log(target)
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
    if(destGroupdID == "null"){
        removeUserFromGroup(userID, sourceGroupID);
    }else{
        addUserToGroup(userID, destGroupdID);
    }

});
