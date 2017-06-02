<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
{{--<nav class="navbar navbar-inverse">--}}
    {{--<ul class="nav navbar-nav">--}}
        {{--<li><a href="{{ route("users.index") }}">View All Users</a></li>--}}
    {{--</ul>--}}
    {{--<button type="button" class="btn btn-success pull-right closed" id="padlock" onclick="enable()">--}}
      {{--Closed padlock--}}
    {{--</button>--}}
{{--</nav>--}}
@include("partials.user.create")
@endsection
