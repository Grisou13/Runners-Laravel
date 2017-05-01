@extends("layouts.app")
@push("styles")
<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">
<link rel="stylesheet" href="{{ asset("/js/tiny-slider/tiny-slider.css") }}">
@endpush
@push("scripts")
<script src="{{asset("/js/underscore.min.js")}}"></script>
<script src="{{asset("/js/tiny-slider/tiny-slider.js")}}"></script>
<script src="{{ asset("/js/kiela.js") }}"></script>
@endpush

@section("content")
    <div class="kiela" id="kiela">
    </div>
    <div class="slider">
    </div>
@endsection
