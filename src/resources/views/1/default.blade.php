@extends('1.layouts.default')



@section('content')
	This is a default template. Below you'll see the output from the $page variable.<br>
	All you need is within the $page variable.

	{{ dump($page) }}

@stop