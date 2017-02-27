@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9 aspect-ratio">

			<select class="ratio form-control">
				<option value="">Unlinked</option>
				
				@foreach(Builder::getArrayValue($model, $type, $type['values'], @$data, $key) as $value => $label)
					<option value="{{ $value }}" @if(@$type['default'] == $value) selected="selected" @endif >{{ $label }}</option>
				@endforeach

			</select>
			
		</div>
	</div>

	@parent
@stop