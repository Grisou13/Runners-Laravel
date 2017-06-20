@extends("layouts.app-without-nav")

@section("content")
    <div id="run-app" class="run-list"></div>
@stop
@push("scripts")
<script>
  window.forceDisplayMode = true
</script>
<script src="{{ asset("/js/runs.js") }}"></script>
@endpush
