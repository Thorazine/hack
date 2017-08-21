<div class="grid-{{ $formField->width }}{{ $errors->first($formField->key, ' form-builder-error') }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">
		{!! Form::text($formField->key, $formField->default_value, [
			'class' => 'form-builder-time', 
			'id' => 'form-builder-'.$formField->field_type,
			'placeholder' => (($formField->placeholder) ? $formField->placeholder : $formField->label)
		]) !!}
		<p class="form-builder-error-text">{{ $errors->first($formField->key) }}</p>
	</div>
</div>