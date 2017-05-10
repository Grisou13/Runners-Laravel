@extends("layouts.app-without-nav")

@section("content")
    @include("partials.run.list",compact("runs"))
@stop