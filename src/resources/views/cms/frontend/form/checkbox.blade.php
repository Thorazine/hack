<div class="grid-{{ $formField->width }}{{ $errors->first($formField->key, ' form-builder-error') }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">
		{!! Form::checkbox($formField->key, $formField->values, $formField->default_value, [
			'class' => 'form-builder-checkbox', 
			'id' => 'form-builder-'.$formField->field_type,
		]) !!}
		<p class="form-builder-error-text">{{ $errors->first($formField->key) }}</p>
	</div>
</div>