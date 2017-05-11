<div id="run-{{$run->id}}" class="{{ $run->status }} run-container" style="width:100vw">
    <!-- Run name and people -->
    <div class="run">
        <div class="col-xs-2" style="height:100%;min-height:200px;border-left: 1px solid black;margin-left: 25px;padding: 0;">
            <div class="text-center run-details">
                <div class="date">
                    {{ $run->planned_at ? $run->planned_at->format("d/m") : "" }}
                </div>
                <div class="title">
                    {{ $run->name }}
                </div>
                <div class="passengers">
                    {{ $run->nb_passenger ? $run->nb_passenger." personnes" : "" }}
                </div>
                <div class="notes">
                    {{ $run->note }}
                </div>
            </div>
        </div>
        <div class="col-xs-6" style="height:100%; min-height:200px; border-left: 3px solid black;padding-left: 25px">
            <div class="">
                <div class="row">
                    <ul class="waypoint-list">
                        @foreach($run->waypoints as $point)
                            <li>{{ $point->name }} {!! !$loop->last ? '<span class="glyphicon glyphicon-arrow-right" />' : '' !!}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <span class="time">{{ $run->planned_at ? $run->planned_at->format("h:i") : "" }}</span>
                </div>
            </div>


        </div>
        <div class="col-xs-3" style="height:100%; min-height:200px; border-left: 3px solid black">
            <div class="subscription">
                @foreach($run->subscriptions as $sub)
                    <diw class="sub row">
                        <div class="col-xs-5 car ">
                            <span>{{ $sub->car_id ? $sub->car->name : ($sub->car_type_id ? $sub->car_type->name : "") }}&nbsp;</span>
                        </div>
                        <div class="col-xs-5 user " style="border-left: 3px solid black;">
                            <span>{{ $sub->user_id ? $sub->user->name : "" }}&nbsp;</span>
                        </div>
                    </diw>
                @endforeach
            </div>

        </div>
    </div>
</div>