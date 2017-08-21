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

	<div class="block medium">
		<div class="container narrow">
			<div class="search">
				{!! Form::open(['url' => Request::url(), 'method' => 'GET']) !!}
					{!! Form::text('q', Request::get('q'), ['class' => 'search-box']) !!}
					<button type="submit" class="search-button">Search</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	@if($page->search)
		<div class="block light">
			<div class="container narrow">
			@foreach($page->search as $search)
				<div class="search-result">
					<a href="{{ $search->url }}">{{ $search->title }}</a><br>
					{{ $search->body }}<br>
				</div>
			@endforeach
			</div>
		</div>
	@endif

	@include('1.example.partials.footer')
</div>
@stop