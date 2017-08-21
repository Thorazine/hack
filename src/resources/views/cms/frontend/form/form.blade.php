@if(session('thank'))
	<div class="wysiwyg">
		{!! session('thank') !!}
	</div>
@else
	{!! Form::open(['route' => 'form-builder.store', 'method' => 'post', 'class' => 'form-builder grid space-10 vspace-10']) !!}
		
		@if($errors->count())
			<div class="grid-12">
				<div class="alert alert-danger">
					<ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
				</div>
			</div>
		@endif

		{!! Form::hidden('id', $form->id) !!}

		@foreach($form->formFields as $formField)

			@if(View::exists($page->site_id.'.form.'.$formField->field_type))
				@include($page->site_id.'.form.'.$formField->field_type)
			@else
				@include('hack::frontend.form.'.$formField->field_type)
			@endif

		@endforeach

		@if(View::exists($page->site_id.'.form.button'))
			@include($page->site_id.'.form.button')
		@else
			@include('hack::frontend.form.button')
		@endif

	{!! Form::close() !!}
@endif