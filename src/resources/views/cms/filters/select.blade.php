<div class="holder select">
	{{ Form::select($filterType, $filter['values'](), '', ['class' => 'model-filter', 'data-filter' => $filterType, 'id' => 'filter-'.$filterType]) }}
</div>