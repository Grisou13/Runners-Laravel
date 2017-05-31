
<div class="tg-wrap">
    <table class="tg run-table" autosize="1" style="overflow: wrap;width:100%">
        @php
        $count = $run->runners_count >= 4 ? $run->runners_count : 4;
        $runners = $run->runners->all();
        @endphp
        @foreach(collect(range(0,$count-1)) as $row)
            @php
            $sub = array_key_exists($row,$runners) ? $runners[$row] : (object) ["car_id"=>false,"car_type_id"=>false,"user_id"=>false,"exists"=>false];
            $car = $sub->car_id ? $sub->car->name : ($sub->car_type_id ? $sub->car_type->name : null );
            $user = $sub->user_id ? $sub->user->name : null;
            @endphp
            @if($row == 0)
                <tr>
                    <td class="tg-baqh" rowspan="{{ $count }}" colspan="0" style="width: 1%;max-width: 10px" text-rotate="90">{{ $run->planned_at ? $run->planned_at->format("d/m") : "" }}&nbsp;</td>
                    <td class="tg-baqh" colspan="2" rowspan="2" style="width:29%">{{ $run->name }}</td>
                    <td class="tg-baqh" colspan="2" rowspan="3" style="width:30%">
                            @php
                            $icon = base64_encode(file_get_contents(public_path("images/icons/next.png")));
                            $type = pathinfo(public_path("images/icons/next.png"), PATHINFO_EXTENSION);
                            @endphp
                            @foreach($run->waypoints as $p)
                                <span>{{ $p->name }}
                                    @if(!$loop->last)
                                        {{--<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ3Ny4xNzUgNDc3LjE3NSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDc3LjE3NSA0NzcuMTc1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCI+CjxnPgoJPHBhdGggZD0iTTM2MC43MzEsMjI5LjA3NWwtMjI1LjEtMjI1LjFjLTUuMy01LjMtMTMuOC01LjMtMTkuMSwwcy01LjMsMTMuOCwwLDE5LjFsMjE1LjUsMjE1LjVsLTIxNS41LDIxNS41ICAgYy01LjMsNS4zLTUuMywxMy44LDAsMTkuMWMyLjYsMi42LDYuMSw0LDkuNSw0YzMuNCwwLDYuOS0xLjMsOS41LTRsMjI1LjEtMjI1LjFDMzY1LjkzMSwyNDIuODc1LDM2NS45MzEsMjM0LjI3NSwzNjAuNzMxLDIyOS4wNzV6ICAgIiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />--}}
                                        <img src="data:image/{{  $type }};base64,{!! $icon !!}" alt="->" width="12">
                                    @endif

                                </span>
                            @endforeach

                    </td>

                    <td class="tg-baqh" style="width:20%;">{{ $car }}&nbsp;</td>
                    <td class="tg-baqh" style="width:20%;">{{ $user }}&nbsp;</td>
                </tr>
            @elseif($row == 1)
                <tr>
                    {{--<td colspan="2" style="width:60%;border: 1px;"></td>--}}
                    <td class="tg-baqh" style="width:50%">{{ $car }}&nbsp;</td>
                    <td class="tg-baqh" style="width:50%">{{ $user }}&nbsp;</td>
                </tr>

            @elseif($row == 2)
                <tr>
                    <td class="tg-yw4l people" colspan="2" style="width:60%">{{ $run->nb_passenger }} personnes</td>
                    <td class="tg-baqh" style="width:20%;">{{ $car }}&nbsp;</td>
                    <td class="tg-baqh" style="width:20%;">{{ $user }}&nbsp;</td>
                </tr>
            @elseif($row == 3)
                <tr>
                    <td class="tg-yw4l note" colspan="2" style="width:30%;">{{ $run->note }}</td>
                    <td class="tg-yw4l time" colspan="2" style="width:30%;">{{ $run->planned_at ? $run->planned_at->format("h:i") : "" }}</td>
                    <td class="tg-baqh" style="width:20%;min-width:20%">{{ $car }}&nbsp;</td>
                    <td class="tg-baqh" style="width:20%;">{{ $user }}&nbsp;</td>
                </tr>
            @else
                <tr>
                    <td colspan="4" style="width:60%;border: 1px;"></td>
                    <td class="tg-baqh" class="car" style="width:20%;">{{ $car }}&nbsp;</td>
                    <td class="tg-baqh" class="user" style="width:20%;">{{ $user }}&nbsp;</td>
                </tr>
            @endif
        @endforeach

    </table></div>