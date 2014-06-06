@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="{{ URL::to('admin/employeeskills/' . $employee->id . '/edit/' . $employeeskill->id) }}">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">

				<!-- employeeskill.skill_id -->
				<div class="form-group {{{ $errors->has('skill_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="skill_id">Skills</label>
					<div class="col-md-6">
						{{ Form::select('skill_id', $skills, Input::old('skill_id'), array('id' => 'skill_id', 'class' => 'form-control')) }}
						{{{ $errors->first('skill_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeskill.skill_id -->

				<!-- employeeskill.year_of_exp -->
				<div class="form-group {{{ $errors->has('year_of_exp') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="year_of_exp">Year of experience</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="year_of_exp" id="year_of_exp" value="{{{ Input::old('year_of_exp', isset($employeeskill) ? $employeeskill->year_of_exp : null) }}}" />
						{{{ $errors->first('year_of_exp', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeskill.year_of_exp -->

				<!-- employeeskill.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeeskill) ? $employeeskill->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeeskill.note -->

				<!-- Activation Status -->
				<div class="form-group {{{ $errors->has('published') || $errors->has('published') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="confirm">Published</label>
					<div class="col-md-6">
						<select class="form-control" name="published" id="published">
							<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
							<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
						</select>
						{{{ $errors->first('published', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ activation status -->
			</div>
			<!-- ./ general tab -->
		</div>

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
