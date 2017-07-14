@extends('hack::layouts.cms')



@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<div class="line"></div>
			<div class="line middle"></div>
			<a class="" href="{{ route('cms.templates.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('hack::cms.back') }}</a>
		</div>

		<div class="row">
			<div class="col-sm-9" id="main">
				<div class="form-group">
					<label class="col-sm-3 control-label">
						{{ trans('hack::modules.templates.module') }}
					</label>
					<div class="col-sm-9">
						@foreach(Builder::moduleValues() as $module => $label)
							<a class="btn btn-primary" style="width:100%; margin-bottom: 10px;" href="{{ route('cms.'.$slug.'.create', ['fid' => Request::get('fid'), 'module' => $module]) }}">
								{{ $label }}
							</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

@stop