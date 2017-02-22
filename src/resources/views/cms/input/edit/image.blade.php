@section((@$type['position']) ? $type['position'] : 'main')

	<div class="form-group">
		<label class="col-sm-3 control-label">
			{{ $type['label'] }}
		</label>
		<div class="col-sm-9 image gallery cropper" data-gallery-api="{{ route('cms.api.gallery.api') }}" data-upload-crop="{{ route('cms.api.gallery.crop') }}" data-upload-url="{{ route('cms.api.gallery.upload') }}" data-key="{{ $key }}" data-width="{{ $type['width'] }}" data-height="{{ $type['height'] }}">

			<button type="button" class="btn btn-primary" data-image-button data-open-gallery data-open-cropper @if(@$data[$key]) style="display: none" @endif>{{ trans('cms.add') }}</button>
			<div class="image-holder" data-image-image @if(! @$data[$key]) style="display: none" @endif>
				<img @if(@$data[$key]) src="{{ Builder::image($data[$key]) }}" @endif>
				<div class="delete">&times;</div>
			</div>

			{!! Form::hidden($key, '', ['class' => 'input-value']) !!}
			{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}

			@include('cms.input.module.cropper')
			@include('cms.input.module.gallery')

		</div>
	</div>

	@parent
@stop