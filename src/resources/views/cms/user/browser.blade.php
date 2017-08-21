@if(strpos($browser, 'firefox') !== false)
	<i class="fa fa-firefox"></i>
@elseif(strpos($browser, 'chrome') !== false)
	<i class="fa fa-chrome"></i>
@elseif(strpos($browser, 'safari') !== false)
	<i class="fa fa-safari"></i>
@elseif(strpos($browser, 'explorer') !== false)
	<i class="fa fa-internet-explorer"></i>
@elseif(strpos($browser, 'edge') !== false)
	<i class="fa fa-internet-explorer"></i>
@elseif(strpos($browser, 'opera') !== false)
	<i class="fa fa-opera"></i>
@else
	<i class="fa fa-globe"></i>
@endif