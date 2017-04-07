<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
@include("partials.run.form",["mode"=>"create", "car_types"=>$car_types, "waypoints"=>$waypoints])
@endsection
