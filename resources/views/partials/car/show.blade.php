<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Details {{$car->shortname}}</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ route("car.update",$car) }}">
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                  <label for="license_plates" class="col-md-4 control-label">Plates licence </label>
                  <div class="col-md-6">
                    {{$car->license_plates}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="brand" class="col-md-4 control-label">Brand </label>
                  <div class="col-md-6">
                    {{$car->brand}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="model" class="col-md-4 control-label">Model </label>
                  <div class="col-md-6">
                    {{$car->model}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="color" class="col-md-4 control-label">Color </label>
                  <div class="col-md-6">
                    {{$car->color}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="seats" class="col-md-4 control-label">Seats </label>
                  <div class="col-md-6">
                    {{$car->seats}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="shortname" class="col-md-4 control-label">Short name </label>
                  <div class="col-md-6">
                    {{$car->shortname}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="comment" class="col-md-4 control-label">Comment </label>
                  <div class="col-md-6">
                    {{$car->comment}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    {{$car->stat}}
                  </div>
                </div>

                <div class="form-group">
                  <label for="type" class="col-md-4 control-label">Type </label>
                  <div class="col-md-6">
                    <select id="type" name="car_types_id" class="form-control" required autofocus>
                      <option disabled selected>{{$car->type->type}}</option>
                    </select>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
