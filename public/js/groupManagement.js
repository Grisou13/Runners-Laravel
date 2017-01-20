/**
 * Created by Eric.BOUSBAA on 12.01.2017.
 */
 //credits to http://stackoverflow.com/questions/2735067/how-to-convert-a-dom-node-list-to-an-array-in-javascript
 function toArray(obj) {
    var array = [];
    // iterate backwards ensuring that length is an UInt32
    for (var i = obj.length >>> 0; i--;) {
        array[i] = obj[i];
    }
    return array;
 }

function addUserToGroup(userID, groupID) {
    //TODO get users token
    var url = "/Runners-Laravel/public/api/groups/" + groupID + "?token=root";
    var success = function(data) {
        console.log(data);
    };
    ajaxRequest(url,{user:userID}, success, "patch");

}

function removeUserFromGroup(userID, groupID) {
    if(!confirm("Etes-vous sûr d'enlever l'utilisateur du groupe ?")){
        location.reload();
        return false;
    }
    var url = "/Runners-Laravel/public/api/groups/" + groupID + "?token=root&user="+userID;
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

var drake = dragula(containers, {
    moves: function(el, source, handle, sibling){
        return el.classList.contains("panel-body");
    },
    accepts: function(el, target, source, sibling){

        if(!sibling){
            /*
            var popDiv = document.createElement("div");
            popDiv.id = "pannel-content";
            popDiv.class = "panel-body";
            target.appendChild(popDiv);
            */

            return false;
        }

        return sibling.classList.contains("panel-body");
    }
});
// if(sibling.classList.contains("panel-body")){
//     console.log(target.id.replace("container-", ""));
// }
drake.on("drop", function(el, target, source, sibling){
    userID = el.id;
    destGroupdID = target.id.replace("container-", "");
    sourceGroupID = source.id.replace("container-", "");
    if(destGroupdID == "null"){
        removeUserFromGroup(userID, sourceGroupID);
    }else{
        addUserToGroup(userID, destGroupdID);
    }

    //removeUserFromGroup(userID, sourceGroupID);
});
