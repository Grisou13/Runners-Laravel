@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ route("cars.index") }}">View All Cars</a></li>
    </ul>
  </nav>
    @include("partials.car.show",array("car"=>$car, $delete = "show"))
@endsection
