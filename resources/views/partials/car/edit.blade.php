<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Edit {{$car->shortname}}</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/car/'.$car->id) }}">
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                  <label for="license_plates" class="col-md-4 control-label">Plates licence </label>
                  <div class="col-md-6">
                    <input type="text" id="licence" name="license_plates" class="form-control" value="{{$car->license_plates}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="brand" class="col-md-4 control-label">Brand </label>
                  <div class="col-md-6">
                    <input type="text" id="brand" name="brand" class="form-control" value="{{$car->brand}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="model" class="col-md-4 control-label">Model </label>
                  <div class="col-md-6">
                    <input type="text" id="model" name="model" class="form-control" value="{{$car->model}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="color" class="col-md-4 control-label">Color </label>
                  <div class="col-md-6">
                    <input type="text" id="color" name="color" class="form-control" value="{{$car->color}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="seats" class="col-md-4 control-label">Seats </label>
                  <div class="col-md-6">
                    <input type="text" id="seats" name="seats" class="form-control" value="{{$car->seats}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="shortname" class="col-md-4 control-label">Short name </label>
                  <div class="col-md-6">
                    <input type="text" id="shortname" name="shortname" class="form-control" value="{{$car->shortname}}" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="comment" class="col-md-4 control-label">Comment </label>
                  <div class="col-md-6">
                    <textarea id="comment" name="comment" class="form-control" required autofocus>{{$car->comment}}</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="type" class="col-md-4 control-label">Type </label>
                  <div class="col-md-6">
                    <select id="type" name="car_types_id" class="form-control" required autofocus>
                      <option selected disabled>Sélectionnez un type...</option>
                      @foreach($car_types as $car_type)
                        @if($car->car_types_id == $car_type->id)
                          <option selected value="{{ $car_type->id }}">{{ $car_type->type }}</option>
                        @else
                          <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <button type="submit" class="btn btn-primary">
                          Edit the car
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
