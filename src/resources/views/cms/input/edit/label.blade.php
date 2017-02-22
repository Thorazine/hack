@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9" style="padding-top: 7px; padding-bottom: 7px;">
			{!! Builder::createValue($model, $type, $data, $key, 'edit', false) !!}
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>

	@parent
@stop