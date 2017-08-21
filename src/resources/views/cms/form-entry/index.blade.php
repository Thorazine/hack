@extends((@$isAjax) ? 'hack::layouts.ajax' : 'hack::layouts.cms')


@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.forms.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('hack::cms.back') }}</a>
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
					<tr>
						@foreach($formFields as $formField)
							@if($formField->overview)
								<?php $found = false; ?>
								@foreach($formEntry->formValues as $formValue)
									@if($formValue->form_field_id == $formField->id)
										<td>{{ $formValue->value }}</td>
										<?php $found = true; ?>
									@endif
								@endforeach
								@if(! $found)
									<td></td>
								@endif
							@endif
						@endforeach
						<td class="model-options">
							<a class="btn btn-primary" href="{{ route('cms.'.$slug.'.edit', ['id' => $formEntry->id, 'fid' => $fid]) }}"><i class="fa fa-pencil"></i></a>
							<a class="btn btn-danger model-delete" href="{{ route('cms.'.$slug.'.destroy', ['id' => $formEntry->id]) }}"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>

@stop