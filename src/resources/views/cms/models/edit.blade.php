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
			<a class="" href="{{ route('cms.'.$slug.'.index', ((@$fid) ? ['fid' => $fid] : [])) }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			@if($hasPermission('create'))
				<a class="" href="{{ route('cms.'.$slug.'.create', ((@$fid) ? ['fid' => $fid] : [])) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
			@endif
			@if(@$extraEditButtons)
				@foreach($extraEditButtons($data) as $extraButton)
					<a class="{{ $extraButton['class'] }}" href="{{ $extraButton['route'] }}">{!! $extraButton['text'] !!}</a>
				@endforeach
			@endif
		</div>

		{!! Form::open(['route' => ['cms.'.$slug.'.update', $id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('id', $id) !!}

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
			<button type="submit" class="btn btn-primary">{{ trans('cms.update') }}</button>

		{!! Form::close() !!}

	</div>

@stop