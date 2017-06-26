@extends('1.layouts.default')



@section('css')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('theme/css/theme.css') }}">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
@stop



@section('content')
	
	<div class="block menu">
		<div class="container small">
			<ul class="menu">
				@foreach($page->main_menu->menuItems as $menuItem) 
					<li>
						<a {!! $menuItem->activeHtml('class="active"') !!} href="{{ $menuItem }}">{!! $menuItem->title !!}</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	
	<div class="block light">
		<div class="container small">
			<h2>{{ $page->title }}</h2>
			<div class="wysiwyg">
				{!! $page->body !!}
			</div>
		</div>
	</div>

	<div class="block medium">
		<div class="container small">
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
			<div class="container small">
			@foreach($page->search as $search)
				<div class="search-result">
					<a href="{{ $search->url }}">{{ $search->title }}</a><br>
					{{ $search->body }}<br>
				</div>
			@endforeach
			</div>
		</div>
	@endif

	<div class="block dark footer">
		<div class="container">


		</div>
	</div>

@stop