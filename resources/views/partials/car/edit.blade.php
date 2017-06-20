<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{ $mode !== null && $mode === "edit" ? "Edition de la voiture " : "Création d'une voiture" }}</div>
            <div class="panel-body">
                <!-- si la voiture existe -->
                @if($car->exists)
                  {{ Form::model($car, array('route' => array('cars.update', $car), 'class' => 'form-horizontal', 'method' => 'put')) }}
                @else
                  {{ Form::open(array('route' => 'cars.store', 'class' => 'form-horizontal')) }}
                @endif
                {{ Form::bsSelect("Type de voiture","car_type",$car_types->mapWithKeys(function($t){return [" {$t->id}"=>$t->name];}),$car->car_type_id) }}
                {{ Form::bsText("Nom du véhicule","name",$car->name,[],false) }}

                {{ Form::bsText("Numéro de plaque","plate_number",$car->plate_number,[],false) }}
                {{ Form::bsText("Marque","brand",$car->brand,[],false) }}
                {{ Form::bsText("Model","model",$car->model,[],false) }}
                {{ Form::bsText("Couleur","color",$car->color,[],false) }}
                {{ Form::bsText("Nombre de place disponible","nb_place",$car->nb_place) }}
                <div class="form-group">
                  @foreach($errors as $er)
                    <div class="alert alert-danger">
                      {{ $er }}
                    </div>
                  @endforeach
                </div>
                @if($car->exists)
                  {{ Form::bsSelect("Etat de la voiture","status",\App\Helpers\Status::getFullStatusForRessource($car),old("status",$car->status)) }}
                @endif

                @if(auth()->check())
                    <div class="form-group">
                          <div class="col-md-2 col-md-push-2">
                            <button type="submit" class="btn btn-primary">
                              <span>{{ $car->exists ? "Sauvegarder" : "Créer la voiture" }}</span>
                            </button>

                          </div>
                          <div class="col-md-2 col-md-push-1">
                              <a href="{{ route("cars.index") }}" class="btn btn-default pull-right">Annuler</a>
                          </div>
                        @if($car->exists)
                            <div class="col-md-2 col-md-push-2">
                                <button id="delete-btn" class="btn btn-danger"><span>Supprimer la voiture</span></button>
                            </div>
                        @endif
                    </div>
                @endif
              {{ Form::close() }}
                @if($car->exists && auth()->check())
                  @include("partials.comment.create",["route"=>route("cars.comments.store",["car"=>$car])])
                  @each("partials.comment.show",$car->comments,"comment")
                @endif

              @if(auth()->check() && $car->exists)
                <form method="post" action="{{ route("cars.destroy",$car) }}" id="delete"  class="">
                    <input type="hidden" value="DELETE" name="_method">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                </form>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  @push("scripts")
  <script type="text/javascript">
    $(document).ready(function(){
      $("input:disabled,select:disabled").removeAttr("disabled");
    });
    document.getElementById("delete-btn").addEventListener("click",function(e){
        e.preventDefault()
        swal({
                    title: "Êtes vous sur?",
                    text: "Vous allez supprimer une voiture définitevement!",
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

