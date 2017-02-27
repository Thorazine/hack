<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9" style="padding-top: 7px; padding-bottom: 7px;">
		{!! (is_array($type['values'])) ? $type['values'][$data[$key]] : $model->{$type['values']}()[$data[$key]] !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>