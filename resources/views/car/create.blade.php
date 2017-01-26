<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ route("cars.index") }}">View All Cars</a></li>
  </ul>
</nav>

@include("partials.car.edit",["mode"=>"create","car"=>$car,"car_types"=>$car_types])
@endsection
