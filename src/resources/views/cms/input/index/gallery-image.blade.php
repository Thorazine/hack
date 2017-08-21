@if($data->fullname)
	<td>
		<img src="{{ Storage::disk(config('filesystems.default'))->url('thumbnail/'.$data->fullname) }}">
	</td>
@else
	<td></td>
@endif