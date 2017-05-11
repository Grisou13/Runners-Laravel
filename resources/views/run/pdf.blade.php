@extends("layouts.print")

@section("content")
    @foreach($runs as $run)
        @if($run->runners_count > 3 )
            <div class="page-break"></div>
            @include("partials.run.item",compact("run"))
            <div class="page-break"></div>
        @else
            @include("partials.run.item",compact("run"))
        @endif
        {{--Either we have already 5 runs on the page--}}
        {{--or we are almost at the end and of a page and the run has alot of subs (we need space--}}
        @if(($loop->index > 0 && $loop->index % 5 == 0) )
            <div class="page-break"></div>
        @endif
    @endforeach
@stop