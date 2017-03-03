<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Creer un utilisateur</div>
            <div class="panel-body">

              @if($user->exists())
                {{ Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
              @else
                {{ Form::open(array('route' => 'users.store', 'method' => 'POST', 'class' => 'form-horizontal')) }}

              @endif
                {{ Form::bsText("first_name", old("first_name")) }}
                {{ Form::bsText("last_name", old("last_name")) }}
                {{ Form::bsText("shortname", old("shortname")) }}
                {{ Form::bsText("email", old("email")) }}
                {{ Form::bsText("phone", old("phone")) }}
                <div class="form-group">
                  <label for="sex" class="col-md-4 control-label">Sexe </label>
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
                {{ Form::bsText("access_token", old("name")) }}

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
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <div class="col-md-3">
                        <input type="submit" class="btn btn-primary" {{ $user->exists()?"disabled":"" }} name="" value="{{ $user->exists() ? "Create" : "Edit" }} the user">

                      </div>
                      <div class="col-md-3 col-md-push-1">
                          <a href="{{ route("users.index") }}" class="btn btn-danger">Cancel</a>
                      </div>

                  </div>
                </div>

                {{ csrf_field() }}
              {{ Form::close() }}
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
@if(!$user->exists())
  @push("scripts")
  <script type="text/javascript">
    $(document).ready(function(){
      $("input:disabled,select:disabled").removeAttr("disabled");
    });
  </script>
  @endpush
@endif
