<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		<div class="checkbox">
			<label>
				{!! Form::hidden($key, 0) !!}
				{!! Form::checkbox(
					$key, 
					(@$type['value']) ? $type['value'] : 1, 
					(@$data[$key] == 1) ? ((@$type['value']) ? $type['value'] : 1) : false,
					[
						'class' => '', 
					]
				) !!}
				{{ $type['label'] }}
			</label>
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>
</div>