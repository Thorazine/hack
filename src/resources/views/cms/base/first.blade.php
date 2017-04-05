@extends('cms.layouts.base')



@section('content')

	{!! Form::open(['route' => 'cms.base.first.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
		<div class="panel panel-primary horizontal-center-panel panel-form">
			<div class="panel-heading">
				<h3 class="panel-title">Your admin account</h3>
			</div>
			<div class="panel-body">

				<div class="form-group">
					<label for="email" class="col-sm-4 control-label">Email address</label>
					<div class="col-sm-8">
						{!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email address']) !!}
						{!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-4 control-label">Password</label>
					<div class="col-sm-8">
						{!! Form::text('password', '', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
						{!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

			</div>
			<div class="panel-heading">
				<h3 class="panel-title">Your site</h3>
			</div>
			<div class="panel-body">

				<div class="form-group">
					<label for="title" class="col-sm-4 control-label">Title</label>
					<div class="col-sm-8">
						{!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'The title for your website']) !!}
						{!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

				<div class="form-group">
					<label for="protocol" class="col-sm-4 control-label">Language</label>
					<div class="col-sm-8">
						{!! Form::select('language', Builder::getLanguageAsArray(), 'en', ['class' => 'form-control', 'placeholder' => 'Your language']) !!}
						{!! $errors->first('language', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

				<div class="form-group">
					<label for="protocol" class="col-sm-4 control-label">Protocol</label>
					<div class="col-sm-8">
						{!! Form::select('protocol', ['http://' => 'Http', 'https://' => 'Https'], 'http://', ['class' => 'form-control', 'placeholder' => 'Without http(s)://']) !!}
						{!! $errors->first('protocol', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

				<div class="form-group">
					<label for="domain" class="col-sm-4 control-label">Main domain</label>
					<div class="col-sm-8">
						{!! Form::text('domain', str_replace(['http://', 'https://'], ['', ''], Request::root()), ['class' => 'form-control', 'placeholder' => 'Example: google.com']) !!}
						{!! $errors->first('domain', '<p class="text-danger">:message</p>') !!}
					</div>
				</div>

			</div>
			<div class="panel-body">
				<button type="submit" class="btn btn-primary pull-right">Create</button>
			</div>
		</div>
	{!! Form::close() !!}

@stop