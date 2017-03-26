<div class="grid-{{ $formField->width }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">
		{!! Form::text($formField->field_type, $formField->default_value, [
			'class' => 'form-builder-text', 
			'id' => 'form-builder-'.$formField->field_type,
			'placeholder' => $formField->label
		]) !!}
		{!! $errors->first($formField->field_type, '<p class="form-builder-error">:message</p>') !!}
	</div>
</div>