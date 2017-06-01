@foreach($datas as $data)
	<tr data-id="{{ $data->id }}">
		@if(@$hasOrder)
			<td><i class="fa fa-bars fa-2x handle"></i></td>
		@endif
		@foreach($types as $key => $values)

			@if($typeTrue($values, 'overview'))
				{{-- Action by type --}}
				@if(@is_callable($values['alternativeValue']['index']))
					<td>{!! $values['alternativeValue']['index']($data, $key) !!}</td>
				@else
					@if(in_array($values['type'], ['select', 'value-label']))
						<td>{!! (is_array($values['values'])) ? @$values['values'][$data->{$key}] : @$model->{$values['values']}()[$data->{$key}] !!}</td>
					@elseif(in_array($values['type'], ['checkbox']))
						@if($data->{$key} == 1)
							<td>{{ trans('cms.yes') }}</td>
						@else 
							<td>{{ trans('cms.no') }}</td>
						@endif
					@elseif(in_array($values['type'], ['timestamp']))
						@if($data->{$key})
							<td>{{ date('d-m-Y H:i:s', strtotime($data->{$key})) }}</td>
						@else
							<td></td>
						@endif
					@else
						<td>{!! $data->{$key} !!}</td>
					@endif
				@endif
			@endif

		@endforeach

		<td class="model-options">
			@if(@$extraItemButtons)
				@foreach($extraItemButtons($data) as $extraButton)
					<a class="btn btn-{{ $extraButton['class'] }}" href="{{ $extraButton['route'] }}">{!! $extraButton['text'] !!}</a>
				@endforeach
			@endif

			@if($hasPermission('edit'))
				<a class="btn btn-primary" href="{{ route('cms.'.$slug.'.edit', ['id' => $data->id]) }}"><i class="fa fa-pencil"></i></a>
			@endif
			@if($hasPermission('destroy'))
				<a class="btn btn-danger model-delete" href="{{ route('cms.'.$slug.'.destroy', ['id' => $data->id]) }}"><i class="fa fa-trash"></i></a>
			@endif
		</td>
	</tr>
@endforeach
