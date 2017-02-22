<div class="item" id="2345">
	<span>{{ $data->title }}</span>
	<div class="options">
		@if($hasPermission('edit'))
			<a class="btn btn-primary" href="{{ route('cms.'.$slug.'.edit', ['id' => $data->id, 'fid' => $fid]) }}"><i class="fa fa-pencil"></i></a>
		@endif
		@if($hasPermission('destroy'))
			<a class="btn btn-danger model-delete" href="{{ route('cms.'.$slug.'.destroy', ['id' => $data->id]) }}"><i class="fa fa-trash"></i></a>
		@endif
		{{-- <a class="btn btn-success" href="{{ route('cms.'.$slug.'.create', ['fid' => $data->id]) }}" title="{{ trans('cms.new') }}"><i class="fa fa-plus"></i></a> --}}
	</div>
</div>