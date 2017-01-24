@extends("layouts.app")

@section("content")
<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
      <li><a href="{{ URL::to('user') }}">View All Users</a></li>
  </ul>
  <form method="get" action="{{ url('user/'.$user->id.'/edit') }}">
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
  <div class="col-xs-6 col-md-3">
      <div class="thumbnail">
        <a href="{{ url('images/enhanced-buzz-10063-1384442301-0.jpg')}}" class="thumbnail">
          <img src="{{ url('images/enhanced-buzz-10063-1384442301-0.jpg')}}" alt="facepicture">
        </a>
      </div>
  </div>
  <div class="col-xs-6 col-md-3">
      <div class="thumbnail">
        <a href="{{ url('images/exemple-permis-conduire.png')}}" class="thumbnail">
          <img src="{{ url('images/exemple-permis-conduire.png')}}" alt="facepicture">
        </a>
      </div>
  </div>
</div>
@endsection
