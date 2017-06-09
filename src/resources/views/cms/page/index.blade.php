@extends((@$isAjax) ? 'cms.layouts.ajax' : 'cms.layouts.cms')


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		@include('cms.partials.header')

		<div class="subheader">
			@if($hasPermission('create'))
				<a class="" href="{{ route('cms.'.$slug.'.'.((@$createRoute) ? $createRoute : 'create')) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
			@endif

			{!! Form::text('q', Request::get('q'), ['id' => 'q', 'placeholder' => trans('cms.search'), 'data-href' => route('cms.'.$slug.'.index'), 'autocomplete' => 'off']) !!}
			<i class="fa fa-times" id="q-clear"></i>
			<div class="holder" id="q-button" data-href="{{ Request::url() }}">
				<i class="fa fa-search"></i>
			</div>
		</div>
		
		<table class="table table-striped">
			<thead>
				<tr>
					@foreach($types as $type => $values)
						@if($typeTrue($values, 'overview'))
							<th>
								<a data-href="{{ Request::url() }}">
									{{ $values['label'] }} {!! (Request::has('order') && Request::get('order') == $type) ? '<i class="fa fa-chevron-'.((Request::has('dir') && Request::get('dir') == 'asc') ? 'down' : 'up').'"></i>' : '' !!}
								</a>
							</th>
						@endif
					@endforeach
					<th>{{ trans('cms.options') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($datas as $data)
					<tr>
						@foreach($types as $key => $values)

							@if($typeTrue($values, 'overview'))
								{{-- Action by type --}}
								@if(@is_callable($values['alternativeValue']['index']))
									<td>{!! $values['alternativeValue']['index']($data, $key) !!}</td>
								@else
									@if(in_array($values['type'], ['select']))
										<td>{!! (is_array($values['values'])) ? $values['values'][$data->{$key}] : $model->{$values['values']}()[$data->{$key}] !!}</td>
									@else
										<td>{!! $data->{$key} !!}</td>
									@endif
								@endif
							@endif
							
						@endforeach
						<td class="model-options">
							@if(@$extraItemButtons)
								@foreach($extraItemButtons($data) as $extraButton)
									<a class="btn btn-{{ $extraButton['class'] }}" href="{{ $extraButton['route'] }}">{{ $extraButton['text'] }}</a>
								@endforeach
							@endif

							@if($hasPermission('edit'))
								<a class="btn btn-primary" href="{{ route('cms.'.$slug.'.edit', $data->id) }}"><i class="fa fa-pencil"></i></a>
							@endif
							@if($hasPermission('destroy'))
								<a class="btn btn-danger model-delete" href="{{ route('cms.'.$slug.'.destroy', $data->id) }}"><i class="fa fa-trash"></i></a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>

@stop