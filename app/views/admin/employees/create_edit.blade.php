<form id="employee" name="employee" class="form-horizontal" method="post" action="@if (isset($employee)){{ URL::to('admin/employees/' . $employee->id . '/edit') }} @else {{ URL::to('admin/employees/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body" style="padding-top: 5px; padding-bottom: 0px;">
		<div class="" id="notifyDiv"></div>

		<ul class="nav nav-tabs" style="margin-bottom: 10px;">
			<li class="active"><a href="#tab-general" data-toggle="tab">Personal Info</a></li>
			<li class=""><a href="#tab-job" data-toggle="tab">Job</a></li>
			<li class=""><a href="#tab-contact" data-toggle="tab">Contact</a></li>
		</ul>

		<!-- Tabs Content -->
		<div class="tab-content">
		<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<div class="form-group">
					<label class="col-md-3 control-label" for="employee_number">Employee Number</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="employee_number" id="employee_number" value="{{{ Input::old('employee_number', isset($employee) ? $employee->employee_number : null) }}}" />
						<span class="has-error" id="error-employee_number"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="employee_code">Employee Code</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="employee_code" id="employee_code" value="{{{ Input::old('employee_code', isset($employee) ? $employee->employee_code : null) }}}" />
						<span class="has-error" id="error-employee_code"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="first_name">Fist Name</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', isset($employee) ? $employee->first_name : null) }}}" />
						<span class="has-error" id="error-first_name"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="middle_name">Middle Name</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="middle_name" id="middle_name" value="{{{ Input::old('middle_name', isset($employee) ? $employee->middle_name : null) }}}" />
						<span class="has-error" id="error-middle_name"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="last_name">Last Name</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', isset($employee) ? $employee->last_name : null) }}}" />
						<span class="has-error" id="error-last_name"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="picture">Photo</label>
					<div class="col-md-9">
						<input type="file" name="picture" id="picture" value="{{{ Input::old('picture', isset($employee) ? $employee->picture : null) }}}" />
						<span class="has-error" id="error-picture"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="last_name">Nationality</label>
					<div class="col-md-9">
						{{ Form::select('nationality_id', $nationalities, Input::old('nationality_id'), array('id' => 'nationality_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-nationality_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="gender_id">Gender</label>
					<div class="col-md-9">
						{{ Form::select('gender_id', $genders, Input::old('gender_id'), array('id' => 'gender_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-gender_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="marriage_id">Marital Status</label>
					<div class="col-md-9">
						{{ Form::select('marriage_id', $marriages, Input::old('marriage_id'), array('id' => 'marriage_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-marriage_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="birthday">Birthday</label>
					<div class="col-md-5 input-group input-append">
						<input class="form-control birthday datefield" id="birthday" name="birthday" data-date-viewmode="years" data-date-format="yyyy-mm-dd"
							type="text" value="{{{ Input::old('birthday', isset($employee) ? $employee->birthday : '') }}}">
						<span class="input-group-addon date "><span class="glyphicon glyphicon-calendar"></span></span>
						<span class="has-error" id="error-birthday"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="nic_no">NIC Number</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="nic_no" id="nic_no" value="{{{ Input::old('nic_no', isset($employee) ? $employee->nic_no : null) }}}" />
						<span class="has-error" id="error-nic_no"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="sin_no">SIN Number</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="sin_no" id="sin_no" value="{{{ Input::old('sin_no', isset($employee) ? $employee->sin_no : null) }}}" />
						<span class="has-error" id="error-sin_no"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="other_id_no">Other ID</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="other_id_no" id="other_id_no" value="{{{ Input::old('other_id_no', isset($employee) ? $employee->other_id_no : null) }}}" />
						<span class="has-error" id="error-other_id_no"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="driver_license_num">Driving License No.</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="driver_license_num" id="driver_license_num" value="{{{ Input::old('driver_license_num', isset($employee) ? $employee->driver_license_num : null) }}}" />
						<span class="has-error" id="error-driver_license_num"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="nick_name">Nick Name</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="nick_name" id="nick_name" value="{{{ Input::old('nick_name', isset($employee) ? $employee->nick_name : null) }}}" />
						<span class="has-error" id="error-nick_name"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="smoker">Smoker</label>
					<div class="col-md-1">
						<input type="checkbox" name="smoker" id="smoker" checked="{{{ Input::old('smoker', (isset($employee) && $employee->smoker == 1)? checked : false) }}}" />
						<span class="has-error" id="error-smoker"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
					<div class="col-md-9">
						<select class="form-control" name="published" id="published">
							<option value="1"{{{ (Input::old('published', isset($employee) ? $employee->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
							<option value="0"{{{ (Input::old('published', isset($employee) ? $employee->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
						</select>
					</div>
				</div>
			</div>
			<!-- ./ general tab -->

			<!-- Contact tab -->
			<div class="tab-pane" id="tab-job">
				<div class="form-group">
					<label class="col-md-3 control-label" for="employee_type_id">Employment Status</label>
					<div class="col-md-9">
						{{ Form::select('employee_type_id', $employmentTypes, Input::old('employee_type_id'), array('id' => 'employee_type_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-employee_type_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="job_title_id">Job Titles</label>
					<div class="col-md-9">
						{{ Form::select('job_title_id', $jobTitles, Input::old('job_title_id'), array('id' => 'job_title_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-job_title_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="pay_grade_id">Pay Grade</label>
					<div class="col-md-9">
						{{ Form::select('pay_grade_id', $payGrades, Input::old('pay_grade_id'), array('id' => 'pay_grade_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-pay_grade_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="note">Note</label>
					<div class="col-md-9">
						<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employee) ? $employee->note : null) }}}</textarea>
						<span class="has-error" id="error-note"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="joined_date">Joined Date</label>
					<div class="col-md-5 input-group input-append">
						<input class="form-control joined_date datefield" id="joined_date" name="joined_date" data-date-viewmode="years" data-date-format="yyyy-mm-dd"
							type="text" value="{{{ Input::old('joined_date', isset($employee) ? $employee->joined_date : '') }}}">
						<span class="input-group-addon date "><span class="glyphicon glyphicon-calendar"></span></span>
						<span class="has-error" id="error-joined_date"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="department">Department</label>
					<div class="col-md-9">
						{{ Form::select('department', array_merge(array('0' => 'Please Select'), $departments), Input::old('department'), array('id' => 'department', 'class' => 'form-control')) }}
						<span class="has-error" id="error-department"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="supervisor">Supervisor</label>
					<div class="col-md-9">
						{{ Form::select('supervisor', array_merge(array('0' => 'Please Select'), $supervisors), Input::old('supervisor'), array('id' => 'supervisor', 'class' => 'form-control')) }}
						<span class="has-error" id="error-supervisor"></span>
					</div>
				</div>
			</div>

			<!-- Contact tab -->
			<div class="tab-pane" id="tab-contact">
				<div class="form-group">
					<label class="col-md-3 control-label" for="street1">Address Line 1</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="street1" id="street1" value="{{{ Input::old('street1', isset($employee) ? $employee->street1 : null) }}}" />
						<span class="has-error" id="error-street1"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="street2">Address Line 2</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="street2" id="street2" value="{{{ Input::old('street2', isset($employee) ? $employee->street2 : null) }}}" />
						<span class="has-error" id="error-street2"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="city">City</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="city" id="city" value="{{{ Input::old('city', isset($employee) ? $employee->city : null) }}}" />
						<span class="has-error" id="error-city"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="country_id">Country</label>
					<div class="col-md-9">
						{{ Form::select('country_id', $countries, Input::old('country_id'), array('id' => 'country_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-country_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="state_id">State/Province</label>
					<div class="col-md-9">
						{{ Form::select('state_id', $states, Input::old('state_id'), array('id' => 'state_id', 'class' => 'form-control')) }}
						<span class="has-error" id="error-state_id"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="zip_code">Postal/Zip Code</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="zip_code" id="zip_code" value="{{{ Input::old('zip_code', isset($employee) ? $employee->zip_code : null) }}}" />
						<span class="has-error" id="error-zip_code"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="home_phone">Home Phone</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="home_phone" id="home_phone" value="{{{ Input::old('home_phone', isset($employee) ? $employee->home_phone : null) }}}" />
						<span class="has-error" id="error-home_phone"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="mobile_phone">Mobile Phone</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="mobile_phone" id="mobile_phone" value="{{{ Input::old('mobile_phone', isset($employee) ? $employee->mobile_phone : null) }}}" />
						<span class="has-error" id="error-mobile_phone"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="work_phone">Work Phone</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="work_phone" id="work_phone" value="{{{ Input::old('work_phone', isset($employee) ? $employee->work_phone : null) }}}" />
						<span class="has-error" id="error-work_phone"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="work_email">Work Email</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="work_email" id="work_email" value="{{{ Input::old('work_email', isset($employee) ? $employee->work_email : null) }}}" />
						<span class="has-error" id="error-work_email"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label" for="other_email">Other Email</label>
					<div class="col-md-9">
						<input class="form-control" type="text" name="other_email" id="other_email" value="{{{ Input::old('other_email', isset($employee) ? $employee->other_email : null) }}}" />
						<span class="has-error" id="error-other_email"></span>
					</div>
				</div>
			</div>
			<!-- ./ contact tab -->
		</div>
		<!-- ./ tabs content -->
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">{{{ Lang::get('button.close') }}}</button>
		<button type="button" class="btn btn-primary" id="resetId">{{{ Lang::get('button.reset') }}}</button>
		<button type="button" class="btn btn-primary" id="saveId">{{{ Lang::get('button.save') }}}</button>
	</div>
</form>
@section('scripts')
<script type="text/javascript">
	var reload = false;
	@if ($mode == 'create')
		var url = '{{ URL::to("admin/employees/create") }}';
	@else
	var url = '{{ URL::to("admin/employees/" . $employee->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#employee')[0].reset();
			$(this).closest('form').find('span').each(function(){
				if($(this).hasClass('has-error'))
					$(this).html('');
			});
		});

		$('#saveId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset from data
			var form = $('form#employee');
			var data = $(form).serialize();
			$(form.find('span')).each(function(){
				if($(this).hasClass('has-error'))
					$(this).html('');
			});

			$.ajax({
				url: url,
				data: data,
				dataType: 'json',
				method: 'POST',
				success: function(returnData) {
					var returnObj = $.parseJSON(returnData);
					if(returnObj.failedValidate){
						$($.parseJSON(returnObj.messages)).each(function(i, val){
							$.each(val, function(k, v){
								$('#error-'+k).html(v);
							});
						});
					}else{
						$(returnObj.messages).each(function(i, val){
							$.each(val, function(k, v){
								if(k == 'success'){
									$('#notifyDiv').html(v + '<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-success');
									reload = true;
								} else {
									$('#notifyDiv').html(v + '<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-danger');
								}

							});
						});

						if(reload == true){
							parent.oTable.fnReloadAjax();
						}
					}
				},
				error: function(){
					$('#notifyDiv').html('Save fail<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-danger');
				}
			});
		});
	});

	$('#birthday').datepicker();
	$('#joined_date').datepicker();
</script>
@section('scripts')
