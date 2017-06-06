<!--
User: Joel.DE-SOUSA
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Edition de {{$user->firstname . " " . $user->lastname}}</div>
            <div class="panel-body">
              <!-- si l'utilisateur existe -->
              @if($user->exists)
                {{ Form::model($user, array('route' => array('users.update', $user), 'class' => 'form-horizontal', 'method' => 'put')) }}
              @else
                {{ Form::open(array('route' => 'users.store', 'class' => 'form-horizontal')) }}
              @endif
                @include("partials.user.fields")
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="col-md-3">
                          <input type="submit" class="btn btn-primary" value="Editer l'utilisateur">
                        </div>
                        <div class="col-md-3 col-md-push-1">
                            <a href="{{ route("users.index") }}" class="btn btn-danger">Annuler</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                {{ csrf_field() }}
                {{ Form::close() }}
              <!--</form>-->
              @if(auth()->check())
                <form method="post" action="{{ route("users.destroy",$user) }}"  class="pull-right">
                    <input type="hidden" value="DELETE" name="_method">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <input type="submit" id="delete" value="Supprimer l'utilisateur" class="btn btn-warning">
                </form>
              @endif
              <div class="row">
                <div class="col-xs-6 col-md-3">


                    <div class="thumbnail">

                      @if($user->profileImage() != null)
                        <a href="" class="thumbnail">
                          <img src="{{ $user->profileImage()->url() }}" alt="facepicture">
                        </a>
                      @else
                        <a href="{{ url('images/icons/default_pp.png')}}" class="thumbnail">
                          <img src="{{ url('images/icons/default_pp.png')}}" alt="facepicture">
                        </a>
                      @endif
                      <div class="caption">
                        <form method="post" enctype="multipart/form-data" files="true" action="{{ route('image.profile',compact("user")) }}">
                          <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                          <div class="form-group">
                            <label for="image">Photo de profile</label>
                            <input type="file" name="image" id="image" accept="image/*">
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
                        <a href="#" class="thumbnail">
                          <img src="{{ $user->licenseImage()->url() }}" alt="facepicture">
                        </a>
                      @else
                        <a href="{{ url('images/icons/default_pp.png')}}" class="thumbnail">
                          <img src="{{ url('images/icons/default_pp.png')}}" alt="facepicture">
                        </a>
                      @endif
                      <div class="caption">
                        <form method="post" enctype="multipart/form-data" files="true" action="{{ route('image.license',compact("user")) }}">
                          <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                          <div class="form-group">
                            <label for="image">Permis de conduire</label>
                            <input type="file" name="image" id="image" accept="image/*">
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
