<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@section("content")
<div class="row">
  <div class="col-md-1 pull-right">
    <button type="button" class="btn btn-success pull-right closed" id="padlock" onclick="enable()">
      Open padlock
    </button>
  </div>
</div>

@include("partials.user.edit")
@endsection
