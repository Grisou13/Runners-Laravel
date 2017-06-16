<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ route("users.index") }}">View All Users</a></li>
  </ul>
  <form method="get" action="{{ route("users.edit",$user) }}">
    <button type="submit" class="btn btn-success pull-right" id="padlock" onclick="enable()">
      Closed padlock
    </button>
  </form>
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
          <td>Status</td>
          <td>QR Code</td>
      </tr>
  </thead>
  <tbody>
@include("partials.user.show")
</tbody>
</table>

<div class="row">
    @if($user->profileImage() != null)
      <div class="col-xs-6 col-md-3">
          <div class="thumbnail">
            <a href="{{ url('images/' . $user->profileImage()->filename)}}" class="thumbnail">
              <img src="{{ url('images/' . $user->profileImage()->filename)}}" alt="facepicture">
            </a>
          </div>
      </div>
    @endif
    @if($user->licenseImage() != null)
      <div class="col-xs-6 col-md-3">
          <div class="thumbnail">

              <a href="{{ url('images/' . $user->licenseImage()->filename)}}" class="thumbnail">
                <img src="{{ url('images/' . $user->licenseImage()->filename)}}" alt="facepicture">
              </a>

          </div>
      </div>
    @endif
</div>
@endsection
