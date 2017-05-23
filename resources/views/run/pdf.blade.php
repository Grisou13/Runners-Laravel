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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="{{ asset("/js/html2canvas.js") }}"></script>

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
    function genPDF()
    {
        html2canvas(document.body,{
            onrendered:function(canvas){

                var img=canvas.toDataURL("image/png");
                var doc = new jsPDF({orientation: 'landscape', format: "a3", unit: "pt"})
                doc.addImage(img,'JPEG',-20,0);
                doc.save("test.pdf")
            }

        });

    }
//    var pdf = new jsPDF({orientation: 'landscape', format: "a3", unit: "pt"})
//    pdf.fromHTML(document.body.innerHTML)
//    pdf.autoPrint()
//    pdf.output("dataurlnewwindow")
    window.print();
</script>
@endpush
