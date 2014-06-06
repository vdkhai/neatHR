@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($country)){{ URL::to('admin/countries/' . $country->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- countries.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Country Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($country) ? $country->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ countries.name -->

				<!-- iso_code2 -->
				<div class="form-group {{{ $errors->has('iso_code_2') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="iso_code_2">ISO Code 2</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="iso_code_2" id="iso_code_2" value="{{{ Input::old('iso_code_2', isset($country) ? $country->iso_code_2 : null) }}}" />
						{{{ $errors->first('iso_code_2', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ iso_code2 -->

				<!-- iso_code3 -->
				<div class="form-group {{{ $errors->has('iso_code_3') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="iso_code_3">ISO Code 3</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="iso_code_3" id="iso_code_3" value="{{{ Input::old('iso_code_3', isset($country) ? $country->iso_code_3 : null) }}}" />
						{{{ $errors->first('iso_code_3', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ iso_code3 -->

				<!-- address_format -->
				<div class="form-group {{{ $errors->has('address_format') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="address_format">Address Format</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="address_format" id="address_format" value="{{{ Input::old('address_format', isset($country) ? $country->address_format : null) }}}" />
						{{{ $errors->first('address_format', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ address_format -->

				<!-- postcode_required -->
				<div class="form-group {{{ $errors->has('postcode_required') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="postcode_required">Postcode Required</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="postcode_required" id="postcode_required" value="{{{ Input::old('postcode_required', isset($country) ? $country->postcode_required : null) }}}" />
						{{{ $errors->first('postcode_required', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ postcode_required -->

				<!-- Activation Status -->
				<div class="form-group {{{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="confirm">Activate User?</label>
					<div class="col-md-6">
						@if ($mode == 'create')
							<select class="form-control" name="confirm" id="confirm">
								<option value="1"{{{ (Input::old('confirm', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
								<option value="0"{{{ (Input::old('confirm', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
							</select>
						@else
							<select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirm" id="confirm">
								<option value="1"{{{ ($user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
								<option value="0"{{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
							</select>
						@endif
						{{{ $errors->first('confirm', '<span class="help-inline">:message</span>') }}}
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