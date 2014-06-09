<form id="employeesalary" name="employeesalary" class="form-horizontal" method="post" action="@if (isset($employeesalary)){{ URL::to('admin/employeesalaries/' . $employee->id . '/edit/' . $employeesalary->id) }} @else {{ URL::to('admin/employeesalaries/' . $employee->id . '/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="pay_frequency_id">Pay Frequency</label>
			<div class="col-md-9">
				{{ Form::select('pay_frequency_id', $payfrequencies, Input::old('pay_frequency_id'), array('id' => 'pay_frequency_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-pay_frequency_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="currency_id">Currency</label>
			<div class="col-md-9">
				{{ Form::select('currency_id', $currencies, Input::old('currency_id'), array('id' => 'currency_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-currency_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="amount">Amount</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="amount" id="amount" value="{{{ Input::old('amount', isset($employeesalary) ? $employeesalary->amount : null) }}}" />
				<span class="has-error" id="error-amount"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="detail">Note</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="detail" id="detail">{{{ Input::old('detail', isset($employeesalary) ? $employeesalary->detail : null) }}}</textarea>
				<span class="has-error" id="error-detail"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-9">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($employeesalary) ? $employeesalary->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($employeesalary) ? $employeesalary->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
				</select>
			</div>
		</div>
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
		var url = '{{ URL::to("admin/employeesalaries/" . $employee->id . "/create") }}';
	@else
	var url = '{{ URL::to("admin/employeesalaries/" . $employee->id . "/edit/" . $employeesalary->id) }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#employeesalary')[0].reset();
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
			var form = $('form#employeesalary');
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
</script>
@section('scripts')
