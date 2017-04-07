<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $mode !== null && $mode === "edit" ? "Editez la course " : "Créez une course" }}</div>
            <div class="panel-body">
              @if($run->exists)
                  {!! Form::model($run,["route"=>["runs.update",$run]]) !!}
              @else
                  {{ Form::open(array('route' => 'runs.store', 'class' => 'form-horizontal')) }}
              @endif
              {{ Form::bsText("Nom", old("name")) }}
              {{ Form::bsText("Nombre de passagers", old("nb_passenger")) }}
              {{ Form::bsText("Artiste", old("artist")) }}
              {{ Form::bsText("Commence à", old("started_at")) }}
              {{ Form::bsSelect("Type de voiture",
                $car_types->mapWithKeys(function($t){
                  return ["{$t->id}"=>$t->name];
                }),
                old("car_type"))
              }}
              {{ Form::bsSelect("Départ",
                $waypoints->mapWithKeys(function($t){
                  return ["{$t->id}"=>$t->name];
                }),
                  old("car_type"), ["id" => "waypointsInput"])
              }}
              @if(auth()->check())
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="col-md-3">
                          <input type="submit" class="btn btn-primary" {{ $run->exists?"disabled":"" }} name="" value="{{ $run->exists ? "Edit" : "Create" }} the run">
                        </div>
                        <div class="col-md-3 col-md-push-1">
                            <a href="{{ route("runs.index") }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                  </div>
              @endif
              {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
@if(!$run->exists)
  @push("scripts")
  <script type="text/javascript">
    $(document).ready(function(){
      $("input:disabled,select:disabled").removeAttr("disabled");
    });
    var cln = document.getElementById("waypointsInput").cloneNode(true);
    document.getElementsByClassName('form-horizontal')[0].appendChild(cln);
    // TODO: add element waypoint
  </script>
  @endpush
@endif
