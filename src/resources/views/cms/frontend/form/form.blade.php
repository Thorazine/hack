{!! Form::open(['route' => 'form-builder.store', 'method' => 'post', 'class' => 'form-builder grid space-10 vspace-10']) !!}

	@foreach($form->formFields as $formField)

		@if(View::exists($page->site_id.'.form.'.$formField->field_type))
			@include($page->site_id.'.form.'.$formField->field_type)
		@else
			@include('cms.frontend.form.'.$formField->field_type)
		@endif

	@endforeach

	<button type="submit">Submit</button>


{!! Form::close() !!}