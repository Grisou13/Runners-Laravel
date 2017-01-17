@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('car') }}">View All Car</a></li>
        <li><a href="{{ URL::to('car/create') }}">Create a Car</a>
    </ul>
</nav>

<h1>Edit {{ $car->name }}</h1>
@include("partials.car.edit")
@endsection
