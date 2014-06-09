<form id="employeeemergencycontact" name="employeeemergencycontact" class="form-horizontal" method="post" action="@if (isset($employeeemergencycontact)){{ URL::to('admin/employeeemergencycontacts/' . $employee->id . '/edit/' . $employeeemergencycontact->id) }} @else {{ URL::to('admin/employeeemergencycontacts/' . $employee->id . '/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="name">{{{ Lang::get('form.name') }}}</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($employeeemergencycontact) ? $employeeemergencycontact->name : null) }}}" />
				<span class="has-error" id="error-name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="relationship">Relationship</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="relationship" id="relationship" value="{{{ Input::old('relationship', isset($employeeemergencycontact) ? $employeeemergencycontact->relationship : null) }}}" />
				<span class="has-error" id="error-relationship"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="home_phone">Home phone</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="home_phone" id="home_phone" value="{{{ Input::old('home_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->home_phone : null) }}}" />
				<span class="has-error" id="error-home_phone"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="work_phone">Work phone</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="work_phone" id="work_phone" value="{{{ Input::old('work_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->work_phone : null) }}}" />
				<span class="has-error" id="error-work_phone"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="mobile_phone">Mobile phone</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="mobile_phone" id="mobile_phone" value="{{{ Input::old('mobile_phone', isset($employeeemergencycontact) ? $employeeemergencycontact->mobile_phone : null) }}}" />
				<span class="has-error" id="error-mobile_phone"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="note">Note</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="note" id="note">{{{ Input::old('note', isset($employeeemergencycontact) ? $employeeemergencycontact->note : null) }}}</textarea>
				<span class="has-error" id="error-note"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-9">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($employeeemergencycontact) ? $employeeemergencycontact->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($employeeemergencycontact) ? $employeeemergencycontact->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
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
		var url = '{{ URL::to("admin/employeeemergencycontacts/" . $employee->id . "/create") }}';
	@else
	var url = '{{ URL::to("admin/employeeemergencycontacts/" . $employee->id . "/edit/" . $employeeemergencycontact->id) }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#employeeemergencycontact')[0].reset();
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
			var form = $('form#employeeemergencycontact');
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

