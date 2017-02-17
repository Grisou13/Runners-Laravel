@extends("layouts.app")
{{--@push("styles")--}}
{{--<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">--}}
{{--@endpush--}}
@push("scripts")
<script src="{{ asset("/js/moment.js") }}"></script>
<script src="{{ asset("/js/schedule.js") }}"></script>
@endpush

@section("content")
    <div class="grid"></div>
    <div class="groups"></div>
@endsection