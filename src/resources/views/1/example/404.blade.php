@extends('1.layouts.default')



@section('css')
	@include('1.example.partials.css')
@stop



@section('content')
<div id="content">
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