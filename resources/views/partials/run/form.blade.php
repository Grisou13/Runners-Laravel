@if($run->exists)
    {!! Form::model($run,["route"=>["runs.update",$run],'class' => 'form-horizontal', 'method' => 'put']) !!}
@else
    {!! Form::model($run,["route"=>["runs.store"],'class' => 'form-horizontal']) !!}
@endif
{!! Form::token() !!}
@include("partials.run.fields",compact("run","waypoints","car_types"))
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary" {{ $run->exists?"disabled":"" }} name="" value="{{ $run->exists ? "Edit" : "Create" }} the run">
        </div>
        <div class="col-md-3 col-md-push-1">
            <a href="{{ route("runs.index") }}" class="btn btn-danger">Cancel</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
