<form action="{{ $route }}" method="post" class="form-horizontal">
  <div class="form-group">
    <label for="stat" class="col-md-4 control-label">Commentaires</label>
            <div class="col-md-6">
                <textarea class="form-control form-text-area" name="content"></textarea>
                @if ($errors->has('content'))
                    <span class="help-block">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                @endif
            </div>
            {{ csrf_field() }}
  </div>
  <div class="form-group">
    <span class="col-md-4"></span>
    <div class="col-md-6">
        <div class="row col-md-6 form-group pull-right">
          <input type="submit" class="btn btn-primary col-md-7 form-control" value="Ajouter" />
        </div>
    </div>
  </div>
</form>
