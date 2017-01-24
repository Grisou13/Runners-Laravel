<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Create a car</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/car') }}">
                <div class="form-group">
                  <label for="plate_number" class="col-md-4 control-label">Plates licence </label>
                  <div class="col-md-6">
                    <input type="text" id="licence" name="plate_number" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="brand" class="col-md-4 control-label">Brand </label>
                  <div class="col-md-6">
                    <input type="text" id="brand" name="brand" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="model" class="col-md-4 control-label">Model </label>
                  <div class="col-md-6">
                    <input type="text" id="model" name="model" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="color" class="col-md-4 control-label">Color </label>
                  <div class="col-md-6">
                    <input type="text" id="color" name="color" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="seats" class="col-md-4 control-label">Seats </label>
                  <div class="col-md-6">
                    <input type="text" id="seats" name="nb_place" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="shrtname" class="col-md-4 control-label">Short name </label>
                  <div class="col-md-6">
                    <input type="text" id="shrtname" name="name" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="comment" class="col-md-4 control-label">Comment </label>
                  <div class="col-md-6">
                    <textarea id="comment" name="comment" class="form-control" required autofocus></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    <input type="text" id="stat" name="stat" class="form-control" required autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="type" class="col-md-4 control-label">Type </label>
                  <div class="col-md-6">
                    <select id="type" name="car_types_id" class="form-control" required autofocus>
                      <option selected disabled>Sélectionnez un type...</option>
                      @foreach($car_types as $car_type)
                        <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
                      @endforeach
                    </select>
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
