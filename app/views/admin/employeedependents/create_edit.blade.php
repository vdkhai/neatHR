@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employeedependent)){{ URL::to('admin/employeedependents/' . $employee->id . '/edit/' . $employeedependent->id) }} @else {{ URL::to('admin/employeedependents/' . $employee->id . '/create') }} @endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">

				<!-- employeedependent.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($employeedependent) ? $employeedependent->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeedependent.name -->

				<!-- employeelanguage.dependent_id -->
				<div class="form-group {{{ $errors->has('dependent_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="dependent_id">Dependent</label>
					<div class="col-md-6">
						{{ Form::select('dependent_id', $dependents, Input::old('dependent_id'), array('id' => 'dependent_id', 'class' => 'form-control')) }}
						{{{ $errors->first('dependent_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeelanguage.dependent_id -->

				<!-- employeedependent.birthday -->
				<div class="form-group {{{ $errors->has('birthday') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="birthday">Birthday</label>
					<div class="col-md-6 input-append date datefield" id="birthday" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="birthday" type="text" value="{{{ Input::old('birthday', isset($employeedependent) ? $employeedependent->birthday : null) }}}" name="birthday" id="birthday" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employeedependent.birthday -->

				<!-- employeedependent.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeedependent) ? $employeedependent->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeedependent.note -->

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
	//$('#birthday').datepicker() // In case recompiled bootstrap
	$('.birthday').datepicker(); // Template
</script>
@stop
