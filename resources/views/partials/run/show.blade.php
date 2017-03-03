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
                        <div class="col-sm-{{ abs($run->waypoints_count / 2) }}">
                            <p> <span class="label label-default">{{ $point->pivot->order }}</span> {{ $point->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-2">
              <!-- This is used only if users are assigned to runs
              but don't have any car type or car assigned,
              otherwise it will show up in the next loops -->

            @if($run->runners->isEmpty() && $run->car_types->isEmpty() && $run->cars->isEmpty())
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" name="button" class="btn btn-primary searchable" data-searchable="car_types">Add car type</button>
                        <button type="button" name="button" class="btn btn-primary searchable" data-searchable="cars">Add car</button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-primary searchable" name="button" data-searchable="users">Add User</button>
                    </div>
                </div>


            @endif
              @foreach($run->runners as $runner)
                @if( $runner->pivot->car == null && $runner->pivot->car_type == null )
                  <div class="row">

                    <div class="col-xs-6">
                        @if(auth()->check())
                            <button type="button" name="button" class="btn btn-primary searchable" data-searchable="car_types">Add car type</button>
                            <button type="button" name="button" class="btn btn-primary searchable" data-searchable="cars">Add car</button>
                        @endif
                    </div>
                    <div class="col-xs-6">
                      {{ $runner->name }}
                    </div>
                  </div>

                @endif
              @endforeach
                @foreach($run->cars as $car)
                  <div class="row">
                    <div class="col-xs-6">
                      {{ $car->name }}
                    </div>
                    <div class="col-xs-6">
                    @if($car->pivot->user)
                      Going with user : {{ $car->pivot->user->name }}
                    @else
                        @if(auth()->check())
                            <button type="button" class="btn btn-primary searchable" name="button" data-searchable="users">Add User</button>
                        @endif
                    @endif
                    </div>
                  </div>
                @endforeach
                @foreach($run->car_types as $type)
                    <div class="row">
                      <div class="col-xs-6">
                        {{ $type->name }}
                      </div>
                      <div class="col-xs-6">
                      @if($type->pivot->user)
                        {{ $type->pivot->user->name }}
                      @else
                        @if(auth()->check())
                            <button type="button" class="btn btn-primary searchable" name="button" data-searchable="users">Add User</button>
                            <button type="button" class="btn btn-primary searchable" name="button" data-searchable="cars">Add Car</button>
                          @endif
                      @endif
                      </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

