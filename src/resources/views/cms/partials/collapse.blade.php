<?php
	$subMenu = Cms::getSubMenu($menu['children']);
?>

<li data-toggle="collapse" data-target="#{{ str_slug($menu['label']) }}" class="collapsed @if(Cms::getMenu()) active @endif">
  	<a href="javascript:void(0)">
  		<i class="fa {{ $menu['icon'] }} fa-lg"></i> 
  		{{ trans($menu['label']) }} 
  		<span class="arrow"></span>
  	</a>
</li>

<ul class="sub-menu collapse @if(Cms::getMenu()) in @endif" id="{{ str_slug($menu['label']) }}">
	{!! $subMenu !!}
</ul>

<?php
	Cms::setMenuOpen(false);
	$subMenuOpen = false;
?>