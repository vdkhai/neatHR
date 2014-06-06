@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li class=""><a href="#tab-contact" data-toggle="tab">Contact</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employee)){{ URL::to('admin/employees/' . $employee->id . '/edit') }}@endif" autocomplete="off" enctype="multipart/form-data">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- employees.employee_number -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="employee_number">Employee Number</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="employee_number" id="employee_number" value="{{{ Input::old('employee_number', isset($employee) ? $employee->employee_number : null) }}}" />
						{{{ $errors->first('employee_number', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.employee_number -->

				<!-- employees.employee_code -->
				<div class="form-group {{{ $errors->has('employee_code') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="employee_code">Employee Code</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="employee_code" id="employee_code" value="{{{ Input::old('employee_code', isset($employee) ? $employee->employee_code : null) }}}" />
						{{{ $errors->first('employee_code', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.employee_code -->

				<!-- employees.first_name -->
				<div class="form-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="first_name">Fist Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', isset($employee) ? $employee->first_name : null) }}}" />
						{{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.first_name -->

				<!-- employees.middle_name -->
				<div class="form-group {{{ $errors->has('middle_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="middle_name">Middle Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="middle_name" id="middle_name" value="{{{ Input::old('middle_name', isset($employee) ? $employee->middle_name : null) }}}" />
						{{{ $errors->first('middle_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.middle_name -->

				<!-- employees.last_name -->
				<div class="form-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="last_name">Last Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', isset($employee) ? $employee->last_name : null) }}}" />
						{{{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.last_name -->

				<!-- employees.picture -->
				<div class="form-group {{{ $errors->has('picture') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="picture">Photo</label>
					<div class="col-md-6">
						<input type="file" name="picture" id="picture" value="{{{ Input::old('picture', isset($employee) ? $employee->picture : null) }}}" />
						{{{ $errors->first('picture', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.picture -->

				<!-- employees.nationality_id -->
				<div class="form-group {{{ $errors->has('nationality_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="last_name">Nationality</label>
					<div class="col-md-6">
						{{ Form::select('nationality_id', $nationalities, Input::old('nationality_id'), array('id' => 'nationality_id', 'class' => 'form-control')) }}
						{{{ $errors->first('nationality_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.nationality_id -->

				<!-- employees.gender_id -->
				<div class="form-group {{{ $errors->has('gender_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="gender_id">Gender</label>
					<div class="col-md-6">
						{{ Form::select('gender_id', $genders, Input::old('gender_id'), array('id' => 'gender_id', 'class' => 'form-control')) }}
						{{{ $errors->first('gender_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.gender_id -->

				<!-- employees.marriage_id -->
				<div class="form-group {{{ $errors->has('marriage_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="marriage_id">Marital Status</label>
					<div class="col-md-6">
						{{ Form::select('marriage_id', $marriages, Input::old('marriage_id'), array('id' => 'marriage_id', 'class' => 'form-control')) }}
						{{{ $errors->first('marriage_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.marriage_id -->

				<!-- employees.birthday -->
				<div class="form-group {{{ $errors->has('birthday') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="birthday">Birthday</label>
					<div class="col-md-6 input-append date datefield" id="birthday" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="birthday" type="text" value="{{{ Input::old('birthday', isset($employee) ? $employee->birthday : null) }}}" name="birthday" id="birthday" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employees.birthday -->

				<!-- employees.nic_no -->
				<div class="form-group {{{ $errors->has('nic_no') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="nic_no">NIC Number</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="nic_no" id="nic_no" value="{{{ Input::old('nic_no', isset($employee) ? $employee->nic_no : null) }}}" />
						{{{ $errors->first('nic_no', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.nic_no -->

				<!-- employees.sin_no -->
				<div class="form-group {{{ $errors->has('sin_no') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="sin_no">SIN Number</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="sin_no" id="sin_no" value="{{{ Input::old('sin_no', isset($employee) ? $employee->sin_no : null) }}}" />
						{{{ $errors->first('sin_no', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.sin_no -->

				<!-- employees.other_id_no -->
				<div class="form-group {{{ $errors->has('other_id_no') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="other_id_no">Other ID</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="other_id_no" id="other_id_no" value="{{{ Input::old('other_id_no', isset($employee) ? $employee->other_id_no : null) }}}" />
						{{{ $errors->first('other_id_no', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.other_id_no -->

				<!-- employees.driver_license_num -->
				<div class="form-group {{{ $errors->has('driver_license_num') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="driver_license_num">Driving License No.</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="driver_license_num" id="driver_license_num" value="{{{ Input::old('driver_license_num', isset($employee) ? $employee->driver_license_num : null) }}}" />
						{{{ $errors->first('driver_license_num', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.driver_license_num -->

				<!-- employees.nick_name -->
				<div class="form-group {{{ $errors->has('nick_name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="nick_name">Nick Name</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="nick_name" id="nick_name" value="{{{ Input::old('nick_name', isset($employee) ? $employee->nick_name : null) }}}" />
						{{{ $errors->first('nick_name', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.nick_name -->

				<!-- employees.smoker -->
				<div class="form-group {{{ $errors->has('smoker') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="smoker">Smoker</label>
					<div class="col-md-1">
						<input type="checkbox" name="smoker" id="smoker" checked="{{{ Input::old('smoker', (isset($employee) && $employee->smoker == 1)? checked : false) }}}" />
						{{{ $errors->first('smoker', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.smoker -->

				<!-- employees.employee_type_id -->
				<div class="form-group {{{ $errors->has('employee_type_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="employee_type_id">Employment Status</label>
					<div class="col-md-6">
						{{ Form::select('employee_type_id', $employmentTypes, Input::old('employee_type_id'), array('id' => 'employee_type_id', 'class' => 'form-control')) }}
						{{{ $errors->first('employee_type_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.employee_type_id -->

				<!-- employees.job_title_id -->
				<div class="form-group {{{ $errors->has('job_title_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="job_title_id">Job Titles</label>
					<div class="col-md-6">
						{{ Form::select('job_title_id', $jobTitles, Input::old('job_title_id'), array('id' => 'job_title_id', 'class' => 'form-control')) }}
						{{{ $errors->first('job_title_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.job_title_id -->

				<!-- employees.pay_grade_id -->
				<div class="form-group {{{ $errors->has('pay_grade_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="pay_grade_id">Pay Grade</label>
					<div class="col-md-6">
						{{ Form::select('pay_grade_id', $payGrades, Input::old('pay_grade_id'), array('id' => 'pay_grade_id', 'class' => 'form-control')) }}
						{{{ $errors->first('pay_grade_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.job_title_id -->

				<!-- employees.note -->
				<div class="form-group {{{ $errors->has('note') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="note">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employee) ? $employee->note : null) }}}</textarea>
						{{{ $errors->first('note', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.note -->

				<!-- employees.joined_date -->
				<div class="form-group {{{ $errors->has('joined_date') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="joined_date">Joined Date</label>
					<div class="col-md-6 input-append date datefield" id="joined_date" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
						<input class="joined_date" type="text" value="{{{ Input::old('joined_date', isset($employee) ? $employee->joined_date : null) }}}" name="joined_date" id="joined_date" readonly="readonly">
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
				</div>
				<!-- ./ employees.joined_date -->

				<!-- employees.department -->
				<div class="form-group {{{ $errors->has('department') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="department">Department</label>
					<div class="col-md-6">
						{{ Form::select('department', array_merge(array('0' => 'Please Select'), $departments), Input::old('department'), array('id' => 'department', 'class' => 'form-control')) }}
						{{{ $errors->first('department', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.department -->

				<!-- employees.supervisor -->
				<div class="form-group {{{ $errors->has('supervisor') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="supervisor">Supervisor</label>
					<div class="col-md-6">
						{{ Form::select('supervisor', array_merge(array('0' => 'Please Select'), $supervisors), Input::old('supervisor'), array('id' => 'supervisor', 'class' => 'form-control')) }}
						{{{ $errors->first('supervisor', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.supervisor -->

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

			<!-- Contact tab -->
			<div class="tab-pane" id="tab-contact">
				<!-- employees.street1 -->
				<div class="form-group {{{ $errors->has('street1') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="street1">Address Line 1</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="street1" id="street1" value="{{{ Input::old('street1', isset($employee) ? $employee->street1 : null) }}}" />
						{{{ $errors->first('street1', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.street1 -->

				<!-- employees.street2 -->
				<div class="form-group {{{ $errors->has('street2') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="street2">Address Line 2</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="street2" id="street2" value="{{{ Input::old('street2', isset($employee) ? $employee->street2 : null) }}}" />
						{{{ $errors->first('street2', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.street2 -->

				<!-- employees.city -->
				<div class="form-group {{{ $errors->has('city') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="city">City</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="city" id="city" value="{{{ Input::old('city', isset($employee) ? $employee->city : null) }}}" />
						{{{ $errors->first('city', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.city -->

				<!-- employees.country_id -->
				<div class="form-group {{{ $errors->has('country_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="country_id">Country</label>
					<div class="col-md-6">
						{{ Form::select('country_id', $countries, Input::old('country_id'), array('id' => 'country_id', 'class' => 'form-control')) }}
						{{{ $errors->first('country_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.country_id -->

				<!-- employees.state_id -->
				<div class="form-group {{{ $errors->has('state_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="state_id">State/Province</label>
					<div class="col-md-6">
						{{ Form::select('state_id', $states, Input::old('state_id'), array('id' => 'state_id', 'class' => 'form-control')) }}
						{{{ $errors->first('state_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.state_id -->

				<!-- employees.zip_code -->
				<div class="form-group {{{ $errors->has('zip_code') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="zip_code">Postal/Zip Code</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="zip_code" id="zip_code" value="{{{ Input::old('zip_code', isset($employee) ? $employee->zip_code : null) }}}" />
						{{{ $errors->first('zip_code', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.zip_code -->

				<!-- employees.home_phone -->
				<div class="form-group {{{ $errors->has('home_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="home_phone">Home Phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="home_phone" id="home_phone" value="{{{ Input::old('home_phone', isset($employee) ? $employee->home_phone : null) }}}" />
						{{{ $errors->first('home_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.home_phone -->

				<!-- employees.mobile_phone -->
				<div class="form-group {{{ $errors->has('mobile_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="mobile_phone">Mobile Phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="mobile_phone" id="mobile_phone" value="{{{ Input::old('mobile_phone', isset($employee) ? $employee->mobile_phone : null) }}}" />
						{{{ $errors->first('mobile_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.mobile_phone -->

				<!-- employees.work_phone -->
				<div class="form-group {{{ $errors->has('work_phone') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="work_phone">Work Phone</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="work_phone" id="work_phone" value="{{{ Input::old('work_phone', isset($employee) ? $employee->work_phone : null) }}}" />
						{{{ $errors->first('work_phone', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.work_phone -->

				<!-- employees.work_email -->
				<div class="form-group {{{ $errors->has('work_email') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="work_email">Work Email</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="work_email" id="work_email" value="{{{ Input::old('work_email', isset($employee) ? $employee->work_email : null) }}}" />
						{{{ $errors->first('work_email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.work_email -->

				<!-- employees.other_email -->
				<div class="form-group {{{ $errors->has('other_email') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="other_email">Other Email</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="other_email" id="other_email" value="{{{ Input::old('other_email', isset($employee) ? $employee->other_email : null) }}}" />
						{{{ $errors->first('other_email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employees.other_email -->
			</div>
			<!-- ./ contact tab -->
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

	//$('#joined_date').datepicker() // In case recompiled bootstrap
	$('.joined_date').datepicker(); // Template
</script>
@stop
