@extends('cms.layouts.cms')


@foreach($types as $key => $type)
	@if($typeTrue($type, 'create'))
		@include('cms.input.create.'.$type['type'])
	@endif
@endforeach

@foreach($data['builders'] as $type)
	@include('cms.input.create.'.$type['type'], ['key' => $type['key'], 'builder' => $type])
@endforeach


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		@include('cms.partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			<a class="" href="{{ route('cms.'.$slug.'.module') }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
		</div>
		
		{!! Form::open(['route' => 'cms.'.$slug.'.store', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('template_id', Request::get('template_id')) !!}

			<div class="row">
				<div class="col-sm-9" id="main">
					@yield('main')
				</div>
				<div class="col-sm-3" id="sidebar">
					@yield('sidebar')
				</div>
			</div>
			<button type="submit" class="btn btn-primary">{{ trans('cms.save') }}</button>

		{!! Form::close() !!}

	</div>

@stop
