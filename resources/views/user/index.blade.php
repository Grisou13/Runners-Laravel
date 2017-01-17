@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('user') }}">View All Users</a></li>
        <li><a href="{{ URL::to('user/create') }}">Create a User</a>
    </ul>
  </nav>

  <h1>All the Users</h1>

  <!-- will be used to show any messages -->
  @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  @include("partials.user.index",["users"=>$users])

@endsection
