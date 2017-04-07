@extends("layouts.app-without-nav")

@push("scripts")
    <script src="{{ asset("/js/run-display.js") }}"></script>
@endpush

@section("content")
    <div id="run-display-app"></div>
@stop