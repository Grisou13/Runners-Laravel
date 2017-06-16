<?php
Broadcast::channel('Lib.Models.User.{id}', function ($user, $id) {
  return (int) $user->id === (int) $id;
});
Broadcast::channel('Lib.Models.Run.{runId}', function ($user, $runId) {
  return true;
});
Broadcast::channel('runs.{runId}', function ($user, $runId) {
  return true;
});
Broadcast::channel("test",function($user,$userId){
  return true;
});