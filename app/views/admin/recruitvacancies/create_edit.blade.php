<form id="recruitvacancy" name="recruitvacancy" class="form-horizontal" method="post" action="@if (isset($recruitvacancy)){{ URL::to('admin/recruitvacancies/' . $recruitvacancy->id . '/edit') }} @else {{ URL::to('admin/recruitvacancies/create') }} @endif " autocomplete="off">
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
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($recruitvacancy) ? $recruitvacancy->name : null) }}}" />
				<span class="has-error" id="error-name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="job_title_id">Job Title</label>
			<div class="col-md-9">
				{{ Form::select('job_title_id', $jobtitles, Input::old('job_title_id'), array('id' => 'job_title_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-job_title_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="hiring_manager_id">Hiring Manager</label>
			<div class="col-md-9">
				{{ Form::select('hiring_manager_id', $employees, Input::old('hiring_manager_id'), array('id' => 'hiring_manager_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-hiring_manager_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="hiring_manager_id">Contact Person</label>
			<div class="col-md-9">
				{{ Form::select('contact_person_id', $employees, Input::old('contact_person_id'), array('id' => 'contact_person_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-contact_person_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="amount">Amount</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="amount" id="amount" value="{{{ Input::old('amount', isset($recruitvacancy) ? $recruitvacancy->amount : null) }}}" />
				<span class="has-error" id="error-amount"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="description">Description</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="description" id="description">{{{ Input::old('description', isset($recruitvacancy) ? $recruitvacancy->description : null) }}}</textarea>
				<span class="has-error" id="error-description"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-9">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($recruitvacancy) ? $recruitvacancy->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($recruitvacancy) ? $recruitvacancy->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
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
		var url = '{{ URL::to("admin/recruitvacancies/create") }}';
	@else
	var url = '{{ URL::to("admin/recruitvacancies/" . $recruitvacancy->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#recruitvacancy')[0].reset();
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
			var form = $('form#recruitvacancy');
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
