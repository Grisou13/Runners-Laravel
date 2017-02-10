<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
  {{ Form::label($name, ucfirst($name), array('class' => 'col-md-4 control-label')) }}
  <div class="col-md-6">
      {{ Form::text($name, $value, array_merge(['class' => 'form-control',"disabled"], $attributes)) }}
  </div>
  @if ($errors->has($name))
      <span class="help-block">
          <strong>{{ $errors->first($name) }}</strong>
      </span>
  @endif
</div>
