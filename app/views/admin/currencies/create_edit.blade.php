@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($currency)){{ URL::to('admin/currencies/' . $currency->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- currencies.code -->
				<div class="form-group {{{ $errors->has('code') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="code">Code</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="code" id="code" value="{{{ Input::old('code', isset($currency) ? $currency->code : null) }}}" />
						{{{ $errors->first('code', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ currencies.code -->

				<!-- currencies.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($currency) ? $currency->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ currencies.name -->

				<!-- currencies.symbol_left -->
				<div class="form-group {{{ $errors->has('symbol_left') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="symbol_left">Symbol Left</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="symbol_left" id="symbol_left" value="{{{ Input::old('symbol_left', isset($currency) ? $currency->symbol_left : null) }}}" />
						{{{ $errors->first('symbol_left', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ currencies.symbol_left -->

				<!-- currencies.symbol_right -->
				<div class="form-group {{{ $errors->has('symbol_right') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="symbol_right">Symbol Right</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="symbol_right" id="symbol_right" value="{{{ Input::old('symbol_right', isset($currency) ? $currency->symbol_right : null) }}}" />
						{{{ $errors->first('symbol_right', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ currencies.symbol_right -->

				<!-- currencies.description -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="description">Description</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="description" id="description" value="{{{ Input::old('description', isset($currency) ? $currency->description : null) }}}" />
						{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ currencies.description -->

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