@if($run->exists)
    {!! Form::model($run,["route"=>["runs.update",$run],'class' => 'form-horizontal', 'method' => 'put']) !!}
@else
    {!! Form::model($run,["route"=>["runs.store"],'class' => 'form-horizontal']) !!}
@endif
{!! Form::token() !!}
@include("partials.run.fields",compact("run","waypoints","car_types"))
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary" name="" value="{{ $run->exists ? "Edit" : "Create" }} the run">
        </div>
        <div class="col-md-3 col-md-push-1">
            <a href="{{ route("runs.index") }}" class="btn btn-danger">Cancel</a>
        </div>

    </div>
</div>

{!! Form::close() !!}
@if(auth()->check() && $run->exists)
  <form method="post" action="{{ route("runs.destroy",$run) }}"  class="pull-right">
      <input type="hidden" value="DELETE" name="_method">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="submit" id="delete" value="Supprimer la course" class="btn btn-warning">
  </form>
@endif
@if($run->exists)
  @include("partials.comment.create",["route"=>route("runs.comments.store",["run"=>$run])])
  @each("partials.comment.show",$run->comments,"comment")
@endif
