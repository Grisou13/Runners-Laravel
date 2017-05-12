<form action="{{ $route }}" method="post" class="form-horizontal">
    <label for="stat" class="col-md-4 control-label">Comments</label>
    <div class="col-md-6 col-md-offset-4">
        <div class="row">
            <div class="row col-md-12 form-group">
                <textarea class="form-control form-text-area" name="content"></textarea>
                @if ($errors->has('content'))
                    <span class="help-block">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                @endif
            </div>
            <div class="row col-md-12">
              <div class="form-group row col-md-12">
                <select name="user" class="form-control col-md-4" id="">
                    @foreach(Lib\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ auth()->check() && auth()->user()->id == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                    @endforeach
                </select>
              </div>
                @if ($errors->has('user'))
                    <span class="help-block">
                            <strong>{{ $errors->first('user') }}</strong>
                        </span>
                @endif
                <div class="row col-md-12 form-group">
                  <input type="submit" class="btn btn-default col-md-7" value="Ajouter un commentaire" />
                </div>
            </div>
            {{ csrf_field() }}
        </div>
    </div>
</form>
