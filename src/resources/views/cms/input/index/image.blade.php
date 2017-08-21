@if($data->gallery)
	<td>
		<img src="{{ Storage::disk(config('filesystems.default'))->url('cropped/thumbnail/'.$data->gallery->fullname) }}">
	</td>
@else
	<td>{{ $data->{$key} }}</td>
@endif