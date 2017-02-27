@section((@$type['position']) ? $type['position'] : 'main')
	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9">
			{!! Form::select(
				$key, 
				Builder::getForms(),
				@$type['default'], 
				[
					'class' => 'form-control', 
					'placeholder' => trans('cms.form.placeholder'),
				]
			) !!}
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>

	@parent
@stop