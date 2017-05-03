@extends("layouts.app")

@push("styles")
<link rel="stylesheet" href="{{ asset("/css/run.css") }}">
@endpush

@section("content")
    <h1>Tous les runs</h1>
      <div class="filters">
        <div class="col-md-12">
          <div class="col-md-2">
            <select class="form-control input-filter">
              <option>artiste</option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="filter-race">
              <input type="text" value="08:00" class="form-control input-filter input-hour"/>
              et
              <input type="text" value="18:00" class="form-control input-filter input-hour"/>
              <select class="form-control input-filter">
                <option>Waypoint</option>
              </select>
            </div>
            <ul class="input-radio pull-right">
              <li><input type="radio" value="Urgence"/> Urgence</li>
              <li><input type="radio" value="Problème"/> Problème</li>
              <li><input type="radio" value="Similaires"/> Similaires</li>
            </ul>
          </div>
          <div class="col-md-2">
            <select class="form-control input-filter">
              <option>Véhicules</option>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control input-filter">
              <option>Chauffeurs</option>
            </select>
          </div>
        </div>
    </div>
    <div id="run-app" class="run-list"></div>
    {{--@include("partials.run.list",compact("runs"))--}}
@stop
@push("scripts")
<script src="{{ asset("/js/typeahead.bundle.min.js") }}"></script>
<script src="{{ asset("/js/runs.js") }}"></script>
@endpush
