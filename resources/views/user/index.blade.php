@extends("layouts.app")

@section("content")
  <nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
    </ul>
  </nav>

  <h1>All the Users</h1>

  <!-- will be used to show any messages -->
  @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif

  <form class="" action="{{ route("user.index") }}" method="get">
    <select class="" name="status" onmousedown="this.value='';" onchange="this.form.submit()">
      <option value=" " {{ Request::has("status") && Request::get("status") == " " ? "selected" : "" }}>All</option>
      @foreach($status as $s)
        <option value="{{ $s }}" {{ Request::has("status") && Request::get("status") == $s ? "selected" : "" }}>{{ $s }}</option>
      @endforeach
    </select>
  </form>
  @include("partials.user.index",["users"=>$users])

@endsection
