// author : Joël.DE-SOUSA
// enable some CRUD components (not read only)
function enable() {

    if($("#padlock").hasClass("closed")){

      $("#padlock").attr('class', 'btn btn-danger pull-right opened');
      //$("#padlock").html('Close padlock');
      $(".padlock").css("display", "none");
      $(".unlock").css("display", "block");
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
      $(".padlock").css("display", "block");
      $(".unlock").css("display", "none");
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
      // $("#padlock").removeAttr('disabled');
      // $("#padlock").attr('enabled', 'enabled');
      $('textarea:enabled, select:enabled').each(disable);

      /////// ERIC DISABLE AND ENABLE COMPONENTS
      $(".enabledbutton").attr("class", "panel panel-default col-md-2 disabledbutton");
      //$(".disablesecondbutton")
      /////// END OF ERIC
    }
}
