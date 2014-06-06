@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($jobtitle)){{ URL::to('admin/jobtitles/' . $jobtitle->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- jobtitles.code -->
				<div class="form-group {{{ $errors->has('code') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="code">Code</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="code" id="code" value="{{{ Input::old('code', isset($jobtitle) ? $jobtitle->code : null) }}}" />
						{{{ $errors->first('code', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ jobtitles.code -->

				<!-- jobtitles.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($jobtitle) ? $jobtitle->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ jobtitles.name -->

				<!-- jobtitles.description -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="description">Description</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="description" id="description" value="{{{ Input::old('description', isset($jobtitle) ? $jobtitle->description : null) }}}" />
						{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ jobtitles.description -->

				<!-- jobtitles.specification -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="specification">Specification</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="specification" id="specification" value="{{{ Input::old('specification', isset($jobtitle) ? $jobtitle->specification : null) }}}" />
						{{{ $errors->first('specification', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ jobtitles.specification -->

				<!-- Activation Status -->
				<div class="form-group {{{ $errors->has('published') || $errors->has('published') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="confirm">Published</label>
					<div class="col-md-6">
						@if ($mode == 'create')
						<select class="form-control" name="published" id="published">
							<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
							<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
						</select>
						@else
						<select class="form-control" name="published" id="published">
							<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
							<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
						</select>
						@endif
						{{{ $errors->first('published', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ activation status -->
			</div>
			<!-- ./ general tab -->
		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">OK</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop