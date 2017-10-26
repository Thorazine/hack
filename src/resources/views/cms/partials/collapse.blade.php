<?php
	$subMenu = Hack::getSubMenu($menu['children']);
?>

@if($subMenu)
	<li data-toggle="collapse" data-target="#{{ str_slug($menu['label']) }}" class="collapsed @if(Hack::getMenu()) active @endif">
	  	<a href="javascript:void(0)">
	  		<i class="fa {{ $menu['icon'] }} fa-lg"></i>
	  		{{ trans('hack::'.$menu['label']) }}
	  		<span class="arrow"></span>
	  	</a>
	</li>

	<ul class="sub-menu collapse @if(Hack::getMenu()) in @endif" id="{{ str_slug($menu['label']) }}">
		{!! $subMenu !!}
	</ul>

	<?php
		Hack::setMenuOpen(false);
		$subMenuOpen = false;
	?>
@endif
