@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li style="display : none" id="create-car"><a href="{{ route("cars.create") }}">Create a Cars</a>
  </ul>
  <button type="button" class="btn btn-success pull-right" id="padlock" onclick="enable()">
    Closed padlock
  </button>
</nav>

<h1>All the Cars</h1>

<!-- will be used to show any messages -->
@include("partials.car.index",["cars"=>$cars])


@endsection
