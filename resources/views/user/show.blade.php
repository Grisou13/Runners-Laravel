@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ URL::to('user') }}">View All Users</a></li>
  </ul>
</nav>

<h1>{{$user->first_name . " " . $user->last_name}}</h1>
<table class="table table-striped table-bordered">
  <thead>
      <tr>
          <td>First name</td>
          <td>Last name</td>
          <td>Shortname</td>
          <td>Email</td>
          <td>Telephon number</td>
          <td>Sex</td>
      </tr>
  </thead>
  <tbody>
@include("partials.user.show")
</tbody>
</table>
@endsection
