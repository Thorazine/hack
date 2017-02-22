@extends('cms.layouts.cms')


@section('content')

	@include('cms.partials.menu')
	
	<div class="content model">

		<div class="subheader">
			<a class="" href="{{ route('cms.menus.index') }}"><i class="fa fa-arrow-left"></i> {{ trans('cms.back') }}</a>
			@if($hasPermission('create'))
				<a class="" href="{{ route((@$createRoute) ? $createRoute : 'cms.'.$slug.'.create', ['fid' => $fid]) }}"><i class="fa fa-plus"></i> {{ trans('cms.new') }}</a>
			@endif
		</div>

		<ol class="nested" data-max-levels="{{ @$datas[0]->menu->max_levels }}" data-order-url="{{ route('cms.'.$slug.'.order') }}">
			@foreach($datas as $index => $data)

				{!! $nested->before($index, $data, $datas) !!} 

				@include('cms.menu-item.item')

				{!! $nested->after($index, $data, $datas) !!} 

			@endforeach
		</ol>

	</div>

@stop



@section('script')

	<script>

		$(document).ready(function(){
			
	        $('.nested').nestedSortable({
	        	forcePlaceholderSize: true,
	        	helper: 'clone',
	            handle: 'div',
	            items: 'li',
	            toleranceElement: '> div',
	            // rootID: 'list_0',
	            maxLevels: $('.nested').data('max-levels'),
	            stop: function(event) {

	            	var data = {
	            		menu_items: $(this).nestedSortable('toArray'),
	            	};

	            	request($(this).data('order-url'), 'POST', data).then(function(response) {

	            	}, function(error) {

	            	});
		        },
	        });

	    });

	</script>

@stop