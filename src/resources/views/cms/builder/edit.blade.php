@extends('hack::layouts.cms')


@foreach($types as $key => $type)
	@if($typeTrue($type, 'edit'))
		@include('hack::positions.edit.'.((@$type['position']) ? $type['position'] : 'main'))
	@endif
@endforeach


@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<div class="line"></div>
			<div class="line middle"></div>
			<a class="" href="{{ route('cms.'.$slug.'.index', ['fid' => $fid]) }}"><i class="fa fa-arrow-left"></i> {{ trans('hack::cms.back') }}</a>
			<a class="" href="{{ route('cms.'.$slug.'.module', ['fid' => $fid]) }}"><i class="fa fa-plus"></i> {{ trans('hack::cms.new') }}</a>
		</div>

		{!! Form::open(['route' => ['cms.'.$slug.'.update', $id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('id', $id) !!}
			{!! Form::hidden('fid', $fid) !!}
			{!! Form::hidden('module_id', $data['id']) !!}

			<div class="row">
				<div class="col-sm-9" id="main">
					@yield('main')
				</div>
				<div class="col-sm-3" id="sidebar">
					@yield('sidebar')
				</div>
			</div>
			<button type="submit" class="btn btn-primary">{{ trans('hack::cms.save') }}</button>

		{!! Form::close() !!}

	</div>

@stop