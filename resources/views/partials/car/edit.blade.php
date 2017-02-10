<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $mode !== null && $mode === "edit" ? "Edit the car " : "Create a car" }}</div>
            <div class="panel-body">

              @if($car->exists())
                {{ Form::model($car, array('route' => array('cars.update', $car->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
              @else
                {{ Form::open(array('route' => 'cars.store', 'method' => 'POST', 'class' => 'form-horizontal')) }}

              @endif
                {{ Form::bsText("plate_number", old("plate_number")) }}
                {{ Form::bsText("brand", old("brand")) }}
                {{ Form::bsText("model", old("model")) }}
                {{ Form::bsText("color", old("color")) }}
                {{ Form::bsText("nb_place", old("nb_place")) }}
                {{ Form::bsText("name", old("name")) }}

                <div class="form-group{{ $errors->has('stat') ? ' has-error' : '' }}">
                  {{ Form::label('stat', 'Status ', array('class' => 'col-md-4 control-label')) }}
                  <div class="col-md-6">
                    {{ Form::text('stat', old('stat'), array('class' => 'form-control')) }}
                    @if ($errors->has('stat'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stat') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                {{ Form::bsSelect("car_type",$car_types->mapWithKeys(function($t){return [" {$t->id}"=>$t->type];}),old("car_type",$car->car_type_id)) }}
                <!-- <div class="form-group{{ $errors->has('car_type_id') ? ' has-error' : '' }}">
                  {{ Form::label('car_type_id', 'Type de voiture ', array('class' => 'col-md-4 control-label')) }}
                  <div class="col-md-6">
                    <select {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} id="car_type_id" name="type" class="form-control" required autofocus>
                      <option disabled>Sélectionnez un type...</option>
                      @foreach($car_types as $car_type)
                        @if(old("type") == $car_type->id)
                          <option value="{{ $car_type->id }}" selected>{{ $car_type->type }}</option>
                        @elseif($car->type !== null && $car_type->id == $car->type->id)
                          <option value="{{ $car_type->id }}" selected>{{ $car_type->type }}</option>
                        @else
                          <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
                        @endif
                      @endforeach
                    </select>
                    @if ($errors->has('car_type_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('car_type_id') }}</strong>
                        </span>
                    @endif
                  </div>
                </div> -->
                @if(auth()->check())
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <div class="col-md-3">
                            <input type="submit" class="btn btn-primary" {{ $car->exists()?"disabled":"" }} name="" value="{{ $car->exists() ? "Edit" : "Create" }} the car">
                              <!-- <button {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="submit" class="btn btn-primary">
                                  <span>{{ $mode == "edit" ? "Edit" : "Create" }} the car</span>
                              </button> -->
                          </div>
                          <div class="col-md-3 col-md-push-1">
                              <a href="{{ route("cars.index") }}" class="btn btn-danger">Cancel</a>
                          </div>

                      </div>
                    </div>
                @endif
                {{ csrf_field() }}
              {{ Form::close() }}
              <form method="post" action="{{ route("cars.destroy",$car) }}"  class="pull-right">
                  <input type="hidden" value="DELETE" name="_method">
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">
                  <input disabled type="submit" id="delete" value="Delete this car" class="btn btn-warning">
              </form>
                @if($car->exists)
                  @include("partials.comment.create",["route"=>route("cars.comments.store",["car"=>$car])])
                  @each("partials.comment.show",$car->comments,"comment")

                @endif
              {{--<div class="form-group">--}}
                {{--<div class="col-md-6 col-md-offset-4">--}}
                  {{--<button disabled type="submit" class="btn btn-primary">--}}
                    {{--Edit the car--}}
                  {{--</button>--}}
                {{--</div>--}}
              {{--</div>--}}




              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@if(!$car->exists())
  @push("scripts")
  <script type="text/javascript">
    $(document).ready(function(){
      $("input:disabled,select:disabled").removeAttr("disabled");
    });
  </script>
  @endpush
@endif
