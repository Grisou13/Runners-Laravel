@extends("layouts.app")

@section("content")
    @include("partials.run.form",compact("run","waypoints","car_types"))
@stop