<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		{!! Form::select(
			$key, 
			Builder::getCarousels(),
			@$type['default'], 
			[
				'class' => 'form-control', 
				'placeholder' => trans('hack::cms.carousel.placeholder'),
			]
		) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>