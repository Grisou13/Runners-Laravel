<div id="run-{{$run->id}}" class="{{ $run->status }} run-container" style="width:100vw">
    <!-- Run name and people -->
    <div class="run container-fluid" style="width: 100vw">
        <div class="col-xs-2" style="min-height:200px;border-left: 2px solid black;margin-left: 26px;padding: 0;">
            <div class="text-center run-details">
                <div class="date">
                    {{ $run->planned_at ? $run->planned_at->format("d/m") : "" }} &nbsp;
                </div>
                <div class="title">
                    {{ $run->name }} &nbsp;
                </div>
                <div class="passengers">
                    {{ $run->nb_passenger ? $run->nb_passenger." personnes" : "" }} &nbsp;
                </div>
                <div class="notes">
                    {{ $run->note }} &nbsp;
                </div>
            </div>
        </div>
        <div class="col-xs-7" style="min-height:200px;border-left: 3px solid black;padding-left: 25px;width:500px">
            <div class="">
                <div class="row">
                    <ul class="waypoint-list">
                        @foreach($run->waypoints as $point)
                            <li class="waypoint">{{ $point->name }} {!! !$loop->last ? '<span class="glyphicon glyphicon-arrow-right" />' : '' !!}</li>
                            {{--@if($loop->index % 5 == 0 && $loop->index > 0)--}}
                                {{--<br />--}}
                            {{--@endif--}}
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <span class="time">{{ $run->planned_at ? $run->planned_at->format("h:i") : "" }}&nbsp;</span>
                </div>
            </div>


        </div>
        <div class="col-xs-3" style="margin-left:350px;min-height:200px; width: 200px">
            <div class="subscription">
                @foreach($run->runners as $sub)
                    <div class="sub row" style="border-left: 3px solid black">
                        <div class="col-xs-5 car" style="min-width: 100px; min-height: 50px;">
                            <span>{{ $sub->car_id ? $sub->car->name : ($sub->car_type_id ? $sub->car_type->name : "") }}&nbsp;</span>
                        </div>
                        <div class="col-xs-5 user" style="min-width: 100px; min-height: 50px;">
                            <span>{{ $sub->user_id ? $sub->user->name : "" }} &nbsp;</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>