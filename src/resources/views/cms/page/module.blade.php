@extends('hack::layouts.cms')



@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.'.$slug.'.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
		</div>
	
		<div class="row">
			<div class="col-sm-9" id="main">
				<div class="form-group">
					<label class="col-sm-3 control-label">
						{{ trans('modules.templates.template') }}
					</label>
					<div class="col-sm-9">
						<?php $templates = Builder::templates(); ?>
						@if($templates)
							@foreach($templates as $templateId => $label)
								<a class="btn btn-primary" style="width:100%; margin-bottom: 10px;" href="{{ route('cms.'.$slug.'.create', ['fid' => Request::get('fid'), 'template_id' => $templateId]) }}">
									{{ $label }}
								</a>
							@endforeach
						@else
							<p>{{ trans('cms.no_records') }}</p>
						@endif
					</div>
				</div>
			</div>
		</div>


	</div>

@stop