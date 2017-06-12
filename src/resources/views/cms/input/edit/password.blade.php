<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">

		{!! Form::password(
			$key, 
			[
				'class' => 'form-control', 
				'placeholder' => (@$type['placeholder']) ? $type['placeholder'] : $type['label'],
				'autocomplete' => 'off',
			]
		) !!}

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label">
		
	</label>
	<div class="col-sm-9">

		{!! Form::password(
			$key.'_confirmation', 
			[
				'class' => 'form-control', 
				'placeholder' => (@$type['confirmation_placeholder']) ? $type['confirmation_placeholder'] : $type['confirmation_label'],
				'autocomplete' => 'off',
			]
		) !!}

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>