<div class="panel panel-default">
    <div class="panel-heading">
        {{ $run->name }}
    </div>
    <div class="panel-body">
        <div class="row">
            <!-- Run name and people -->
            <div class="col-md-2">
                <div class="row col-xs-12">
                    {{ $run->name }}
                </div>
                <div class="row col-xs-12">
                    {{ $run->nb_passengers }}
                </div>
            </div>
            <!-- Waypoint details -->
            <div class="col-md-8">
                <div class="row">
                    @foreach($run->waypoints as $point)
                        <div class="col-md-1">
                            <p>{{ $point->name }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="row"></div>
            </div>
            <div class="col-md-2">
                @if($run->cars()->count())
                    @foreach($run->cars as $car)

                        @if($car->pivot->user_id != null)

                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
