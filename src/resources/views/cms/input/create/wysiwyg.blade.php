<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9 wysiwyg">
		{!! Form::textarea(
			$key, 
			@$type['default'], 
			[
				'class' => 'wysiwyg', 
				'id' => 'wysiwygModule_'.$key
			]
		) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}
	</div>
</div>


@section('script')
    @parent

	<script>
		wysiwygStartModule('#wysiwygModule_{{ $key }}', '{{ $type['configuration'] }}');
	</script>
@stop