@extends('cms.layouts.cms')



@section('content')

	@include('cms.partials.menu')
	
	<div class="content">

		@include('cms.partials.header')

		panel

		<div class="grid">
			<div class="grid-6">
				<div class="panel panel-warning">
					<div class="panel-heading">Panel heading without title</div>
					<div class="panel-body">
						Panel content
					</div>
				</div>
			</div>
			<div class="grid-6">
				<div class="panel panel-info">
					<div class="panel-heading">Panel heading without title</div>
					<div class="panel-body">
						Panel content
					</div>
				</div>
			</div>
			<div class="grid-6">
				<div class="panel panel-success">
					<div class="panel-heading">Panel heading without title</div>
					<div class="panel-body">
						Panel content
					</div>
				</div>
			</div>
			<div class="grid-6">
				<div class="panel panel-primary">
					<div class="panel-heading">Panel heading without title</div>
					<div class="panel-body">
						Panel content
					</div>
				</div>
			</div>
		</div>
	</div>

@stop