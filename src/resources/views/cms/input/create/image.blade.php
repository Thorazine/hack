<div class="form-group">
	<label class="col-sm-3 control-label">
		{{ $type['label'] }}
	</label>
	<div class="col-sm-9 image gallery cropper" data-gallery-api="{{ route('cms.api.gallery.api') }}" data-remove-api="{{ route('cms.api.gallery.destroy') }}" data-upload-crop="{{ route('cms.api.gallery.crop') }}" data-upload-url="{{ route('cms.api.gallery.upload') }}" data-key="{{ $key }}" data-width="{{ $type['width'] }}" data-height="{{ $type['height'] }}">

		<button type="button" class="btn btn-primary" data-image-button data-open-gallery data-open-cropper @if(@$data[$key]) style="display: none" @endif>{{ trans('hack::cms.add') }}</button>
		<div class="image-holder" data-image-image @if(! @$data[$key]) style="display: none" @endif>
			<img src="">
			<div class="delete">&times;</div>

			<div class="input-group extra">
				<span class="input-group-addon" id="basic-addon1">Title</span>
				{{ Form::text($key.'---title', @$image->title, ['class' => 'form-control', 'placeholder' => $type['label'].' title', 'id' => $key.'---title', 'data-image-title', 'autocomplete' => 'off']) }}
			</div>
		</div>

		{!! Form::hidden($key, '', ['class' => 'input-value']) !!}
		{!! $errors->first($key, '<p class="text-danger">:message</p>') !!}

		@include('hack::input.module.cropper')
		@include('hack::input.module.gallery')

	</div>
</div>