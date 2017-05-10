<div id="run-{{$run->id}}" class="{{ $run->status }} run-container">
    <!-- Run name and people -->
    <div class="run">
        <div class="col-md-3 col-xs-3 col-sm-4">
            <div class="text-center run-details">
                <div class="date">
                    {{ $run->planned_at->format("d/m") }}
                </div>
                <div class="title">
                    {{ $run->name }}
                </div>
                <div class="passengers">
                    {{ $run->nb_passenger }} personnes
                </div>
                <div class="notes">
                    {{ $run->note }}
                </div>
            </div>

        </div>
        <div class="col-md-5 col-xs-5 col-sm-5">
            <div class="container">
                <div class="row">
                    <ul class="waypoint-list">
                        @foreach($run->waypoints as $point)
                            <li>{{ $point->name }} {!! !$loop->last ? '<span class="glyphicon glyphicon-arrow-right" />' : '' !!}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <span class="time">{{ $run->planned_at->format("h:i") }}</span>
                </div>
            </div>


        </div>
        <div class="col-md-4 col-xs-3 col-sm-3">
            <div class="subscription">
                @foreach($run->subscriptions as $sub)
                    <diw class="row sub">
                        <div class="col-md-6 col-xs-6 car">
                            <span>{{ $sub->car_id ? $sub->car->name : ($sub->car_type_id ? $sub->car_type->name : "") }}&nbsp;</span>
                        </div>
                        <div class="col-md-6 col-xs-6 col-xs-push-6 user">
                            <span>{{ $sub->user_id ? $sub->user->name : "" }}&nbsp;</span>
                        </div>
                    </diw>
                @endforeach
            </div>

        </div>
    </div>
</div>