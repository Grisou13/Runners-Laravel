@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Cars</a></li>
        <li><a href="{{ URL::to('car/create') }}">Create a Car</a>
    </ul>
</nav>

@include("partials.car.edit")
@endsection
