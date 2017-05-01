@extends("layouts.app")
@push("styles")
<link rel="stylesheet" href="{{ asset("/css/schedule.css") }}">
@endpush
@push("scripts")
<script src="{{asset("js/underscore.min.js")}}"></script>
<script src="{{ asset("/js/kiela.js") }}"></script>
@endpush

@section("content")
    <div class="kiela">

    </div>
@endsection
