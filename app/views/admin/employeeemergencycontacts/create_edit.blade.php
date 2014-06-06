@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employeeemergencycontact)){{ URL::to('admin/employeeemergencycontacts/' . $employee->id . '/edit/' . $employeeemergencycontact->id) }} @else {{ URL::to('admin/employeeemergencycontacts/' . $employee->id . '/create') }} @endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">

				<!-- employeeemergencycontact.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($employeeemergencycontact) ? $employeeemergencycontact->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.name -->

				<!-- employeeemergencycontact.relationship -->
				<div class="form-group {{{ $errors->has('relationship') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="relationship">Relationship</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="relationship" id="relationship" value="{{{ Input::old('relationship', isset($employeeemergencycontact) ? $employeeemergencycontact->relationship : null) }}}" />
						{{{ $errors->first('relationship', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.relationship -->

				<!-- employeeemergencycontact.home_phone -->
				<div class="form-group {{{ $errors->has('home_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="home_phone">Home phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="home_phone" id="home_phone" value="{{{ Input::old('home_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->home_phone : null) }}}" />
						{{{ $errors->first('home_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.home_phone -->

				<!-- employeeemergencycontact.work_phone -->
				<div class="form-group {{{ $errors->has('work_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="work_phone">Work phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="work_phone" id="work_phone" value="{{{ Input::old('work_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->work_phone : null) }}}" />
						{{{ $errors->first('work_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.work_phone -->

				<!-- employeeemergencycontact.mobile_phone -->
				<div class="form-group {{{ $errors->has('mobile_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="mobile_phone">Mobile phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="mobile_phone" id="mobile_phone" value="{{{ Input::old('mobile_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->mobile_phone : null) }}}" />
						{{{ $errors->first('mobile_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.mobile_phone -->

				<!-- employeeemergencycontact.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeeemergencycontact) ? $employeeemergencycontact->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeemergencycontact.note -->

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
			<div class="col-md-offset-2 col-md-6">
				<element class="btn btn-info close_popup">Cancel</element>
				<button type="reset" class="btn btn-primary">Reset</button>
				<button type="submit" class="btn btn-success">OK</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
@section('scripts')
<script type="text/javascript">
	//$('#start_date').datepicker() // In case recompiled bootstrap
	$('.start_date').datepicker(); // Template

	//$('#end_date').datepicker() // In case recompiled bootstrap
	$('.end_date').datepicker(); // Template
</script>
@stop
