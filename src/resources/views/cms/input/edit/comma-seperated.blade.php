<?php
	$value = Builder::createValue($model, $type, $data, $key, 'edit', false);
	$values = explode(',', $value);
?>
<div class="form-group comma-seperated" id="comma-seperated-{{ $key }}">
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
				@foreach($values as $value)
					<div class="input-group">
						<input type="text" class="form-control input-value" value="{{ $value }}" placeholder="">
						<span class="input-group-btn">
							<button class="btn btn-danger input-delete" type="button">
								<i class="fa fa-times"></i>
							</button>
						</span>
					</div>
				@endforeach
			@else
				<div class="input-group">
					<input type="text" class="form-control input-value" value="" placeholder="">
					<span class="input-group-btn">
						<button class="btn btn-danger input-delete" type="button">
							<i class="fa fa-times"></i>
						</button>
					</span>
				</div>
			@endif
		</div>

		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>

@section('script')
    @parent

	<script>
		commaSeperated.init('#comma-seperated-{{ $key }}');
	</script>
@stop