<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Edit {{$user->firstname . " " . $user->lastname}}</div>
            <div class="panel-body">
              <!-- si l'utilisateur existe -->
              @if($user->exists)
                {{ Form::model($user, array('route' => array('users.update', $user), 'class' => 'form-horizontal', 'method' => 'put')) }}
              @else
                {{ Form::open(array('route' => 'users.store', 'class' => 'form-horizontal')) }}
              @endif
              {{ Form::bsText("firstname", old("firstname")) }}
              {{ Form::bsText("lastname", old("lastname")) }}
              {{ Form::bsText("name", old("name")) }}
              {{ Form::bsText("email", old("email")) }}
              {{ Form::bsText("phone_number", old("phone_number")) }}
              {{ Form::bsSelect("sex",[0 => "Male", 1 => 'Female'],old("sex")) }}
              {{ Form::bsText("stat", old("stat")) }}
              {{ Form::bsText("accesstoken", old("accesstoken")) }}

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input type="submit" class="btn btn-primary" value="Edit the user" disabled>
                    </div>
                </div>
                {{ csrf_field() }}
                {{ Form::close() }}
              <!--</form>-->
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
                          <input type="submit" class="btn btn-success" value="Changer" disabled>
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
                          <input type="submit" class="btn btn-success" value="Changer" disabled>
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
