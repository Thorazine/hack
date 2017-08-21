<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">

		{!! Form::textarea(
			$key, 
			@$type['default'],
			[
				'class' => 'form-control', 
				'placeholder' => (@$type['placeholder']) ? $type['placeholder'] : $type['label'],
			]
		) !!}

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>