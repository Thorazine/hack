<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		@foreach(Builder::getArrayValue($model, $type, $type['values'], $data, $key) as $optionLabel => $optionValue)
			<div class="radio">
				<label>
					{!! Form::radio($key, $optionValue, (@$data[$key] == $optionValue) ? true : (@$type['default'] == $optionValue) ? true : false) !!}
					{!! $optionLabel !!}
				</label>
			</div>
		@endforeach
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>