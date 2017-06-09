<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
{{--<div class="row">--}}
  {{--<div class="col-md-11">--}}
    {{--<a href="{{ route("cars.create") }}" class="btn btn-default navbar-btn" id="create-user">Créer une voiture</a>--}}
  {{--</div>--}}
  {{--@include("partials.elements.padlock")--}}
{{--</div>--}}

<h1>Toutes les voitures</h1>

<!-- will be used to show any messages -->
@include("partials.car.index",["cars"=>$cars])


@endsection
