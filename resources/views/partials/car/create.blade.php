<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Création d'une voiture</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('car.store') }}">
                <div class="form-group{{ $errors->has('plate_number') ? ' has-error' : '' }}">
                  <label for="plate_number" class="col-md-4 control-label">Plates licence </label>
                  <div class="col-md-6">
                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" class="form-control" required autofocus>

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
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}" class="form-control" required autofocus>
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
                    <input type="text" id="model" name="model" value="{{ old('model') }}" class="form-control" required autofocus>
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
                    <input type="text" id="color" name="color" value="{{ old('color') }}" class="form-control" required autofocus>
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
                    <input type="text" id="nb_place" name="nb_place" value="{{ old('nb_place') }}" class="form-control" required autofocus>
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
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                  <label for="comment" class="col-md-4 control-label">Comment </label>
                  <div class="col-md-6">
                    <textarea id="comment" name="comment" class="form-control" required autofocus>{{ old('comment')}}</textarea>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('stat') ? ' has-error' : '' }}">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    <input type="text" id="stat" name="stat" value="{{ old('stat') }}" class="form-control" required autofocus>
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
                    <select id="car_type_id" name="car_type_id" class="form-control" required autofocus>
                      <option selected disabled>Sélectionnez un type...</option>
                      @foreach($car_types as $car_type)
                        <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('car_type_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('car_type_id') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <button type="submit" class="btn btn-primary">
                          Create the car
                      </button>
                  </div>
                </div>
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
