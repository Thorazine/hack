<div class="item @if(!$data->active) inactive @endif">
	<span class="url">{{ $data }}</span>
	<span class="title">{{ $data->title }}</span>
	<div class="options">
		@if($hasPermission('edit'))
			<a class="btn btn-primary btn-xs" href="{{ route('cms.'.$slug.'.edit', ['id' => $data->id, 'fid' => $fid]) }}"><i class="fa fa-pencil"></i></a>
		@endif
		@if($hasPermission('destroy'))
			<a class="btn btn-danger btn-xs model-delete" href="{{ route('cms.'.$slug.'.destroy', ['id' => $data->id]) }}"><i class="fa fa-trash"></i></a>
		@endif
		{{-- <a class="btn btn-success" href="{{ route('cms.'.$slug.'.create', ['fid' => $data->id]) }}" title="{{ trans('hack::cms.new') }}"><i class="fa fa-plus"></i></a> --}}
	</div>
</div>