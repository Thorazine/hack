@extends('hack::layouts.cms')


@foreach($template['modules'] as $module)
	@include('hack::input.create.'.$module['type'], ['data' => $module+['key' => $module['refrence']]])
@endforeach


@section('content')

	@include('hack::partials.menu')
	
	<div class="content page model">

		@include('hack::partials.header')
		
		{!! Form::open(['route' => 'cms.page.store', 'class' => 'form-horizontal']) !!}

			{!! Form::hidden('template_id', old('template', Request::get('template'))) !!}
			
			<div class="row">
				<div class="col-sm-9">
					@yield('main')
				</div>
				<div class="col-sm-3">
					<div class="well form-vertical">
						@yield('sidebar')
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary pull-right">{{ trans('cms.save') }}</button>

		{!! Form::close() !!}
	</div>

@stop