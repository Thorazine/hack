<?php

	$route = route($child['route']);
	$subMenuOpen = false;

	$inMenu = false;
	$possibilities = (@$child['route-matches'] && is_array($child['route-matches'])) ? $child['route-matches'] : [];
	array_push($possibilities, $route);

	foreach($possibilities as $possibility) {
		if(strpos(Request::url(), $possibility) !== false) {
			Hack::setMenuOpen(true);
			$subMenuOpen = true;
		}
	}
	// dd(Hack::hasPermission($child['route']));
?>
	<li @if(@$subMenuOpen) class="active" @endif>
	    <a @if(Request::url() == $route) href="javascript:void(0)" @else href="{{ $route }}" @endif>
	      	{{ trans('hack::'.$child['label']) }}
	    </a>
	</li>
