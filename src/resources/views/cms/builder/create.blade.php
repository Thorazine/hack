@extends('cms.layouts.cms')


@foreach($types as $key => $type)
	@if($typeTrue($type, 'create'))
		@include('cms.input.create.'.$type['type'])
	@endif
@endforeach


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		@include('cms.partials.header')
		
		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index', ['fid' => $fid]) }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			@if($hasPermission('create'))
				<a class="" href="{{ route('cms.'.$slug.'.module', ['fid' => $fid]) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
			@endif
		</div>
		
		{!! Form::open(['route' => 'cms.'.$slug.'.store', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('fid', $fid) !!}
			{!! Form::hidden('module', $module) !!}

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