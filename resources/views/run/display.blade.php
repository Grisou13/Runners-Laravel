@extends("layouts.app-without-nav")

@section("content")
    <div id="run-app" class="run-list"></div>
@stop
@push("scripts")

<script src="{{ asset("/js/runs.js") }}"></script>
@endpush
