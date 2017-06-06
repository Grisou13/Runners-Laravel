<!--
User: Joel.DE-SOUSA
-->
@extends("layouts.app")

@push("styles")
<link rel="stylesheet" href="{{ asset("/css/user.css") }}">
@endpush

@section("content")
{{--<div class="row">--}}
{{--@include("partials.elements.padlock")--}}
{{--</div>--}}

@include("partials.user.edit")
@endsection
