@extends('1.layouts.default')



@section('css')
	@include('1.example.partials.css')
@stop



@section('content')
<div id="content">
	<div class="block menu">
		<div class="container narrow">
			<ul class="menu">
				@foreach($page->main_menu->menuItems as $menuItem) 
					<li>
						<a {!! $menuItem->currentHtml('class="active"') !!} href="{{ $menuItem }}">{!! $menuItem->title !!}</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	
	<div class="block light">
		<div class="container narrow">
			<h2>{{ $page->title }}</h2>
				
			<div class="wysiwyg">
				{!! $page->body !!}
			</div>
		</div>
	</div>

	@include('1.example.partials.footer')
</div>	

@stop


@section('script')

@stop