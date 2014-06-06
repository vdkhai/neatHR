@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($paygrade)){{ URL::to('admin/paygrades/' . $paygrade->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- paygrades.currency_id -->
				<div class="form-group {{{ $errors->has('currency_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="currency_id">Currency</label>
					<div class="col-md-6">
						{{ Form::select('currency_id', $currencies, Input::old('currency_id'), array('id' => 'currency_id', 'class' => 'form-control')) }}
						{{{ $errors->first('currency_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ paygrades.currency_id -->

				<!-- paygrades.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($paygrade) ? $paygrade->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ paygrades.name -->

				<!-- paygrades.description -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="description">Description</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="description" id="description" value="{{{ Input::old('description', isset($paygrade) ? $paygrade->description : null) }}}" />
						{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ paygrades.description -->

				<!-- paygrades.min_salary -->
				<div class="form-group {{{ $errors->has('min_salary') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="min_salary">Minimum Salary</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="min_salary" id="min_salary" value="{{{ Input::old('min_salary', isset($paygrade) ? $paygrade->min_salary : null) }}}" />
						{{{ $errors->first('min_salary', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ paygrades.min_salary -->

				<!-- paygrades.max_salary -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="max_salary">Maximum Salary</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="max_salary" id="max_salary" value="{{{ Input::old('max_salary', isset($paygrade) ? $paygrade->max_salary : null) }}}" />
						{{{ $errors->first('max_salary', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ paygrades.max_salary -->

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