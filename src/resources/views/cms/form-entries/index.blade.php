@extends((@$isAjax) ? 'cms.layouts.ajax' : 'cms.layouts.cms')


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		@include('cms.partials.header')

		<div class="subheader">

		</div>
		
		<table class="table table-striped">
			<thead>
				<tr>
					@foreach($formFields as $formField)
						@if($formField->overview)
							<th>{{ $formField->label }}</th>
						@endif
					@endforeach
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($datas as $formEntry)
					<tr data-id="{{ $formEntry->id }}">
						@foreach($formFields as $formField)
							@if($formField->overview)
								@foreach($formEntry->formValues as $formValue)
									@if($formValue->form_field_id == $formField->id)
										<td>{{ $formValue->value }}</td>
									@endif
								@endforeach
							@endif
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>

@stop