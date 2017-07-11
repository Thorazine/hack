@extends('hack::layouts.cms')



@section('content')

	@include('hack::partials.menu')
	
	<div class="content">

		@include('hack::partials.header')

		<h1>Dashboard</h1>

		<div class="grid space-10">

			@if($maintenance)
				<div class="grid-12">
					<div class="panel panel-warning">
						<div class="panel-heading">{!! trans('hack::modules.panel.maintenance', ['start_date' => $maintenance->start_date, 'end_date' => $maintenance->end_date]) !!}</div>
						<div class="panel-body">
							{!! $maintenance->message !!}
						</div>
					</div>
				</div>
			@endif

			<div class="grid-6">
				<div class="panel panel-info">
					<div class="panel-heading">Basic information</div>
					<div class="panel-body">
						Panel content
					</div>
				</div>
			</div>
			<div class="grid-6">
				<div class="panel panel-success">
					<div class="panel-heading">Success messages</div>
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

	<div class="footer">
		<span class="version">Version {{ Cms::getVersion() }}</span>
	</div>

@stop