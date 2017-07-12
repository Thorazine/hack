@extends((@$isAjax) ? 'hack::layouts.ajax' : 'hack::layouts.cms')


@section('content')

	@include('hack::partials.menu')
	
	<div class="content model">

		@include('hack::partials.header')

		<div class="subheader">

			@if(@$extraHeaderButtons)
				@foreach($extraHeaderButtons($datas) as $extraButton)
					<a class="{{ $extraButton['class'] }}" href="{{ $extraButton['route'] }}" title="{{ @$extraButton['title'] }}">{!! $extraButton['text'] !!}</a>
				@endforeach
			@endif

			@if($hasPermission('create'))
				<a class="" href="{{ route((@$createRoute) ? $createRoute : 'cms.'.$slug.'.create', (@$fid) ? ['fid' => $fid] : []) }}"><i class="fa fa-plus"></i> {{ trans('hack::cms.new') }}</a>
			@endif

			{!! Form::text('q', Request::get('q'), ['id' => 'q', 'placeholder' => trans('hack::cms.search'), 'data-href' => route('cms.'.$slug.'.index'), 'autocomplete' => 'off']) !!}
			<i class="fa fa-times" id="q-clear"></i>
			<div class="holder" id="q-button" data-href="{{ Request::url() }}">
				<i class="fa fa-search"></i>
			</div>

			@if(@$filters) 
				@foreach($filters as $filterType => $filter)
					@include('hack::filters.'.$filter['type'])
				@endforeach
			@endif
		</div>
		
		<div class="table-responsive">
			<table class="table table-striped" id="data-header" data-href="{{ route('cms.'.$slug.'.index') }}">
				<thead>
					<tr>
						@if(@$hasOrder)
							<th data-column="drag_order"></th>
						@endif
						
						@foreach($types as $type => $values)
							@if($typeTrue($values, 'overview'))
								<th>
									@if(in_array($type, $searchFields))
										<a data-order="{{ $type }}" data-dir="{{ (Request::get('order') == $type) ? ((Request::get('dir') == 'asc') ? 'desc' : 'asc') : 'asc' }}">
											{{ $values['label'] }} {!! (Request::get('order') == $type) ? '<i class="fa fa-chevron-'.((Request::get('dir') == 'asc') ? 'down' : 'up').'"></i>' : '' !!}
										</a>
									@else
										{{ $values['label'] }}
									@endif
								</th>
							@endif
						@endforeach
						<th>{{ trans('hack::cms.options') }}</th>
					</tr>
				</thead>
				<tbody class="order" id="dataset" @if(@$hasOrder) data-order-url="{{ route('cms.'.$slug.'.order') }}" @endif>

					@include('hack::models.ajax.index')

				</tbody>
			</table>
		</div>

		<div class="paginate paginate-bottom">
			@if(method_exists($datas, 'render'))
				{!! @$datas->render() !!}
			@endif
		</div>
	</div>

@stop
