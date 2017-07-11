<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9 image gallery cropper" data-gallery-api="{{ route('cms.api.gallery.api') }}" data-upload-crop="{{ route('cms.api.gallery.crop') }}" data-upload-url="{{ route('cms.api.gallery.upload') }}" data-key="{{ $key }}" data-width="{{ $type['width'] }}" data-height="{{ $type['height'] }}">

		<button type="button" class="btn btn-primary" data-image-button data-open-gallery data-open-cropper @if(@$data[$key]) style="display: none" @endif>{{ trans('hack::cms.add') }}</button>
		<div class="image-holder" data-image-image @if(! @$data[$key]) style="display: none" @endif>
			<img @if(@$data[$key]) src="{{ Builder::image($data[$key], false) }}" @endif>
			<div class="delete">&times;</div>
		</div>

		{!! Form::hidden($key, Builder::createValue($model, $type, $data, $key, 'edit', false), ['class' => 'input-value']) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}

		@include('hack::input.module.cropper')
		@include('hack::input.module.gallery')

	</div>
</div>
