@extends('hack::layouts.cms')


@foreach($types as $key => $type)
	@if($typeTrue($type, 'edit'))
		@include('hack::positions.edit.'.((@$type['position']) ? $type['position'] : 'main'))
	@endif
@endforeach

@foreach($data['builders'] as $type)
	@include('hack::positions.edit.'.((@$type['position']) ? $type['position'] : 'main'), ['key' => $type['key'], 'builder' => $type, 'data' => [$type['key'] => $type['value']]])
@endforeach


@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			<a class="" href="{{ route('cms.'.$slug.'.module') }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
		</div>
		
		{!! Form::open(['route' => ['cms.'.$slug.'.update', $id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('id', $data['id']) !!}

			<div class="row">
				<div class="col-sm-9" id="main">
					@yield('main')
				</div>
				<div class="col-sm-3" id="sidebar">
					@yield('sidebar')
				</div>
			</div>
			<button type="submit" class="btn btn-primary">{{ trans('cms.update') }}</button>

		{!! Form::close() !!}

	</div>

@stop