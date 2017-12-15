<div class="panel panel-default  ">
  <div class="panel-heading {{ $run->status }}">{{$run->name}} ({{ \App\Helpers\Status::getStatusName("run",$run->status) }})</div>
  <div class="panel-body">
    @if($run->exists)
      @if($run->drafting)
        {!! Form::model($run,["route"=>["runs.publish",$run],'class' => 'form-horizontal']) !!}
      @else
        {!! Form::model($run,["route"=>["runs.update",$run],'class' => 'form-horizontal', 'method' => 'put']) !!}
      @endif
    @else
      {!! Form::model($run,["route"=>["runs.store"],'class' => 'form-horizontal']) !!}
    @endif
{{--    {!! Form::token() !!}--}}

    @include("partials.run.fields",compact("run","waypoints","car_types"))

    <div class="form-group">
      <div class="col-md-10 col-md-offset-1 row">
        <div class="">
          <input type="submit" class="btn btn-primary col-md-3" name="" value="{{ $run->exists ? $run->drafting ? "Publier" : "Sauvegarder" : "Crée un nouveau run" }}">
        </div>
        <div class="">
          <a href="{{ route("runs.index") }}" class="btn btn-warning col-md-2">Cancel</a>
        </div>
        @if($run->exists)
        <div class="">
          <button type="button" id="delete" class="btn btn-danger col-md-3" >
            <span>Supprimer la course</span>
          </button>
        </div>
        @if(!$run->drafting)
          <div class="">
            <button onclick="document.getElementById('form-action').submit()" type="button" id="delete" class="btn btn-danger col-md-3" >
              <span>
              @if($run->status == "ready")
                Démarrer la course
              @elseif($run->status=="gone")
                Terminer la course
              @else
                Forcer démarrage de la course
              @endif
              </span>
            </button>
          </div>
          @endif
        @endif
      </div>
    </div>
    {!! Form::close() !!}
      @if($run->exists)
          <form method="post" id="form-delete" action="{{ route("runs.destroy",$run) }}"  class="pull-right">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            {!! method_field("DELETE") !!}
          </form>
          @if(!$run->drafting)
            @if($run->status == "ready")
              <form id="form-action" method="post" action="{{ route("runs.start",$run) }}"  class="pull-right">
            @elseif($run->status=="gone")
              <form id="form-action" method="post" action="{{ route("runs.stop",$run) }}"  class="pull-right">
            @else
              <form id="form-action" method="post" action="{{ route("runs.start",$run) }}"  class="pull-right">
            @endif
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
              </form>
          @endif
      @endif
  </div>
</div>
@push("scripts")
<script>
  document.getElementById("delete").addEventListener("click", function(e){
    e.preventDefault();
    swal({
          title: "Êtes-vous sur?",
          text: "Êtes vous sur de vouloir supprimer le run!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Confirmer",
          closeOnConfirm: false
        },
        function(){
          document.getElementById("form-delete").submit()
        });

  });
</script>
@endpush
@if($run->exists)
  @include("partials.comment.create",["route"=>route("runs.comments.store",["run"=>$run])])
  @each("partials.comment.show",$run->comments,"comment")
@endif
