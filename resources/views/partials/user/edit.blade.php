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
                    <div class="col-md-6 col-md-offset-2 row">
                        <div class="col-md-2">
                          <input type="submit" class="btn btn-primary" value="Sauvegarder">
                        </div>
                        <div class="col-md-2 col-md-push-1">
                            <a href="{{route("users.index") }}" class="btn btn-danger">Annuler</a>
                        </div>
                        <div class="col-md-2 col-md-push-2">
                            <button id="delete-btn" class="btn btn-warning"><span>Supprimer l'utilisateur</span></button>
                        </div>
                        <div class="col-md-2 col-md-push-5">
                            <button id="reset-btn" class="btn btn-warning"><span>Reset le mot de passe</span></button>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                {{ Form::close() }}
              <!--</form>-->
              @if(auth()->check())
                <form method="post" id="delete" action="{{ route("users.destroy",$user) }}">
                    {!! method_field("delete") !!}
                    {{ csrf_field() }}
                </form>
                    <form id="reset" action="{{route("users.reset",compact("user"))}}" method="post" >
                        {{ csrf_field() }}
                    </form>
              @endif
              <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="thumbnail">
                      @if($user->profileImage() != null)
                        <a href="" class="thumbnail">
                          <img src="{{ $user->profileImage()->url() }}" alt="facepicture">
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
@push("scripts")
<script>
    document.getElementById("reset-btn").addEventListener("click",function(e){
        e.preventDefault()
        document.getElementById("reset").submit()
    })
    document.getElementById("delete-btn").addEventListener("click",function(e){
        e.preventDefault()
        swal({
                    title: "Êtes vous sur?",
                    text: "Vous allez supprimer un utilisateur!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirmer!",
                    closeOnConfirm: true
                },
                function(){
                    document.getElementById('delete').submit()
                });

    })
</script>
@endpush