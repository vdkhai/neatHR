@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employeecertification)){{ URL::to('admin/employeecertifications/' . $employee->id . '/edit/' . $employeecertification->id) }} @else {{ URL::to('admin/employeecertifications/' . $employee->id . '/create') }} @endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- employeecertification.certification_id -->
				<div class="form-group {{{ $errors->has('certification_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="certification_id">Certification</label>
					<div class="col-md-6">
						{{ Form::select('certification_id', $certifications, Input::old('certification_id'), array('id' => 'certification_id', 'class' => 'form-control')) }}
						{{{ $errors->first('certification_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeecertification.certification_id -->

				<!-- employeecertification.institute -->
				<div class="form-group {{{ $errors->has('institute') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="institute">Institute</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="institute" id="institute" value="{{{ Input::old('institute', isset($employeecertification) ? $employeecertification->institute : null) }}}" />
						{{{ $errors->first('institute', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeecertification.institute -->

				<!-- employeecertification.start_date -->
				<div class="form-group {{{ $errors->has('start_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="start_date">Start Date</label>
					<div class="col-md-6 input-append date datefield" id="start_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="start_date" type="text" value="{{{ Input::old('start_date', isset($employeecertification) ? $employeecertification->start_date : null) }}}" name="start_date" id="start_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employeecertification.start_date -->

				<!-- employeecertification.end_date -->
				<div class="form-group {{{ $errors->has('end_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="end_date">End Date</label>
					<div class="col-md-6 input-append date datefield" id="start_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="end_date" type="text" value="{{{ Input::old('end_date', isset($employeecertification) ? $employeecertification->end_date : null) }}}" name="end_date" id="end_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employeecertification.end_date -->

				<!-- employeecertification.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeecertification) ? $employeecertification->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeecertification.note -->

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