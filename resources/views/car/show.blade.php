@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
    </ul>
  </nav>
    @include("partials.car.show",array(compact("car"), $delete = "show"))
@endsection
