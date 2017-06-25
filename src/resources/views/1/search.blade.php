@extends('1.layouts.default')



@section('content')

	<h1>{{ $page->title }}</h1>
	{!! $page->body !!}	

	@foreach($page->search as $search)
		<div>
			<a href="{{ $search->url }}">{{ $search->title }}</a><br>
			{{ $search->body }}<br>
		</div>
	@endforeach

@stop