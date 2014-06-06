@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($recruitvacancy)){{ URL::to('admin/recruitvacancies/' . $recruitvacancy->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- recruitvacancies.name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($recruitvacancy) ? $recruitvacancy->name : null) }}}" />
						{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.name -->

				<!-- recruitvacancies.job_title_id -->
				<div class="form-group {{{ $errors->has('job_title_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="job_title_id">Job Title</label>
					<div class="col-md-6">
						{{ Form::select('job_title_id', $jobtitles, Input::old('job_title_id'), array('id' => 'job_title_id', 'class' => 'form-control')) }}
						{{{ $errors->first('job_title_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.job_title_id -->

				<!-- recruitvacancies.hiring_manager_id -->
				<div class="form-group {{{ $errors->has('hiring_manager_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="hiring_manager_id">Hiring Manager</label>
					<div class="col-md-6">
						{{ Form::select('hiring_manager_id', $employees, Input::old('hiring_manager_id'), array('id' => 'hiring_manager_id', 'class' => 'form-control')) }}
						{{{ $errors->first('hiring_manager_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.hiring_manager_id -->

				<!-- recruitvacancies.contact_person_id -->
				<div class="form-group {{{ $errors->has('contact_person_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="hiring_manager_id">Contact Person</label>
					<div class="col-md-6">
						{{ Form::select('contact_person_id', $employees, Input::old('contact_person_id'), array('id' => 'contact_person_id', 'class' => 'form-control')) }}
						{{{ $errors->first('contact_person_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.contact_person_id -->

				<!-- recruitvacancies.amount -->
				<div class="form-group {{{ $errors->has('amount') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="amount">Amount</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="amount" id="amount" value="{{{ Input::old('amount', isset($recruitvacancy) ? $recruitvacancy->amount : null) }}}" />
						{{{ $errors->first('amount', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.amount -->

				<!-- recruitvacancies.description -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="description">Description</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="description" id="description">{{{ Input::old('description', isset($recruitvacancy) ? $recruitvacancy->description : null) }}}</textarea>
						{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitvacancies.description -->

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