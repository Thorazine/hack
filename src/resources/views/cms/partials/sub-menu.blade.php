<?php
	$route = route($child['route']);
	$subMenuOpen = false;

	if(strpos(Request::url(), $route) !== false) {
		Cms::setMenuOpen(true);
		$subMenuOpen = true;
	}
	
?>
<li @if(@$subMenuOpen) class="active" @endif>
    <a @if(Request::url() == $route) href="javascript:void(0)" @else href="{{ $route }}" @endif>
      	{{ trans($child['label']) }}
    </a>
</li>