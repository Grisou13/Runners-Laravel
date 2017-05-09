@extends("layouts.app")

@section("content")
    @include("partials.run.form",compact("run","waypoints","car_types"))
    <div class="row col-md-push-4 col-md-2">
        @include("partials.run.delete",compact("run"))
    </div>
@stop