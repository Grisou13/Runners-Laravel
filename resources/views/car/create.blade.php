<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
@include("partials.car.edit",["mode"=>"create","car"=>$car,"car_types"=>$car_types])
@endsection
