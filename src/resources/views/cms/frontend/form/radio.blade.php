<div class="grid-{{ $formField->width }}{{ $errors->first($formField->key, ' form-builder-error') }}">
	<label class="form-builder-label">
		{{ $formField->label }}
	</label>
	<div class="form-builder-col">

		@foreach($formField->valuesAsArray() as $radioLabel => $radioValue)
			<label class="radio-label">
				{!! Form::radio($formField->key, $radioValue, ($formField->default_value == $radioValue) ? true : false, [
					'class' => 'form-builder-radio', 
					'placeholder' => (($formField->placeholder) ? $formField->placeholder : $formField->label)
				]) !!}
				<span class="radio-label-text">{!! $radioLabel !!}</span>
			</label>
			
		@endforeach

		<p class="form-builder-error-text">{{ $errors->first($formField->key) }}</p>

	</div>
</div>