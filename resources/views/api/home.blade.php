@extends("layouts.app")

@section("content")
  <div id="swagger-ui"></div>
@stop

@push("scripts")
<script src="{{ asset("/js/api.js") }}"></script>
@endpush
@push("styles")
<style>
  .topbar{
    display: none
  }
</style>
@endpush