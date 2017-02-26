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
                    <ul>
                        <li><a href="{{ route("cars.index") }}">Véhicules</a></li>
                        <li><a href="{{ route("users.index") }}">Personnes</a></li>
                        <li><a href="{{ route("groups.index") }}">Groupes</a></li>
                        <li><a href="{{ route("schedule.index") }}">Horaires</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
