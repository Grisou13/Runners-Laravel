<form method="post" action="../{{$user->id}}">
  <input type="hidden" name="_method" value="put">
  <div class="form-group">
    <label for="first_name">First name </label>
    <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}">
  </div>

  <div class="form-group">
    <label for="last_name">Last name </label>
    <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}">
  </div>

  <div class="form-group">
    <label for="shortname">Shortname </label>
    <input type="text" id="shortname" name="shortname" value="{{ $user->shortname }}">
  </div>

  <div class="form-group">
    <label for="email">Email </label>
    <input type="text" id="email" name="email" value="{{ $user->email }}">
  </div>

  <div class="form-group">
    <label for="phone">Telephone number </label>
    <input type="text" id="phone" name="phone" value="{{ $user->phone }}">
  </div>

  <div class="form-group">
    <label for="sex">Short name </label>
    <select id="sex" name="sex">
      @if($user->sex == 0)
        <option selected value="0">Female</option>
        <option value="1">Male</option>
      @else
      <option value="0">Female</option>
      <option selected value="1">Male</option>
      @endif
    </select>
  </div>

  <div class="form-group">
    <label for="qr_code">QR code </label>
    <input type="text" id="qr_code" name="qr_code" value="{{ $user->qr_code }}">
  </div>

  <input type="submit" class="btn btn-primary" value="Edit the car">
  {{ csrf_field() }}
</form>
