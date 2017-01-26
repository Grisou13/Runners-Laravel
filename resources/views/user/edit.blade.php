@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ route("users.index") }}">View All Users</a></li>
    </ul>
</nav>
@include("partials.user.edit")
@endsection
