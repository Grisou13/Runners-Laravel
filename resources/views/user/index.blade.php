<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
  <div class="row">
    <div class="col-md-11">
      <a href="{{ route("register") }}" class="btn btn-default navbar-btn" id="create-user">Crée un utilisateur</a>
      <a href="{{ route("users.create") }}" class="btn btn-default navbar-btn" id="create-user">Crée un chauffeur</a>
    </div>
    {{--@include("partials.elements.padlock")--}}
  </div>

  <h1>Tout les utilisateurs</h1>

  <form class="" action="{{ route("users.index") }}" method="get" >
    <select class="" name="status" onmousedown="this.value='';" onchange="this.form.submit()">
      <option value=" " {{ Request::has("status") && Request::get("status") == " " ? "selected" : "" }}>Tout</option>
      @foreach($status as $name => $display)

        <option value="{{ $name }}" {{ Request::has("status") && Request::get("status") == $name ? "selected" : "" }}>{{ $display }}</option>
      @endforeach
    </select>
  </form>
  @include("partials.user.index",["users"=>$users])

@endsection
