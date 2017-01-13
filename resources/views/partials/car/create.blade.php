<form method="post" action="../car">
  <div class="form-group">
    <label for="license_plates">Plates licence </label>
    <input type="text" id="licence" name="license_plates">
  </div>

  <div class="form-group">
    <label for="brand">Brand </label>
    <input type="text" id="brand" name="brand">
  </div>

  <div class="form-group">
    <label for="model">Model </label>
    <input type="text" id="model" name="model">
  </div>

  <div class="form-group">
    <label for="color">Color </label>
    <input type="text" id="color" name="color">
  </div>

  <div class="form-group">
    <label for="seats">Seats </label>
    <input type="text" id="seats" name="seats">
  </div>

  <div class="form-group">
    <label for="shrtname">Short name </label>
    <input type="text" id="shrtname" name="shortname">
  </div>

  <div class="form-group">
    <label for="comment">Comment </label>
    <textarea id="comment" name="comment"></textarea>
  </div>

  <div class="form-group">
    <label for="type">Type </label>
    <select id="type" name="car_types_id">
      <option selected disabled>Sélectionnez un type...</option>
      @foreach($car_types as $car_type)
        <option value="{{ $car_type->id }}">{{ $car_type->type }}</option>
      @endforeach
    </select>
  </div>
  <input type="submit" class="btn btn-primary" value="Create the car">
  {{ csrf_field() }}
</form>
