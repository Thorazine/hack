@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9">
			<div class="radio">
				@foreach(Builder::getArrayValue($model, $type['values'], $data, $key) as $option)
					<label>
						{!! Form::radio($key, $option[0], (@$data[$key] = $option[0]) ? true : (@$type['default'] == $option[0]) ? true : false) !!}
						{!! $option[1] !!}
					</label>
				@endforeach
			</div>

			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
			
		</div>
	</div>

	@parent
@stop