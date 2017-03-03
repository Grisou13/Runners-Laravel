@extends("layouts.app")
{{--@push("styles")--}}
{{--<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">--}}
{{--@endpush--}}
@push("scripts")
<script src="{{ asset("/js/moment.js") }}"></script>
<script src="{{ asset("/js/schedule.js") }}"></script>
@endpush

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-lg-12">
                <div class="schedule-container"></div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    {{--<div class="groups"></div>--}}
@endsection
