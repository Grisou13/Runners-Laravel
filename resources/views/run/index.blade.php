@extends("layouts.app")

@section("content")
    @each("partials.run.show",$runs,"run")
@stop
@push("scripts")
<script src="{{ asset("/js/typeahead.bundle.min.js") }}"></script>
<script src="{{ asset("/js/runs.js") }}"></script>
@endpush