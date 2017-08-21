<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">

		@if(@$type['prependLabel'] || @$type['appendLabel'])
			<div class="input-group">
			@if(@$type['prependLabel'])
				<span class="input-group-addon" id="basic-addon1">{!! (is_callable($type['prependLabel'])) ? $type['prependLabel']($data, $key) : $type['prependLabel'] !!}</span>
			@endif
		@endif

		{!! Form::number(
			$key, 
			@$type['default'], 
			[
				'class' => 'form-control', 
				'placeholder' => (@$type['placeholder']) ? $type['placeholder'] : $type['label'],
				'autocomplete' => 'off',
			]+
			((@$type['min']) ? ['min' => $type['min']] : []),
			((@$type['max']) ? ['max' => $type['max']] : [])
		) !!}

		@if(@$type['prependLabel'] || @$type['appendLabel'])
			@if(@$type['appendLabel'])
				<span class="input-group-addon" id="basic-addon1">{!! (is_callable($type['appendLabel'])) ? $type['appendLabel']($data, $key) : $type['appendLabel'] !!}</span>
			@endif
			</div>
		@endif

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>