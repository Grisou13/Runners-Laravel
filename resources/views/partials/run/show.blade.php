<div class="panel panel-default">
    <div class="panel-heading text-center">
      <div class="col-md-2">Nom</div>
      <div class="col-md-6">Parcours</div>
      <div class="col-md-2">Véhicules</div>
      <div class="col-md-2">Chauffeurs</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <!-- Run name and people -->
            <div class="col-md-2 text-center">
              {{ $run->name }}
              <div class="passengers">
                2 personnes
                {{ $run->nb_passengers }}
              </div>
            </div>
            <!-- Waypoint details -->
            <div class="col-md-6 text-center">
                <div class="col-md-2 text-left">09:30</div>
                <div class="row col-md-10">
                    @foreach($run->waypoints as $point)
                        <div class="col-md-3">
                            <p> {{ $point->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- @foreach($run->subscriptions as $sub) --}}
            <div class="col-md-2 text-center">
              <div class="col-md-6">VITO3</div>
              <div class="col-md-6">
                <button type="button" class="btn btn-primary searchable btn-run" name="button" data-searchable="cars">+ Véhicule</button>
                <button type="button" name="button" class="btn btn-primary searchable btn-run" data-searchable="car_types">+ Type Véhi.</button>
              </div>
            </div>
            <div class="col-md-2 text-center">
              <div class="col-md-6">
                MARCO
              </div>
              <div class="col-md-6">
                <button type="button" class="btn btn-primary searchable btn-run" name="button" data-searchable="users">+ Chauffeur</button>
              </div>
            </div>
            <div class="col-md-2 text-center">
              <!-- This is used only if users are assigned to runs
              but don't have any car type or car assigned,
              otherwise it will show up in the next loops -->

                {{-- $sub->user
                $sub->car_type
                $sub->car --}}


            </div>
            {{-- @endforeach --}}
        </div>
    </div>
</div>
