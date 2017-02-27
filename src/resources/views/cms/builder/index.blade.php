@extends((@$isAjax) ? 'cms.layouts.ajax' : 'cms.layouts.cms')


@section('content')

	@include('cms.partials.menu')

	<div class="content model">

		@include('cms.partials.header')

		<div class="subheader">
			<a class="" href="{{ route('cms.templates.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			@if($hasPermission('create'))
				<a class="" href="{{ route((@$createRoute) ? $createRoute : 'cms.'.$slug.'.create', ['fid' => $fid]) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
			@endif
		</div>
		
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
					<th>Options</th>
				</tr>
			</thead>
			<tbody class="order" @if(@$hasOrder) data-order-url="{{ route('cms.'.$slug.'.order') }}" @endif>
				@include('cms.builder.ajax.index')
			</tbody>
		</table>

	</div>

@stop