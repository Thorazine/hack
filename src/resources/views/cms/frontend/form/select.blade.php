<div class="grid-{{ $formField->width }}{{ $errors->first($formField->key, ' form-builder-error') }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">
		<div class="select">
			{!! Form::select($formField->key, $formField->valuesAsArray(), $formField->default_value, [
				'class' => 'form-builder-select', 
				'id' => 'form-builder-'.$formField->field_type,
			]+(($formField->placeholder) ? ['placeholder' => $formField->placeholder] : [])
			) !!}
		</div>
		<p class="form-builder-error-text">{{ $errors->first($formField->key) }}</p>
	</div>
</div>