
<div class="menu menu-vertical">
    <div class="brand">{{ Cms::site()->title }}</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">

        	@foreach(config('menu') as $menu)

        		@if(@$menu['route'])

        			<?php
        				$route = route($menu['route']);
        			?>

	                <li @if(strpos(Request::url(), $route) !== false) class="active" @endif>
		                <a @if(Request::url() == $route) href="javascript:void(0)" @else href="{{ $route }}" @endif>
		                  	<i class="fa {{ $menu['icon'] }} fa-lg"></i> 
		                  	{{ trans($menu['label']) }}
		                </a>
	                </li>

        		@elseif(@$menu['children'])
        			@include('cms.partials.collapse')
        		@endif

        	@endforeach
        </ul>
    </div>

    <div class="quick">
        <a href="{{ route('cms.auth.destroy') }}">
            <i class="fa fa-power-off fa-2x"></i>
        </a>
        <a href="{{ route('cms.auth.show') }}">
            <i class="fa fa-lock fa-2x"></i>
        </a>
        <a href="{{ route('cms.panel.index') }}">
            <i class="fa fa-gear fa-2x"></i>
        </a>
    </div>
</div>