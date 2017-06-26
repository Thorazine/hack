@extends('1.layouts.default')



@section('css')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('theme/css/theme.css') }}">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
@stop



@section('content')

	<div class="block menu">
		<div class="container narrow">
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
		<div class="container narrow">
			<h2>{{ $page->title }}</h2>
				
			<div class="wysiwyg">
				{!! $page->body !!}
			</div>
		</div>
	</div>

	<div class="block medium">
		<div class="container">
			<h2 class="center">
				{{ $page->title_2 }}
			</h2>
			<div class="wysiwyg">
				{!! $page->body_2 !!}
			</div>
		</div>
	</div>

	<div class="block dark footer">
		<div class="container">


		</div>
	</div>
	

@stop


@section('script')

@stop