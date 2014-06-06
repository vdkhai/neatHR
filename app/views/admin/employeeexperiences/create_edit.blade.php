@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employeeexperience)){{ URL::to('admin/employeeexperiences/' . $employee->id . '/edit/' . $employeeexperience->id) }} @else {{ URL::to('admin/employeeexperiences/' . $employee->id . '/create') }} @endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- employeeexperiences.company_name -->
				<div class="form-group {{{ $errors->has('company_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="company_name">Compnay Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="company_name" id="company_name" value="{{{ Input::old('company_name', isset($employeeexperience) ? $employeeexperience->company_name : null) }}}" />
						{{{ $errors->first('company_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeexperiences.company_name -->

				<!-- employeeexperiences.job_title -->
				<div class="form-group {{{ $errors->has('job_title') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="job_title">Job Title</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="job_title" id="job_title" value="{{{ Input::old('job_title', isset($employeeexperience) ? $employeeexperience->job_title : null) }}}" />
						{{{ $errors->first('job_title', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeexperiences.job_title -->

				<!-- employeeexperiences.start_date -->
				<div class="form-group {{{ $errors->has('start_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="start_date">Start Date</label>
					<div class="col-md-6 input-append date datefield" id="start_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="start_date" type="text" value="{{{ Input::old('start_date', isset($employeeexperience) ? $employeeexperience->start_date : null) }}}" name="start_date" id="start_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employeeexperiences.start_date -->

				<!-- employeeexperiences.end_date -->
				<div class="form-group {{{ $errors->has('end_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="end_date">End Date</label>
					<div class="col-md-6 input-append date datefield" id="start_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="end_date" type="text" value="{{{ Input::old('end_date', isset($employeeexperience) ? $employeeexperience->end_date : null) }}}" name="end_date" id="end_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employeeexperiences.end_date -->

				<!-- employeeexperiences.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeeexperience) ? $employeeexperience->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeexperiences.note -->

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
