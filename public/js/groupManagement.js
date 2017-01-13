/**
 * Created by Eric.BOUSBAA on 12.01.2017.
 */


var containers = document.querySelectorAll(".panel");
//var containers = document.getElementsByClassName("panel");

dragula("panel", {
    isContainer: function (el) {
        console.log(el.contains("td"));
    }
});

//dragula(containers, {
    /*disContainer: function (el) {
        console.log(el.classList.contains('panel-body'));
        return el.classList.contains('panel-body');
    },
    moves: function(el, source, handle, sibling) {
        return true;
    }
    */
    // moves: function (el, source, handle, sibling){
    //     // if(handle.tagName == "TD" ){
    //     //     return true;
    //     // }else{
    //     //     return false;
    //     // }
    // }
//})

