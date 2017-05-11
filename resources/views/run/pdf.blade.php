@extends("layouts.print")

@section("content")
    <div class="display">
        @php
            $c = 0;
            $i = 0;
        @endphp
        @foreach($runs as $run)
            @php
                $c += $run->runners_count;
                $i++;
            @endphp

            {{--Either we have already 5 runs on the page--}}
            {{--or we are almost at the end and of a page and the run has alot of subs (we need space--}}
            @if((($i > 0 && $i % 5 == 0 && $run->runners_count > 3) && !$loop->last ) || $c >= 18)
                <div class="page-break"></div>
                @php
                    $c = 0;
                    $i = 0;
                @endphp
            @endif
            @include("partials.run.item",compact("run"))
        @endforeach
    </div>
@stop