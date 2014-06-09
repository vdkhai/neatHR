<form id="employeecertification" name="employeecertification" class="form-horizontal" method="post" action="@if (isset($employeecertification)){{ URL::to('admin/employeecertifications/' . $employee->id . '/edit/' . $employeecertification->id) }} @else {{ URL::to('admin/employeecertifications/' . $employee->id . '/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="certification_id">Certification</label>
			<div class="col-md-9">
				{{ Form::select('certification_id', $certifications, Input::old('certification_id'), array('id' => 'certification_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-certification_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="institute">Institute</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="institute" id="institute" value="{{{ Input::old('institute', isset($employeecertification) ? $employeecertification->institute : null) }}}" />
				<span class="has-error" id="error-institute"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="start_date">Start Date</label>
			<div class="col-md-5 input-group input-append">
				<input class="form-control start_date datefield" id="start_date" name="start_date" data-date-viewmode="years" data-date-format="yyyy-mm-dd"
					type="text" value="{{{ Input::old('start_date', isset($employeecertification) ? $employeecertification->start_date : '') }}}">
				<span class="input-group-addon date "><span class="glyphicon glyphicon-calendar"></span></span>
				<span class="has-error" id="error-start_date"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="end_date">End Date</label>
			<div class="col-md-5 input-group input-append">
				<input class="form-control end_date datefield" id="end_date" name="end_date" data-date-viewmode="years" data-date-format="yyyy-mm-dd"
					type="text" value="{{{ Input::old('end_date', isset($employeecertification) ? $employeecertification->end_date : '') }}}">
				<span class="input-group-addon date "><span class="glyphicon glyphicon-calendar"></span></span>
				<span class="has-error" id="error-end_date"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="note">Note</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeecertification) ? $employeecertification->note : null) }}}</textarea>
				<span class="has-error" id="error-note"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-9">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($employeecertification) ? $employeecertification->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($employeecertification) ? $employeecertification->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
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
		var url = '{{ URL::to("admin/employeecertifications/" . $employee->id . "/create") }}';
	@else
	var url = '{{ URL::to("admin/employeecertifications/" . $employee->id . "/edit/" . $employeecertification->id) }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#employeecertification')[0].reset();
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
			var form = $('form#employeecertification');
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

	$('#start_date').datepicker();
	$('#end_date').datepicker();
</script>
@section('scripts')
