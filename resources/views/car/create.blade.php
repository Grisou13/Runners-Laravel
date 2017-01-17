@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
  </ul>
</nav>

@include("partials.car.create",["car_types"=>$car_types])
@endsection
