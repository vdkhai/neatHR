@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($recruitcandidate)){{ URL::to('admin/recruitcandidates/' . $recruitcandidate->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- recruitcandidates.first_name -->
				<div class="form-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="first_name">First Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', isset($recruitcandidate) ? $recruitcandidate->first_name : null) }}}" />
						{{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.first_name -->

				<!-- recruitcandidates.middle_name -->
				<div class="form-group {{{ $errors->has('middle_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="middle_name">Middle Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="middle_name" id="middle_name" value="{{{ Input::old('middle_name', isset($recruitcandidate) ? $recruitcandidate->middle_name : null) }}}" />
						{{{ $errors->first('middle_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.middle_name -->

				<!-- recruitcandidates.last_name -->
				<div class="form-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="last_name">Last Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', isset($recruitcandidate) ? $recruitcandidate->last_name : null) }}}" />
						{{{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.last_name -->

				<!-- recruitcandidates.nationality_id -->
				<div class="form-group {{{ $errors->has('nationality_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="nationality_id">Nationality</label>
					<div class="col-md-6">
						{{ Form::select('nationality_id', $nationalities, Input::old('nationality_id'), array('id' => 'nationality_id', 'class' => 'form-control')) }}
						{{{ $errors->first('nationality_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.nationality_id -->

				<!-- recruitcandidates.work_email -->
				<div class="form-group {{{ $errors->has('work_email') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="work_email">Work Email</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="work_email" id="work_email" value="{{{ Input::old('work_email', isset($recruitcandidate) ? $recruitcandidate->work_email : null) }}}" />
						{{{ $errors->first('work_email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.work_email -->

				<!-- recruitcandidates.other_email -->
				<div class="form-group {{{ $errors->has('other_email') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="other_email">Other Email</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="other_email" id="other_email" value="{{{ Input::old('other_email', isset($recruitcandidate) ? $recruitcandidate->other_email : null) }}}" />
						{{{ $errors->first('other_email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.other_email -->

				<!-- recruitcandidates.contact_number -->
				<div class="form-group {{{ $errors->has('contact_number') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="contact_number">Contact Number</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="contact_number" id="contact_number" value="{{{ Input::old('contact_number', isset($recruitcandidate) ? $recruitcandidate->contact_number : null) }}}" />
						{{{ $errors->first('contact_number', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.contact_number -->

				<!-- recruitcandidates.recruitment_status_id -->
				<div class="form-group {{{ $errors->has('recruitment_status_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="recruitment_status_id">Recruitment Status</label>
					<div class="col-md-6">
						{{ Form::select('recruitment_status_id', $recruitmentStatus, Input::old('recruitment_status_id'), array('id' => 'recruitment_status_id', 'class' => 'form-control')) }}
						{{{ $errors->first('recruitment_status_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.recruitment_status_id -->

				<!-- recruitcandidates.application_way -->
				<div class="form-group {{{ $errors->has('application_way') || $errors->has('application_way') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="application_way">Application Way</label>
					<div class="col-md-6">
						<select class="form-control" name="application_way" id="application_way">
							<option value="1"{{{ (Input::old('application_way', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('Normal') }}}</option>
							<option value="0"{{{ (Input::old('application_way', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('Online') }}}</option>
						</select>
						{{{ $errors->first('application_way', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.application_way -->

				<!-- recruitcandidates.keywords -->
				<div class="form-group {{{ $errors->has('keywords') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="keywords">Key Words</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="keywords" id="keywords" value="{{{ Input::old('keywords', isset($recruitcandidate) ? $recruitcandidate->keywords : null) }}}" />
						{{{ $errors->first('keywords', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.keywords -->

				<!-- recruitcandidates.application_date -->
				<div class="form-group {{{ $errors->has('application_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="application_date">Application Date</label>
					<div class="col-md-6 input-append date datefield" id="application_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="application_date" type="text" value="{{{ Input::old('application_date', isset($recruitcandidate) ? $recruitcandidate->application_date : null) }}}" name="application_date" id="application_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ recruitcandidates.application_date -->

				<!-- recruitcandidates.comment -->
				<div class="form-group {{{ $errors->has('comment') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="comment">Description</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="comment" id="comment">{{{ Input::old('description', isset($recruitcandidate) ? $recruitcandidate->comment : null) }}}</textarea>
						{{{ $errors->first('comment', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ recruitcandidates.comment -->
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

@section('scripts')
<script type="text/javascript">
	//$('#application_date').datepicker() // In case recompiled bootstrap
	$('.application_date').datepicker(); // Template
</script>
@stop