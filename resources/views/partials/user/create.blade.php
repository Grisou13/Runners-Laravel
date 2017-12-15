<!--
User: Joel.DE-SOUSA
-->
{{ dump($errors) }}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Création d'un chauffeur</div>
            <div class="panel-body">
              @if($user->exists)
                {{ Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
              @else
                {{ Form::open(array('route' => 'users.store', 'method' => 'POST', 'class' => 'form-horizontal')) }}
              @endif
                @include("partials.user.fields")
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <div class="col-md-3">
                        <input type="submit" class="btn btn-primary" name="" value="{{ $user->exists() ? "Crée un nouveau chauffeur" : "Sauvegarder" }}">

                      </div>
                      <div class="col-md-3 col-md-push-1">
                          <a href="{{ route("users.index") }}" class="btn btn-danger">Cancel</a>
                      </div>

                  </div>
                </div>

                {{ csrf_field() }}
              {{ Form::close() }}
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
