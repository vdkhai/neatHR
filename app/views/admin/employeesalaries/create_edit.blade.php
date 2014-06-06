@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($employeesalary)){{ URL::to('admin/employeesalaries/' . $employee->id . '/edit/' . $employeesalary->id) }} @else {{ URL::to('admin/employeesalaries/' . $employee->id . '/create') }} @endif" autocomplete="off" enctype="multipart/form-data">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- employeesalaries.pay_frequency_id -->
				<div class="form-group {{{ $errors->has('pay_frequency_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="pay_frequency_id">Pay Frequency</label>
					<div class="col-md-6">
						{{ Form::select('pay_frequency_id', $payfrequencies, Input::old('pay_frequency_id'), array('id' => 'pay_frequency_id', 'class' => 'form-control')) }}
						{{{ $errors->first('pay_frequency_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeesalaries.pay_frequency_id -->

				<!-- employeesalaries.currency_id -->
				<div class="form-group {{{ $errors->has('currency_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="currency_id">Currency</label>
					<div class="col-md-6">
						{{ Form::select('currency_id', $currencies, Input::old('currency_id'), array('id' => 'currency_id', 'class' => 'form-control')) }}
						{{{ $errors->first('currency_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeesalaries.currency_id -->

				<!-- employeesalaries.amount -->
				<div class="form-group {{{ $errors->has('amount') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="amount">Amount</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="amount" id="amount" value="{{{ Input::old('amount', isset($employeesalary) ? $employeesalary->amount : null) }}}" />
						{{{ $errors->first('amount', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeesalaries.amount -->

				<!-- employeesalaries.detail -->
				<div class="form-group {{{ $errors->has('detail') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="detail">Note</label>
					<div class="col-md-6">
						<textarea class="form-control" rows="3" name="detail" id="detail">{{{ Input::old('detail', isset($employeesalary) ? $employeesalary->detail : null) }}}</textarea>
						{{{ $errors->first('detail', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ employeesalaries.detail -->

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
