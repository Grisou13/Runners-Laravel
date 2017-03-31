@extends("layouts.app-without-nav")

@push("scripts")
    <script src="{{ asset("/js/run-app.js") }}"></script>
@endpush

@section("content")
    <div id="run-app"></div>
@stop