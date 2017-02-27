@extends('cms.layouts.cms')


@foreach($types as $key => $type)
	@if($typeTrue($type, 'create'))
		@include('cms.positions.create.'.((@$type['position']) ? $type['position'] : 'main'))
	@endif
@endforeach


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		@include('cms.partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index', ((@$fid) ? ['fid' => $fid] : [])) }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			<a class="" href="{{ route('cms.'.$slug.'.create', ((@$fid) ? ['fid' => $fid] : [])) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
		</div>
		
		{!! Form::open(['route' => 'cms.'.$slug.'.store', 'class' => 'form-horizontal']) !!}

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
			<button type="submit" class="btn btn-primary">{{ trans('cms.save') }}</button>

		{!! Form::close() !!}

	</div>

@stop