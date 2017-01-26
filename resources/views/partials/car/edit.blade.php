<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $mode !== null && $mode === "edit" ? "Edit the car " : "Create a car" }}</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ $mode == 'edit'? route('cars.update',$car) : route('cars.store') }}">
                @if($mode == "edit")
                <input type="hidden" name="_method" value="PUT">
                @endif
                <div class="form-group{{ $errors->has('plate_number') ? ' has-error' : '' }}">
                  <label for="plate_number" class="col-md-4 control-label">Plates licence </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="plate_number" name="plate_number" value="{{ old('plate_number',$car->plate_number ) }}" class="form-control" required autofocus>

                    @if ($errors->has('plate_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('plate_number') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
                  <label for="brand" class="col-md-4 control-label">Brand </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="brand" name="brand" value="{{ old('brand',$car->brand) }}" class="form-control" required autofocus>
                    @if ($errors->has('brand'))
                        <span class="help-block">
                            <strong>{{ $errors->first('brand') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                  <label for="model" class="col-md-4 control-label">Model </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="model" name="model" value="{{ old('model',$car->model) }}" class="form-control" required autofocus>
                    @if ($errors->has('model'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                  <label for="color" class="col-md-4 control-label">Color </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="color" name="color" value="{{ old('color',$car->color) }}" class="form-control" required autofocus>
                    @if ($errors->has('color'))
                        <span class="help-block">
                            <strong>{{ $errors->first('color') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('nb_place') ? ' has-error' : '' }}">
                  <label for="nb_place" class="col-md-4 control-label">Seats </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="nb_place" name="nb_place" value="{{ old('nb_place',$car->nb_place) }}" class="form-control" required autofocus>
                    @if ($errors->has('nb_place'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nb_place') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name" class="col-md-4 control-label">Short name </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="name" name="name" value="{{ old('name',$car->name) }}" class="form-control" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>


                <div class="form-group{{ $errors->has('stat') ? ' has-error' : '' }}">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    <input {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="text" id="stat" name="stat" value="{{ old('stat',$car->stat) }}" class="form-control" required autofocus>
                    @if ($errors->has('stat'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stat') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('car_type_id') ? ' has-error' : '' }}">
                  <label for="car_type_id" class="col-md-4 control-label">Type </label>
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
                </div>
                @if(auth()->check())
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                          <div class="col-md-3">
                              <button {{ $mode !== null && $mode === "edit" ? 'disabled' : ''}} type="submit" class="btn btn-primary">
                                  {{ $mode == "edit" ? "Edit" : "Create" }} the car
                              </button>
                          </div>
                          <div class="col-md-3 col-md-push-1">
                              <a href="{{ route("cars.index") }}" class="btn btn-danger">Cancel</a>
                          </div>

                      </div>
                    </div>
                    <form method="post" action="{{ route("cars.destroy",$car) }}"  class="pull-right">
                        <input type="hidden" value="DELETE" name="_method">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <input disabled type="submit" id="delete" value="Delete this car" class="btn btn-warning">
                    </form>
                @endif
                {{ csrf_field() }}
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
