<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
<div class="row">
  <div class="col-md-11">
    <a href="{{ route("cars.create") }}" class="btn btn-default navbar-btn disabled" id="create-user">Create a car</a>
  </div>
  <div class="col-md-1">
    <button type="button" class="btn btn-success pull-right closed" id="padlock" onclick="enable()">
      Open padlock
    </button>
  </div>
</div>

<h1>All the Cars</h1>

<!-- will be used to show any messages -->
@include("partials.car.index",["cars"=>$cars])


@endsection
