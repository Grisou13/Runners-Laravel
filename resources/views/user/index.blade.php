@extends("layouts.app")

@section("content")
  <div class="row">
    <div class="col-md-11">
      <a href="{{ route("register") }}" class="btn btn-default navbar-btn disabled" id="create-user">Create a user</a>
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-success pull-right closed" id="padlock" onclick="enable()">
        Open padlock
      </button>
    </div>
  </div>

  <h1>All the Users</h1>

  <form class="" action="{{ route("users.index") }}" method="get">
    <select class="" name="status" onmousedown="this.value='';" onchange="this.form.submit()">
      <option value=" " {{ Request::has("status") && Request::get("status") == " " ? "selected" : "" }}>All</option>
      @foreach($status as $s)
        @if($s == "")
          @continue
        @endif
        <option value="{{ $s }}" {{ Request::has("status") && Request::get("status") == $s ? "selected" : "" }}>{{ $s }}</option>
      @endforeach
    </select>
  </form>
  @include("partials.user.index",["users"=>$users])

@endsection
