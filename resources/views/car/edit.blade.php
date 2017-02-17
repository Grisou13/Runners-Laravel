<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
<div class="row">
  <div class="col-md-1 pull-right">
    @include("partials.elements.padlock")
  </div>
</div>
@include("partials.car.edit",["mode"=>"edit","car"=>$car,"car_types"=>$car_types])
@endsection
