// author : Joël.DE-SOUSA
// enable some CRUD components (not read only)
function enable() {

    if($("#padlock").hasClass("closed")){

        $("#padlock").attr('class', 'btn btn-success pull-left opened');
        $("#padlock").html("Ouvert ");
        $("#padlock").append("<span class='glyphicon glyphicon-pencil'></span>");

        $("#create-car").attr('style', 'display : block');
        var enable = function () {
            if($(this).attr("id") == "padlock")
                return false;
            $(this).removeAttr('disabled');
            $(this).attr('enabled', 'enabled');
            $(this).removeClass("disabled");

        };
        $("#create-user").each(enable);
        $('input:disabled, select:disabled').each(enable);

        $('button:disabled, button.disabled, select:disabled').each(enable);
        $('a:disabled').each(enable);
        $('textarea:disabled, select:disabled').each(enable);

        /////// ERIC DISABLE AND ENABLE COMPONENTS
        $(".disabledbutton").attr("class", "panel panel-default col-md-2 enabledbutton");

        $(".disablesecondbutton").attr("class", "btn btn-default enabledsecondbutton");
        /////// END OF ERIC
    }else{

      $("#padlock").attr('class', 'btn btn-success pull-right closed');
        $("#padlock").html("Vérouillé ");
        $("#padlock").append("<span class='glyphicon glyphicon-pushpin'></span>");
        $("#create-car").attr('style', 'display : none');
        var disable = function(){
            if($(this).attr("id") == "padlock")
                return false;
            $(this).removeAttr('enabled');
            $(this).attr('disabled', 'disabled');
            $(this).addClass("disabled")
            console.log($(this));
        };
      $("#create-user").each(disable);
      $('input:enabled, select:enabled, a:enabled').each(disable);
      $('button:enabled, button.enabled, select:enabled').each(disable);
      $('textarea:enabled, select:enabled').each(disable);
        $(".enabledbutton").attr("class", "panel panel-default col-md-2 disabledbutton");
    }
}
