<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		{!! Form::select(
			$key, 
			Builder::getMenus(),
			@$data[$key], 
			[
				'class' => 'form-control', 
				'placeholder' => trans('cms.menu.placeholder'),
			]
		) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>