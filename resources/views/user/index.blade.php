<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
  <div class="row">
    <div class="col-md-11">
      <a href="{{ route("register") }}" class="btn btn-default navbar-btn" id="create-user">Création d'un utilisateur</a>
      <a href="{{ route("users.create") }}" class="btn btn-default navbar-btn" id="create-user">Création d'un chauffeur</a>
    </div>
    {{--@include("partials.elements.padlock")--}}
  </div>

  <h1>Tout les utilisateurs</h1>

  @include("partials.user.index",["users"=>$users])

@endsection
