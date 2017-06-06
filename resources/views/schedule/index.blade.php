@extends("layouts.app")
@push("styles")
<link rel="stylesheet" href="{{ asset("css/jquery-ui.min.css")}}">
<link rel="stylesheet" href="{{ asset("css/jquery-ui-timepicker-addon.min.css")}}">
<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">
<link rel="stylesheet" href="{{ asset("/css/bootstrap-datetimepicker.min.css") }}">
@endpush
@push("scripts")
<script src="{{ asset("/js/moment.js") }}"></script>
<script src="{{ asset("/js/schedule.js") }}"></script>

<script src="{{ asset("js/jquery-ui.min.js")}}"></script>
<script src="{{ asset("js/jquery-ui-timepicker-addon.min.js")}}"></script>
<script src="{{ asset("js/jquery-ui-timepicker-fr.js")}}"></script>
<script src="{{ asset("js/bootstrap-datetimepicker.min.js")}}"></script>
@endpush

@section("content")
    <div id="loading">
        <img src="{{asset("images/icons/loading.gif")}}" alt="Loading" title="Loading" />
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='start_date_form'>
                            <input type='datetime' class="form-control" id="start_time" value="{{$start_time['value']}}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="form-control" id="end_time" value="{{$end_time['value']}}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-9">
                <div class="schedule-container noselect"></div>
            </div>
            {{--<div class="col-md-1"></div>--}}
        </div>
    </div>
    {{--<div class="groups"></div>--}}

@push("scripts")
<script>
    $(function () {

        $('#start_time').datetimepicker({
            viewMode: 'days',
            format: 'YYYY-MM-DD'
        }).on("dp.change", function(e){
            let url = window.Laravel.basePath + "/api/settings/start_date?token=root";
            let data = {"value": moment(e.date).format("YYYY-MM-DD")};
            ajaxRequest("PATCH", url, data, console.log);
            location.reload();
        })
        $('#end_time').datetimepicker({
            useCurrent: false,
            viewMode: 'days',
            format: 'YYYY-MM-DD'
        }).on("dp.change", function(e){
            let url = window.Laravel.basePath + "/api/settings/end_date?token=root";
            let data = {"value": moment(e.date).format("YYYY-MM-DD")};
            ajaxRequest("PATCH", url, data, console.log);
            location.reload();
        })
    });
    let start_time_input = document.getElementById("start_time");
    let end_time_input = document.getElementById("end_date");


</script>
@endpush

@endsection
