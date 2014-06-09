<form id="recruitcandidate" name="recruitcandidate" class="form-horizontal" method="post" action="@if (isset($recruitcandidate)){{ URL::to('admin/recruitcandidates/' . $recruitcandidate->id . '/edit') }} @else {{ URL::to('admin/recruitcandidates/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="first_name">First Name</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name', isset($recruitcandidate) ? $recruitcandidate->first_name : null) }}}" />
				<span class="has-error" id="error-first_name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="middle_name">Middle Name</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="middle_name" id="middle_name" value="{{{ Input::old('middle_name', isset($recruitcandidate) ? $recruitcandidate->middle_name : null) }}}" />
				<span class="has-error" id="error-middle_name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="last_name">Last Name</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name', isset($recruitcandidate) ? $recruitcandidate->last_name : null) }}}" />
				<span class="has-error" id="error-last_name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="nationality_id">Nationality</label>
			<div class="col-md-9">
				{{ Form::select('nationality_id', $nationalities, Input::old('nationality_id'), array('id' => 'nationality_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-nationality_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="work_email">Work Email</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="work_email" id="work_email" value="{{{ Input::old('work_email', isset($recruitcandidate) ? $recruitcandidate->work_email : null) }}}" />
				<span class="has-error" id="error-work_email"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="other_email">Other Email</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="other_email" id="other_email" value="{{{ Input::old('other_email', isset($recruitcandidate) ? $recruitcandidate->other_email : null) }}}" />
				<span class="has-error" id="error-other_email"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="contact_number">Contact Number</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="contact_number" id="contact_number" value="{{{ Input::old('contact_number', isset($recruitcandidate) ? $recruitcandidate->contact_number : null) }}}" />
				<span class="has-error" id="error-contact_number"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="recruitment_status_id">Recruitment Status</label>
			<div class="col-md-9">
				{{ Form::select('recruitment_status_id', $recruitmentStatus, Input::old('recruitment_status_id'), array('id' => 'recruitment_status_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-recruitment_status_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="application_way">Application Way</label>
			<div class="col-md-9">
				<select class="form-control" name="application_way" id="application_way">
					<option value="1"{{{ (Input::old('application_way', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('Normal') }}}</option>
					<option value="0"{{{ (Input::old('application_way', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('Online') }}}</option>
				</select>
				<span class="has-error" id="error-application_way"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="keywords">Key Words</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="keywords" id="keywords" value="{{{ Input::old('keywords', isset($recruitcandidate) ? $recruitcandidate->keywords : null) }}}" />
				<span class="has-error" id="error-keywords"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="application_date">Application Date</label>
			<div class="col-md-5 input-group input-append">
				<input class="form-control application_date datefield" id="application_date" name="application_date" data-date-viewmode="years" data-date-format="yyyy-mm-dd"
					type="text" value="{{{ Input::old('application_date', isset($recruitcandidate) ? $recruitcandidate->application_date : '') }}}">
				<span class="input-group-addon date "><span class="glyphicon glyphicon-calendar"></span></span>
				<span class="has-error" id="error-application_date"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="comment">Comment</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="comment" id="comment">{{{ Input::old('comment', isset($recruitcandidate) ? $recruitcandidate->comment : null) }}}</textarea>
				<span class="has-error" id="error-comment"></span>
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
		var url = '{{ URL::to("admin/recruitcandidates/create") }}';
	@else
		var url = '{{ URL::to("admin/recruitcandidates/" . $recruitcandidate->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#recruitcandidate')[0].reset();
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
			var form = $('form#recruitcandidate');
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

	$('#application_date').datepicker();
</script>
@section('scripts')