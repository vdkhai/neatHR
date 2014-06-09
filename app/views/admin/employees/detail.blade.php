@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')
	<div class="page-header" xmlns="http://www.w3.org/1999/html">
		<h3>
			{{{ $title }}}
			<div class="pull-right">
				<div class="btn-group">
					<a href="{{{ URL::to('admin/employees') }}}" class="btn btn-small btn-primary"><span class="glyphicon glyphicon-th-list"></span> Employees List</a>
				</div>
				<div class="btn-group">
					<a data-toggle="modal" data-target="#modal" id="edit" href="#" class="btn btn-small btn-info"><span class="glyphicon glyphicon-edit"></span> {{{ Lang::get('button.edit') }}}</a>
				</div>
			</div>
		</h3>
	</div>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" id="replaceableContent">
			</div>
		</div>
	</div>

	<!-- Tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		<li class=""><a href="#tab-contact" data-toggle="tab">Contact</a></li>
	</ul>
	<!-- ./ tabs -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<hr/>
					<h4><span class="label label-info">Personal Information</span></h4>
					<br/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-12 col-md-12">Full Name:</label>
						</div>
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-12 col-md-12">
								{{{ Input::old('first_name', isset($employee) ? $employee->first_name : null) }}}
							</label>
						</div>
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-12 col-md-12">
								{{{ Input::old('middle_name', isset($employee) ? $employee->middle_name : null) }}}
							</label>
						</div>
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-12 col-md-12">
								{{{ Input::old('last_name', isset($employee) ? $employee->last_name : null) }}}
							</label>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-6 col-sm-3">
							<label class="col-xs-6 col-md-6" for="employee_number">Employee Id:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('employee_number', isset($employee) ? $employee->employee_number : null) }}}
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<label class="col-xs-6 col-md-6" for="employee_code">Employee Code:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('employee_code', isset($employee) ? $employee->employee_code : null) }}}
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<label class="col-xs-6 col-md-6" for="nic_no">NIC Number:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('nic_no', isset($employee) ? $employee->nic_no : null) }}}
							</div>
						</div>

						<div class="col-xs-6 col-sm-3">
							<label class="col-xs-6 col-md-6" for="sin_no">SIN Number:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('sin_no', isset($employee) ? $employee->sin_no : null) }}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="driver_license_num">Driving License No.:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('driver_license_num', isset($employee) ? $employee->driver_license_num : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="other_id_no">Other ID:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('other_id_no', isset($employee) ? $employee->other_id_no : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="birthday">Birthday:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('birthday', isset($employee) ? $employee->birthday : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="gender_id">Gender:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($genders) ? $gender->name : ''}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="nationality_id">Nationality:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($nationality) ? $nationality->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="marriage_id">Marital Status:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($marriage) ? $marriage->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="nick_name">Nick Name:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('nick_name', isset($employee) ? $employee->nick_name : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="smoker">Smoker:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('smoker', (isset($employee) && $employee->smoker == 1)? 'Yes' : 'No') }}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<h4><span class="label label-info">Employee Detail Information</span></h4>
					<br/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="jobTitle">Job Title:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($jobTitle) ? $jobTitle->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="employeeType">Employee Status:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($employmentType) ? $employmentType->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="payGrade">Pay Grade:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($payGrade) ? $payGrade->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="joinedDate">Joined Date:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('joined_date', isset($employee) ? $employee->joined_date : null) }}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="department">Department:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($department) ? $department->name : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="supervisor">Supervisor:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($supervisor) ? ($supervisor->middle_name . ' ' . $supervisor->first_name . ' ' . $supervisor->last_name) : ''}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="note">Note:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('note', isset($employee) ? $employee->note : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="note">Publish:</label>
							<div class="col-xs-6 col-md-6">
								@if ($employee->published)
								{{{ Lang::get('general.yes') }}}
								@else
								{{{ Lang::get('general.no') }}}
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ general tab -->

		<!-- Contact tab -->
		<div class="tab-pane" id="tab-contact">
			<div class="row">

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<h4><span class="label label-info">Contact Information</span></h4>
					<br/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="street1">Address Line 1:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('street1', isset($employee) ? $employee->street1 : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="street2">Address Line 2:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('street2', isset($employee) ? $employee->street2 : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="street2">City:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('city', isset($employee) ? $employee->city : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="country_id">Country:</label>
							<div class="col-xs-6 col-md-6">
								{{ isset($country) ? $country->name : ''}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="zip_code">Postal/Zip Code:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('zip_code', isset($employee) ? $employee->zip_code : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="home_phone">Home Phone:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('home_phone', isset($employee) ? $employee->home_phone : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="mobile_phone">Mobile Phone:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('mobile_phone', isset($employee) ? $employee->mobile_phone : null) }}}
							</div>
						</div>

						<div class="col-xs-3 col-sm-3">
							<label class="col-xs-6 col-md-6" for="work_phone">Work Phone:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('work_phone', isset($employee) ? $employee->work_phone : null) }}}
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<hr/>
					<div class="row">
						<div class="col-xs-6 col-sm-6">
							<label class="col-xs-6 col-md-6" for="work_email">Work Email:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('work_email', isset($employee) ? $employee->work_email : null) }}}
							</div>
						</div>

						<div class="col-xs-6 col-sm-6">
							<label class="col-xs-6 col-md-6" for="other_email">Other Email:</label>
							<div class="col-xs-6 col-md-6">
								{{{ Input::old('other_email', isset($employee) ? $employee->other_email : null) }}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Contact tab -->
	</div>
	<!-- ./ tabs content -->
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		// Open modal to edit
		$('#edit').click(function(e){
			e.preventDefault();
			getAjaxContent("{{{ URL::to('admin/employees/' . $employee->id . '/edit') }}}");
			$('#modal').modal();
		});
	});

	function getAjaxContent(url){
		$.ajax({
			url: url,
			data: '',
			dataType: 'html',
			tryCount:0,     //current retry count
			retryLimit:3,   //number of retries on fail
			timeout: 5000,  //time before retry on fail
			success: function(returnedData) {
				var divContent = $('#replaceableContent');
				divContent.html(returnedData);
			},
			error: function(xhr, textStatus, errorThrown) {
				if (textStatus == 'timeout') { //if error is 'timeout'
					this.tryCount++;
					if (this.tryCount < this.retryLimit) {
						$.ajax(this);
						return;
					}
				}
			}
		});
	}
</script>
@stop
