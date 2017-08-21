@if($data->{$key} == 1)
	<td>{{ trans('hack::cms.yes') }}</td>
@else 
	<td>{{ trans('hack::cms.no') }}</td>
@endif