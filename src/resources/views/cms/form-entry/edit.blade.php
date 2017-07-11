@extends('hack::layouts.cms')

@foreach($formFields as $formField)
	<?php $found = false; ?>
	@foreach($data->formValues as $formValue)
		@if($formValue->form_field_id == $formField->id)
			<?php $found = true; ?>
			@include('hack::positions.edit.main', [
				'position' => 'main', 
				'key' => $formField->key, 
				'value' => $formValue->value,
				'data' => [$formField->key => $formValue->value],
				'type' => [
					'type' => $formField->field_type,
					'label' => $formField->label,
					'values' => (in_array($formField->field_type, ['select', 'radio'])) ? $formField->valuesAsArray() : $formField->values,
				]
			])
		@endif
	@endforeach 
	@if(! $found)
		@include('hack::positions.edit.main', [
			'position' => 'main', 
			'key' => $formField->key, 
			'value' => '',
			'data' => [$formField->key => ''],
			'type' => [
				'type' => $formField->field_type,
				'label' => $formField->label,
				'values' => (in_array($formField->field_type, ['select', 'radio'])) ? $formField->valuesAsArray() : $formField->values,
			]
		])
	@endif
@endforeach


@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index', ['fid' => $fid]) }}"><i class="fa fa-arrow-left"></i> {{ trans('hack::cms.back') }}</a>
		</div>
		
		{!! Form::open(['route' => ['cms.'.$slug.'.update', $id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('id', $data['id']) !!}

			@if(@$fid)
				{!! Form::hidden('fid', $fid) !!}
			@endif

			<div class="row">
				<div class="col-sm-9" id="main">
					@yield('main')
				</div>
				<div class="col-sm-3" id="sidebar">
					@yield('sidebar')
				</div>
			</div>
			<button type="submit" class="btn btn-primary">{{ trans('hack::cms.update') }}</button>

		{!! Form::close() !!}

	</div>

@stop