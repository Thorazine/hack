<?php
	$value = Builder::getPlainValue($model, (@$data[$key]) ? $data[$key] : @$type['default'], $data, $key);
	$values = json_decode($value);
?>
<div class="form-group value-label" id="value-label-{{ $key }}">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9">

		{!! Form::hidden(
			$key, 
			$value,
			['class' => 'input']
		) !!}

		<div class="add-block">
			<button type="button" class="btn btn-primary input-add">
				@lang('hack::cms.add') <i class="fa fa-plus"></i>
			</button>
		</div>
		<div class="input-block">
			@if(count($values))
				@foreach($values as $value => $label)
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control input-value" value="{{ $value }}" placeholder="Value">
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<input type="text" class="form-control input-label" value="{{ $label }}" placeholder="Label">
								<span class="input-group-btn">
									<button class="btn btn-danger input-delete" type="button">
										<i class="fa fa-times"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				@endforeach
			@endif
		</div>

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>

@section('script')
    @parent

	<script>
		valueLabel.init('#value-label-{{ $key }}');
	</script>
@stop