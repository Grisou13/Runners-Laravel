@extends("layouts.app")
@push("styles")
<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">
@endpush
@push("scripts")
<script src="{{ asset("/js/moment.js") }}"></script>
<script src="{{ asset("/js/schedule.js") }}"></script>
@endpush

@section("content")
    <div id="loading">
        <img src="{{asset("images/icons/loading.gif")}}" alt="Loading" title="Loading" />
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <div class="schedule-container noselect"></div>
            </div>
            {{--<div class="col-md-1"></div>--}}
        </div>
    </div>
    {{--<div class="groups"></div>--}}
@endsection
