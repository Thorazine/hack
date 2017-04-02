@extends('2.layouts.default')



@section('content')
	
	<p>Default: {{ $page->image }}</p>
	<p>Full url: {{ $page->image->url }}</p>
	<p>Cache key: {{ $page->image->key() }}</p>
	<p>Does image exist on disc: {{ $page->image->has() }}</p>
	<p>Title: {{ $page->image->title }}</p>
	<p>Full filename: {{ $page->image->fullName }}</p>
	<p>Extension: {{ $page->image->extension }}</p>
	<p>Width: {{ $page->image->width }}</p>
	<p>Height: {{ $page->image->height }}</p>
	<p>Filesize in B: {{ $page->image->filesize }}</p>
	<p>Filesize in KB: {{ $page->image->filesize('KB') }}</p>
	<p>Filesize in MB: {{ $page->image->filesize('MB') }}</p>
	<p>Filesize in GB: {{ $page->image->filesize('GB') }}</p>

	<div class="container">
		{!! $page->test_form->html() !!}
	</div>

	{{ dump($page) }}
@stop