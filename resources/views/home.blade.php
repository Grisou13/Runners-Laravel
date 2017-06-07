<!--
    User: Joel.DE-SOUSA
-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    {{--<ul>--}}
                        {{--<li><a href="{{ route("cars.index") }}">Véhicules</a></li>--}}
                        {{--<li><a href="{{ route("users.index") }}">Personnes</a></li>--}}
                        {{--<li><a href="{{ route("groups.index") }}">Groupes</a></li>--}}
                        {{--<li><a href="{{ route("register") }}">Créer un nouvel utilisateur</a></li>--}}
                        {{--<li><a href="{{ route("users.create") }}">Créer un nouveau chauffeur</a></li>--}}
                        {{--<li><a href="{{ route("schedule.index") }}">Horaires</a></li>--}}
                        {{--<li><a href="{{ route("runs.index") }}">Courses</a></li>--}}
                        {{--<li><a href="{{ route("kiela.index") }}">Kiéla</a></li>--}}
                    {{--</ul>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid home">
    <div class="row">
        <a href="{{ route("users.index") }}" class="col-xs-6 btn btn-warning">
            <span>Personnes</span>
        </a>
        <a href="{{ route("runs.index") }}" class="col-xs-6 btn btn-default">
            <span>Courses</span>
        </a>
    </div>
    <div class="row">
        <a href="{{ route("schedule.index") }}" class="col-xs-6 btn btn-success"><span>Horaires/span></a>
        <a href="{{ route("kiela.index") }}" class="col-xs-6 btn btn-info" ><span>Kiéla</span></a>
    </div>
</div>
@endsection
