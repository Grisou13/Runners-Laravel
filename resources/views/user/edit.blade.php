@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('user') }}">View All Users</a></li>
    </ul>
</nav>
@include("partials.user.edit")
@endsection
