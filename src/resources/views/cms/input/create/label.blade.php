<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">
		{!! @$type['default'] !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>