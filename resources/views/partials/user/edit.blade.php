<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Edit {{$user->firstname . " " . $user->lastname}}</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ route("users.update",$user) }}">
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                  <label for="first_name" class="col-md-4 control-label">First name </label>
                  <div class="col-md-6">
                    <input type="text" id="first_name" class="form-control" name="firstname" value="{{ $user->firstname }}">
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                  <label for="last_name" class="col-md-4 control-label">Last name </label>
                  <div class="col-md-6">
                    <input type="text" id="last_name" class="form-control" name="lastname" value="{{ $user->lastname }}">
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="shortname" class="col-md-4 control-label">Shortname </label>
                  <div class="col-md-6">
                    <input type="text" id="shortname" class="form-control" name="name" value="{{ $user->name }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email" class="col-md-4 control-label">Email </label>
                  <div class="col-md-6">
                    <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                  <label for="phone" class="col-md-4 control-label">Telephone number </label>
                  <div class="col-md-6">
                    <input type="text" id="phone" class="form-control" name="phone_number" value="{{ $user->phone_number }}">
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                  <label for="sex" class="col-md-4 control-label">Sex </label>
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
                    @if ($errors->has('sex'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sex') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('stat') ? ' has-error' : '' }}">
                  <label for="stat" class="col-md-4 control-label">Status </label>
                  <div class="col-md-6">
                    <input type="text" id="stat" class="form-control" name="stat" value="{{ $user->stat }}">
                    @if ($errors->has('stat'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stat') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('accesstoken') ? ' has-error' : '' }}">
                  <label for="qr_code" class="col-md-4 control-label">QR code </label>
                  <div class="col-md-6">
                    <input type="text" id="qr_code" class="form-control" name="accesstoken" value="{{ $user->accesstoken }}">
                    @if ($errors->has('accesstoken'))
                        <span class="help-block">
                            <strong>{{ $errors->first('accesstoken') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Edit the user
                        </button>
                    </div>
                </div>
                {{ csrf_field() }}
              </form>
              <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="thumbnail">

                      @if($user->profileImage() != null)
                        <a href="{{ url('images/'.$user->profileImage()->filename)}}" class="thumbnail">
                          <img src="{{ url('images/'.$user->profileImage()->filename)}}" alt="facepicture">
                        </a>
                      @endif
                      <div class="caption">
                        <form method="post" enctype="multipart/form-data" files="true" action="{{ route('image.upload') }}">
                          <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                          <input type="hidden" value="profile" name="type">
                          <input type="hidden" value="{{$user->id}}" name="id">
                          <div class="form-group">
                            <label for="image">Photo de profile</label>
                            <input type="file" name="image" id="image">
                          </div>
                          <input type="hidden" value="{{ csrf_token() }}" name="_token">
                          <input type="submit" class="btn btn-success" value="Changer">
                        </form>
                      </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="thumbnail">

                      @if($user->licenseImage() != null)
                        <a href="{{ url('images/' . $user->licenseImage()->filename)}}" class="thumbnail">
                          <img src="{{ url('images/' . $user->licenseImage()->filename)}}" alt="facepicture">
                        </a>
                      @endif
                      <div class="caption">
                        <form method="post" enctype="multipart/form-data" files="true" action="{{ route('image.upload') }}">
                          <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                          <input type="hidden" value="license" name="type">
                          <input type="hidden" value="{{$user->id}}" name="id">
                          <div class="form-group">
                            <label for="image">Permis de conduire</label>
                            <input type="file" name="image" id="image">
                          </div>
                          <input type="hidden" value="{{ csrf_token() }}" name="_token">
                          <input type="submit" class="btn btn-success" value="Changer">
                        </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
