<div class="panel panel-default  ">
  <div class="panel-heading {{ $run->status }}">{{$run->name}} ({{ $run->status }})</div>
    <div class="panel-body">
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
    </div>
</div>

@if($run->exists)
  <form method="post" action="{{ route("runs.destroy",$run) }}"  class="pull-right">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="submit" id="delete" value="Supprimer la course" class="btn btn-warning">
  </form>
  @if($run->status == "ready")
  <form method="post" action="{{ route("runs.start",$run) }}"  class="pull-right">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="submit" id="delete" value="Démarrer la course" class="btn btn-warning">
  </form>
  @elseif($run->status=="gone")
  <form method="post" action="{{ route("runs.stop",$run) }}"  class="pull-right">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="submit" id="delete" value="Forcer l'arrêt de la course" class="btn btn-warning">
  </form>
  @else
  <form method="post" action="{{ route("runs.start",$run) }}"  class="pull-right">
      <input type="hidden" value="DELETE" name="_method">
      <input type="hidden" value="{{ csrf_token() }}" name="_token">
      <input type="submit" id="delete" value="Forcer le démarrage de la course" class="btn btn-warning">
  </form>
  @endif
@endif
@if($run->exists)
  @include("partials.comment.create",["route"=>route("runs.comments.store",["run"=>$run])])
  @each("partials.comment.show",$run->comments,"comment")
@endif
