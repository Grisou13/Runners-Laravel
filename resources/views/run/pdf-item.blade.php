
<div class="tg-wrap">
    <table  autosize="1" style="width:98%;border: solid 1px black;border-spacing: 0;border-collapse: collapse">
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
                    <td class="" style="width: 20px;padding-left:5px" text-rotate="90">{{ $run->planned_at ? $run->planned_at->format("d/m") : "" }}&nbsp;</td>
                    <td class="" colspan="2"  style="padding-left: 5px;border-left: 1px solid black">{{ $run->name }}&nbsp;</td>
                    <td class="" colspan="2"  style="">
                            
                            @foreach($run->waypoints as $p)
                                <span>{{ $p->name }}
                                    @if(!$loop->last)
                                        {!! $next !!}
                                    @endif
                                </span>
                            @endforeach
                    </td>

                    <td class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $car }}&nbsp;</td>
                    <td class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $user }}&nbsp;</td>
                </tr>
            @elseif($row == 1)
                <tr>
                    {{--<td colspan="2" style=";border: 1px;"></td>--}}
                    <td class="" colspan="1" style="width: 20px">&nbsp;</td>
                    <td class="" colspan="2" style="border-left: 1px solid black">&nbsp;</td>
                    <td class="" colspan="2" style="">&nbsp;</td>
                    <td class="" colspan="1" style="width: 150px;border-left: 1px solid black">{{ $car }}&nbsp;</td>
                    <td class="" colspan="1" style="width: 150px;border-left: 1px solid black">{{ $user }}&nbsp;</td>
                </tr>

            @elseif($row == 2)
                <tr>
                    <td class="" colspan="1" style="width: 20px">&nbsp;</td>
                    <td class="" colspan="2" style="padding-left: 5px;border-left: 1px solid black">{{ $run->nb_passenger }} personnes</td>
                    <td class="" colspan="2" style=""></td>
                    <td class="" style="width: 100px;border-left: 1px solid black;text-align:center">{{ $car }}&nbsp;</td>
                    <td class="" style="width: 100px;border-left: 1px solid black;text-align:center">{{ $user }}&nbsp;</td>
                </tr>
            @elseif($row == 3)
                <tr>
                    <td class="" colspan="1" style="width: 20px">&nbsp;</td>
                    <td class="" colspan="2" style="padding-left: 5px;border-left: 1px solid black">{{ $run->note }}</td>
                    <td class="" colspan="2" style="">{{ $run->planned_at ? $run->planned_at->format("h:i") : "" }}</td>
                    <td class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $car }}&nbsp;</td>
                    <td class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $user }}&nbsp;</td>
                </tr>
            @else
                <tr>
                    <td class="" colspan="1" style="width: 20px">&nbsp;</td>
                    <td class="" colspan="4" style="border-left: 1px solid black">&nbsp;</td>
                    <td class="" class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $car }}&nbsp;</td>
                    <td class="" class="" style="width: 150px;border-left: 1px solid black;text-align:center">{{ $user }}&nbsp;</td>
                </tr>
            @endif
        @endforeach

    </table></div>
