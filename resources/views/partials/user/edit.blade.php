<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Edit {{$user->first_name . " " . $user->last_name}}</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/'.$user->id) }}">
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                  <label for="first_name" class="col-md-4 control-label">First name </label>
                  <div class="col-md-6">
                    <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $user->first_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-md-4 control-label">Last name </label>
                  <div class="col-md-6">
                    <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="shortname" class="col-md-4 control-label">Shortname </label>
                  <div class="col-md-6">
                    <input type="text" id="shortname" class="form-control" name="shortname" value="{{ $user->shortname }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="email" class="col-md-4 control-label">Email </label>
                  <div class="col-md-6">
                    <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="phone" class="col-md-4 control-label">Telephone number </label>
                  <div class="col-md-6">
                    <input type="text" id="phone" class="form-control" name="phone" value="{{ $user->phone }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="sex" class="col-md-4 control-label">Short name </label>
                  <div class="col-md-6">
                    <select id="sex" name="sex" class="form-control">
                      @if($user->sex == 0)
                        <option selected value="0">Female</option>
                        <option value="1">Male</option>
                      @else
                      <option value="0">Female</option>
                      <option selected value="1">Male</option>
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    <input type="text" id="stat" class="form-control" name="stat" value="{{ $user->stat }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="qr_code" class="col-md-4 control-label">QR code </label>
                  <div class="col-md-6">
                    <input type="text" id="qr_code" class="form-control" name="qr_code" value="{{ $user->qr_code }}">
                  </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Edit the user
                        </button>
                    </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-3">
                      <div class="thumbnail">
                        <a href="{{ url('images/enhanced-buzz-10063-1384442301-0.jpg')}}" class="thumbnail">
                          <img src="{{ url('images/enhanced-buzz-10063-1384442301-0.jpg')}}" alt="facepicture">
                        </a>
                        <div class="caption">
                          <form method="post" enctype="multipart/form-data" action="">
                            <div class="form-group">
                              <label for="inputFile">File input</label>
                              <input type="file" id="inputFile">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <input type="submit" class="btn btn-success" value="Changer">
                          </form>
                        </div>
                      </div>
                  </div>
                  <div class="col-xs-6 col-md-3">
                      <div class="thumbnail">
                        <a href="{{ url('images/exemple-permis-conduire.png')}}" class="thumbnail">
                          <img src="{{ url('images/exemple-permis-conduire.png')}}" alt="facepicture">
                        </a>
                        <div class="caption">
                          <button type="button" class="btn btn-success">Changer</button>
                        </div>
                      </div>
                  </div>
                </div>
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
