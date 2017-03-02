@extends("layouts.app")

@section("content")
    @include("partials.run.show",compact("run"))
@stop
@push("scripts")
<script src="{{ asset("/js/run-searcher.js") }}"></script>
@endpush