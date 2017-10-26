<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9 labeled-multi-checkbox">

		@foreach(Hack::sites() as $site)
			<h3>{{ ucfirst($site->title) }}</h3>

			@foreach(Builder::getArrayValue($model, $type, $type['values'], @$data, $key) as $section => $rights)

				<hr>
				<h4>{{ trans('hack::cms.module.'.$section) }}</h4>

				<div class="grid space-10 vspace-10" style="margin-bottom: 10px;">

					<span class="pull-right">
						<a class="select-all">All</a> | <a class="select-none">None</a>
					</span>

					@foreach($rights as $right)
						<div class="grid-{{ (array_key_exists('grid', $type)) ? $type['grid'] : 2 }}">
							<label class="font-normal">
								{{ Form::checkbox($key.'[]', $site->id.'.cms.'.$section.'.'.$right, (in_array('cms.'.$section.'.'.$right, (@$data[$key]) ? $data[$key] : [])) ? true : false) }}
						    	{{ ucfirst($right) }}
							</label>
						</div>
					@endforeach

				</div>
			@endforeach

		@endforeach

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>
