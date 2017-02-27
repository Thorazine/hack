@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9">
			<div class='input-group date' id='timestampModule_{{ $key }}'>
				{!! Form::text(
					$key, 
					Builder::createValue($model, $type, $data, $key, 'edit', false), 
					[
						'class' => 'form-control', 
						'placeholder' => (@$type['placeholder']) ? $type['placeholder'] : $type['label'],
						'autocomplete' => 'off',
					]
				) !!}
				<span class="input-group-addon">
	                <span class="glyphicon glyphicon-calendar"></span>
	            </span>
	        </div>
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
		</div>
	</div>

	@parent
@stop



@section('script')
    @parent

    <script type="text/javascript">
        $(function () {
        	timestampStartModule('#timestampModule_{{ $key }}');
        });
    </script>
@stop