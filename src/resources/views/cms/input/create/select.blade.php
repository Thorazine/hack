<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		{!! Form::select(
			$key, 
			Builder::getArrayValue($model, $type, $type['values'], $data, $key),
			@$type['default'], 
			[
				'class' => 'form-control', 
			]+((@$type['placeholder']) ? ['placeholder' => $type['placeholder']] : [])
		) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>