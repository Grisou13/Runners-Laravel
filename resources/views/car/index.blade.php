@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ URL::to('car/create') }}">Create a Cars</a>
  </ul>
</nav>

<h1>All the Cars</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@include("partials.car.index",["cars"=>$cars])


@endsection
