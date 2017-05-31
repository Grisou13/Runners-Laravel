
<div class="tg-wrap">
    <table class="tg run-table">
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
                <td class="tg-yw4l date" rowspan="{{ $count }}" style="padding-top: 30px; padding-bottom:auto; width: 30px;" text-rotate="-90"><span class="vertical-text">{{ $run->planned_at ? $run->planned_at->format("d/m") : "" }}</span></td>
                <td class="tg-yw4l title" colspan="2" rowspan="2" style="border:0;border-top:1px solid black;padding-bottom:0">{{ $run->name }}</td>
                <td class="tg-yw4l waypoints" colspan="2" rowspan="3" style="boorder: 0; border-left: 1px solid black; border-right: 1px solid black;">
                    <ul>
                        @foreach($run->waypoints as $p)
                            <li>{{ $p->name }} {!! !$loop->last ? '<span class="glyphicon glyphicon-arrow-right" ></span>': '' !!}</li>
                        @endforeach
                    </ul>
                </td>

                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-left:1px solid black":"" }}">{{ $car }}&nbsp;</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-right:1px solid black":"" }}">{{ $user }}&nbsp;</td>
            </tr>

            @elseif($row == 1)
            <tr>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-left:1px solid black":"" }}">{{ $car }}</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-right:1px solid black":"" }}">{{ $user }}&nbsp;</td>
            </tr>

            @elseif($row == 2)
            <tr>
                <td class="tg-yw4l people" colspan="2" style="border:0">{{ $run->nb_passenger }} personnes</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-left:1px solid black":"" }}">{{ $car }}&nbsp;</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-right:1px solid black":"" }}">{{ $user }}&nbsp;</td>            </tr>

            @elseif($row == 3)
            <tr>
                <td class="tg-yw4l note" colspan="2" style="border:0; border-bottom: 1px solid black;">{{ $run->note }}</td>
                <td class="tg-yw4l time" colspan="2" style="border:0; border-left: 1px solid black; border-bottom: 1px solid black;">{{ $run->planned_at ? $run->planned_at->format("i:m") : "" }}</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-left:1px solid black":"" }}">{{ $car }}&nbsp;</td>
                <td class="tg-baqh" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-right:1px solid black":"" }}">{{ $user }}&nbsp;</td>            </tr>
            @else
                    <tr>
                        <td colspan="4" style="border: 0px;"></td>
                        <td class="tg-baqh" class="car" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-left:1px solid black":"" }}">{{ $car }}&nbsp;</td>
                        <td class="tg-baqh" class="user" style="{{ !($car)&&!($user)&&!$sub->exists?"border:0;border-right:1px solid black":"" }}">{{ $user }}&nbsp;</td>                    </tr>
            @endif
        @endforeach

    </table></div>