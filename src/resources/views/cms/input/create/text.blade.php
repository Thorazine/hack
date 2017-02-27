<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">

		@if(@$type['prependLabel'] || @$type['appendLabel'] || method_exists($model, 'prepend'.ucfirst(camel_case($key)).'Label') || method_exists($model, 'append'.ucfirst(camel_case($key)).'Label'))
			<div class="input-group">
			@if(@$type['prependLabel'] || method_exists($model, 'prepend'.ucfirst(camel_case($key)).'Label'))
				<span class="input-group-addon">{!! (method_exists($model, 'prepend'.ucfirst(camel_case($key)).'Label')) ? $model->{'prepend'.ucfirst(camel_case($key)).'Label'}($data, $key) : $type['prependLabel'] !!}</span>
			@endif
		@endif

		{!! Form::text(
			$key, 
			@$type['default'], 
			[
				'class' => 'form-control', 
				'placeholder' => (@$type['placeholder']) ? $type['placeholder'] : $type['label'],
				'autocomplete' => 'off',
			]
		) !!}

		@if(@$type['prependLabel'] || @$type['appendLabel'] || method_exists($model, 'prepend'.ucfirst(camel_case($key)).'Label') || method_exists($model, 'append'.ucfirst(camel_case($key)).'Label'))
			@if(@$type['appendLabel'] || method_exists($model, 'append'.ucfirst(camel_case($key)).'Label'))
				<span class="input-group-addon">{!! (method_exists($model, 'append'.ucfirst(camel_case($key)).'Label')) ? $model->{'append'.ucfirst(camel_case($key)).'Label'}($data, $key) : $type['appendLabel'] !!}</span>
			@endif
			</div>
		@endif

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>