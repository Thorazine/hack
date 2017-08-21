@extends((@$isAjax) ? 'hack::layouts.ajax' : 'hack::layouts.cms')


@section('content')

	@include('hack::partials.menu')

	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">
			<div class="line"></div>
			<div class="line middle"></div>
			<a class="" href="{{ route('cms.templates.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('hack::cms.back') }}</a>
			@if($hasPermission('create'))
				<a class="" href="{{ route((@$createRoute) ? $createRoute : 'cms.'.$slug.'.create', ['fid' => $fid]) }}"><i class="fa fa-plus"></i> {{ trans('hack::cms.new') }}</a>
			@endif
		</div>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						@if(@$hasOrder)
							<th></th>
						@endif

						@foreach($types as $type => $values)
							@if($typeTrue($values, 'overview'))
								<th>{{ $values['label'] }}</th>
							@endif
						@endforeach
						<th>{{ trans('hack::cms.options') }}</th>
					</tr>
				</thead>
				<tbody class="order" @if(@$hasOrder) data-order-url="{{ route('cms.'.$slug.'.order') }}" @endif>
					@include('hack::builder.ajax.index')
				</tbody>
			</table>
		</div>

	</div>

@stop