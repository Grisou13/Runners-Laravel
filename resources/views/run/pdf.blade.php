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
            @if((($i > 0 && $i % 5 == 0 && $run->runners_count < 3) && !$loop->last ) || $c >= 10)
                <div class="page-break"></div>
                @php
                    $c = $run->runners_count;
                    $i = 0;
                @endphp
            @endif
            @include("run/pdf-item",compact("run"))
        @endforeach
    </div>
@stop

@push("scripts")
<script>
    (function() {

        var beforePrint = function() {
            console.log('Functionality to run before printing.');
        };

        var afterPrint = function() {
            window.location = "http://"+window.location.hostname + "/runs"
        };

        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;

    }());
    window.print();
</script>
@endpush
