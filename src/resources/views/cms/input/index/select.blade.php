<td>{!! 
	(is_array($values['values']))
	? @$values['values'][$data->{$key}] 
	: @$model->{$values['values']}()[$data->{$key}] 
!!}</td>