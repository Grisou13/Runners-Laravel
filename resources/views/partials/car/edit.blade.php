<form method="post" action="../{{$car->id}}">
  <input type="hidden" name="_method" value="put">
  <div class="form-group">
    <label for="license_plates">Plates licence </label>
    <input type="text" id="licence" name="license_plates" value="{{ $car->license_plates }}">
  </div>

  <div class="form-group">
    <label for="brand">Brand </label>
    <input type="text" id="brand" name="brand" value="{{ $car->brand }}">
  </div>

  <div class="form-group">
    <label for="model">Model </label>
    <input type="text" id="model" name="model" value="{{ $car->model }}">
  </div>

  <div class="form-group">
    <label for="color">Color </label>
    <input type="text" id="color" name="color" value="{{ $car->color }}">
  </div>

  <div class="form-group">
    <label for="seats">Seats </label>
    <input type="text" id="seats" name="seats" value="{{ $car->seats }}">
  </div>

  <div class="form-group">
    <label for="shrtname">Short name </label>
    <input type="text" id="shrtname" name="shortname" value="{{ $car->shortname }}">
  </div>

  <div class="form-group">
    <label for="comment">Comment </label>
    <textarea id="comment" name="comment">{{ $car->comment }}</textarea>
  </div>

  <div class="form-group">
    <label for="type">Type </label>
    <select id="type" name="car_types_id">
      <option disabled>Sélectionnez un type...</option>
      @foreach($car_types as $car_type)
        @if($car->car_types_id == $car_type->id)
          <option selected value="{{ $car_type->id }}">{{ $car_type->type }}</option>
        @else
          <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
        @endif
      @endforeach
    </select>
  </div>
  <input type="submit" class="btn btn-primary" value="Edit the car">
  {{ csrf_field() }}
</form>
