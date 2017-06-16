$(document).ready(function(){
  $(".comment-hover").mouseenter(function(){
    $(this).siblings(".comments").css("visibility","visible");
  });
  $(".comment-hover").mouseleave(function(){
    $(this).siblings(".comments").css("visibility","hidden");
  });
});
