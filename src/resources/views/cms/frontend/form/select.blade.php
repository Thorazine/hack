<div class="grid-{{ $formField->width }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">
		{!! Form::select($formField->field_type, $formField->valuesAsArray(), $formField->default_value, [
			'class' => 'form-builder-text', 
			'id' => 'form-builder-'.$formField->field_type,
		]+(($formField->placeholder) ? ['placeholder' => $formField->field_type] : [])
		) !!}
		{!! $errors->first($formField->field_type, '<p class="form-builder-error">:message</p>') !!}
	</div>
</div>