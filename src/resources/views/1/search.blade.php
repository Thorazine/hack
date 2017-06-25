@extends('1.layouts.default')



@section('content')

	<h1>{{ $page->title }}</h1>
	{!! $page->body !!}	

	{!! Form::open(['url' => Request::url(), 'method' => 'GET']) !!}
		{!! Form::text('q', Request::get('q'), ['class' => '']) !!}
	{!! Form::close() !!}

	@foreach($page->search as $search)
		<div>
			<a href="{{ $search->url }}">{{ $search->title }}</a><br>
			{{ $search->body }}<br>
		</div>
	@endforeach

@stop