<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $data['label'] }}
	</label>
	<div class="col-sm-9">
		{!! Form::text(
			$data['key'], 
			@$data['default'], 
			[
				'class' => 'form-control', 
				'placeholder' => (@$data['placeholder']) ? $data['placeholder'] : $data['label'],
				'autocomplete' => 'off',
			]
		) !!}
		{!! $errors->first($data['key'], '<p class="text-danger">:message</p>') !!}
	</div>
</div>