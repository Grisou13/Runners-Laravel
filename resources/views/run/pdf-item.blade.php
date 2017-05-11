@extends("layouts.print")

@section("content")

    <div  style="height: 200px; width:100vw">
        @include("partials.run.item",compact("run"))
    </div>

@stop