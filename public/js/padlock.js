// enable some CRUD components (not read only)
function enable() {

    if($("#padlock").attr('class') == 'btn btn-success pull-right'){

      $("#padlock").attr('class', 'btn btn-danger pull-right');

      $("#padlock").html('Open padlock');

      $("#create-car").attr('style', 'display : block');

      $('input:disabled, select:disabled').each(function () {
         $(this).removeAttr('disabled');
         $(this).attr('enabled', 'enabled');
      });

      $('button:disabled, select:disabled').each(function () {
         $(this).removeAttr('disabled');
         $(this).attr('enabled', 'enabled');
      });

      $('textarea:disabled, select:disabled').each(function () {
         $(this).removeAttr('disabled');
         $(this).attr('enabled', 'enabled');
      });

      $(".disabledbutton").attr("class", "panel panel-default col-md-2 enabledbutton");
      console.log($(".panel panel-default col-md-2 disabledbutton"));
    }else{

      $("#padlock").attr('class', 'btn btn-success pull-right');

      $("#padlock").html('Closed padlock');

      $("#create-car").attr('style', 'display : none');

      $('input:enabled, select:enabled').each(function () {
         $(this).removeAttr('enabled');
         if($(this).attr('type') == 'text' || $(this).attr('id') == 'delete'){
           $(this).attr('disabled', 'disabled');
         }
      });

      $('button:enabled, select:enabled').each(function () {
         $(this).removeAttr('enabled');
         $(this).attr('disabled', 'disabled');
      });
      $("#padlock").removeAttr('disabled');
      $("#padlock").attr('enabled', 'enabled');

      $('textarea:enabled, select:enabled').each(function () {
         $(this).removeAttr('enabled');
         $(this).attr('disabled', 'disabled');
      });

      $(".enabledbutton").attr("class", "panel panel-default col-md-2 disabledbutton");
    }
}
