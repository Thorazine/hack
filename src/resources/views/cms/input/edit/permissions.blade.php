@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9 labeled-multi-checkbox">

			@foreach(Cms::sites() as $site)
				<h3>{{ $site->title }}</h3>

				@foreach(Builder::getArrayValue($model, $type, $type['values'], @$data, $key) as $section => $rights)
					<h4>{{ trans('cms.module.'.$section) }}</h4>
					<div class="grid space-10 vspace-10" style="margin-bottom: 10px;">

						@foreach($rights as $right)
							<div class="grid-{{ (array_key_exists('grid', $type)) ? $type['grid'] : 2 }}">
								<label class="font-normal">
									{{ Form::checkbox($key.'[]', $site->id.'.cms.'.$section.'.'.$right, (in_array($site->id.'.cms.'.$section.'.'.$right, (@$data[$key]) ? $data[$key] : [])) ? true : false) }}
							    	{{ ucfirst($right) }}
								</label>
							</div>
						@endforeach

						<div class="grid-{{ (array_key_exists('grid', $type)) ? $type['grid'] : 2 }}">
							<a class="select-all">All</a> | <a class="select-none">None</a>
						</div>
						
					</div>
				@endforeach

			@endforeach

			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>

	@parent
@stop