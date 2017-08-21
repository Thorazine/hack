@if($data->{$key})
	<td>{{ date('d-m-Y H:i:s', strtotime($data->{$key})) }}</td>
@else
	<td></td>
@endif