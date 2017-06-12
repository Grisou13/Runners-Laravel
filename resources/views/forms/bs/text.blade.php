<div class="form-group {{ $required?"required":"" }} {{ $errors->has($old) ? ' has-error' : '' }}">
  {{ Form::label($name, ucfirst($name), array('class' => 'col-md-4 control-label')) }}
  <div class="col-md-6">
        {{ Form::text($old, old($old,$value), array_merge(['class' => 'form-control'], $attributes)) }}
  </div>
  @if ($errors->has($old))
      <span class="help-block">
          <strong>{{ $errors->first($old) }}</strong>
      </span>
  @endif
</div>
